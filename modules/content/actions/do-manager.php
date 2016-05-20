<?php

    _subModule('content', 'block');
    $block_obj = new block();

    _module('master');
    $master_obj = new master();

    function checkSum($filename) {
        $sha1 = sha1($filename);
        $number = preg_replace("/[^0-9,.]/", "", $sha1);
        $code = substr($number, 5, 16);
        return $code;
    }

    function storageName($filename, $size) {
        $code = checkSum($filename);
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $new_file = $code.'_'.TIME.'_'.$size.'.'.$ext;
        return $new_file;
    }

    $upload_path = UPLOAD_PATH.'content/';

    if(!file_exists($upload_path.'thumbs/')) {
        mkdir($upload_path.'thumbs/', 0777);
    }

    if(!file_exists($upload_path.'medium/')) {
        mkdir($upload_path.'medium/', 0777);
    }

    $id = isset($_POST['id']) ? $_POST['id'] : 0;
    $slug = String::generateSEOString($_POST['title']);
    $slug = generateUniqueName($slug, $id, 'mst_content', 'strSlug', 'id', '1');

    if (isset($_POST['final_tag']) && !empty($_POST['final_tag'])) {

        $tags = explode(',', $_POST['final_tag']);
        foreach($tags as $tag) {

            $where="strTag = '" . $tag . "' and tinStatus='1' and tinStatus = '2'";
            $get_tag = $master_obj->getMasters($where,'tag');

            if($get_tag == 404){

                $tag_insert = $master_obj->insertData(['tag_name' => $tag], 'tag');
                $tag_id[] = $tag_insert;
            } else {
                $tag_id[] = $get_tag[0]['id'];
            }
        }
    }

    if(isset($_POST['action']) && !empty($_POST['action'])){

        if($_POST['action'] == 'add-content') {

            $title = $_POST['title'];

            $array_search = array(':status' => '2', ':title' => $title);
            $cont_obj->setPrepare($array_search);
            $result = $cont_obj->getContentCount("tinStatus != :status and strTitle = :title");

            if($result != 0) {
                $_SESSION[PF.'MSG'] = "This ".$_POST['title']." is already available";
                _locate(SITE_URL."content/add-content");
            } else {

                $data = array(
                    'strTitle' => $_POST['title'],
                    'strContentType' => $_POST['cont_type'],
                    'dtContent' => date('Y-m-d', strtotime($_POST['content_date'])),
                    'strSlug' => $slug,
                    'dtiCreated' => TODAY_DATETIME,
                    'idCreatedBy' => $_SESSION[PF . 'USERID']);
                $content_id = $cont_obj->insertData($data);

                if (isset($tag_id) && !empty($tag_id)) {

                    foreach($tag_id as $tag_id_value) {
                        $rel_tag_data = [
                            'intTagID' => $tag_id_value,
                            'intContentID' => $content_id
                        ];

                        $cont_obj->insertRelTagData($rel_tag_data);

                    }

                }

                if(isset($_POST['block'])) {

                    foreach($_POST['block'] as $pos => $block) {

                        $block_id = $_POST['block_id'][$block];

                        $block_data = array(
                            'content' => $content_id,
                            'block' => $block_id,
                            'position' => $pos
                        );

                        $content_block_id = $block_obj->insertContentBlock($block_data);

                        if(isset($_POST[$block][$pos]) && $block == 'text') {

                            $block_details = array(
                                'details' => $_POST[$block][$pos],
                                'content_block' => $content_block_id
                            );

                            $block_details_id = $block_obj->insertBlockDetails($block_details);

                        }

                        if(isset($_FILES[$block]['name'][$pos]) && $block == 'image') {

                            foreach($_FILES[$block]['name'][$pos] as $count => $filename) {

                                $file_block = $_FILES[$block];

                                if (!empty($filename)) {
                                    if (File::isAllowedType($file_block['type'][$pos][$count])) {
                                        $imgurl = storageName($filename, $file_block['size'][$pos][$count]);
                                        if(move_uploaded_file($file_block['tmp_name'][$pos][$count], $upload_path . $imgurl)) {
                                            chmod($upload_path . $imgurl, 0777);
                                            createthumb($upload_path . $imgurl, $upload_path . 'thumbs/' . $imgurl, 200, 0, false);
                                            createthumb($upload_path . $imgurl, $upload_path . 'medium/' . $imgurl, 400, 0, false);

                                            $block_details = array(
                                                'details' => $imgurl,
                                                'content_block' => $content_block_id
                                            );

                                            $block_details_id = $block_obj->insertBlockDetails($block_details);
                                        } else {
                                            $_SESSION[PF.'ERROR'] = 'ERROR! unable to upload file';
                                        }
                                    } else {
                                        $_SESSION[PF . 'ERROR'] = "ERROR! wrong file type";
                                    }
                                } else {
                                    $imgurl = null;
                                }

                            }

                        }

                    }

                }

                if ($content_id) {
                    $_SESSION[PF . 'MSG'] = "<strong>" . $_POST['title'] . "</strong> has been successfully added";
                }else {
                    $_SESSION[PF . 'ERROR'] = "Error while Inserting data";
                }
            }
        }

        if($_POST['action'] == 'edit-content') {

            $title = $_POST['title'];

            $array_search = array(':status' => '2', ':title' => $title, ':id' => $id);
            $cont_obj->setPrepare($array_search);
            $result = $cont_obj->getContentCount("tinStatus != :status and strTitle = :title and id != :id");

            if($result != 0) {
                $_SESSION[PF.'MSG'] = "This ".$_POST['title']." is already available";
                _locate(SITE_URL."content/add-content");
            } else {

                $data = array(
                    'strTitle' => $_POST['title'],
                    'strContentType' => $_POST['cont_type'],
                    'dtContent' => date('Y-m-d', strtotime($_POST['content_date'])),
                    'strSlug' => $slug,
                    'dtiModified' => TODAY_DATETIME,
                    'idModifiedBy' => $_SESSION[PF . 'USERID'],
                    'id' => $id);
                $cont_obj->updateData($data);

                if (isset($tag_id) && !empty($tag_id)) {

                    $cont_obj->deleteTag("intContentID = " . $id);

                    foreach($tag_id as $tag_id_value) {
                        $rel_tag_data = [
                            'intTagID' => $tag_id_value,
                            'intContentID' => $id
                        ];

                        $cont_obj->insertRelTagData($rel_tag_data);

                    }

                }

                if(isset($_POST['block'])) {

                    foreach($_POST['block'] as $pos => $block) {

                        $block_id = $_POST['block_id'][$block];

                        $block_data = array(
                            'content' => $content_id,
                            'block' => $block_id,
                            'position' => $pos
                        );

                        $content_block_id = $block_obj->insertContentBlock($block_data);

                        if(isset($_POST[$block][$pos]) && $block == 'text') {

                            $block_details = array(
                                'details' => $_POST[$block][$pos],
                                'content_block' => $content_block_id
                            );

                            $block_details_id = $block_obj->insertBlockDetails($block_details);

                        }

                        if(isset($_FILES[$block]['name'][$pos]) && $block == 'image') {

                            foreach($_FILES[$block]['name'][$pos] as $count => $filename) {

                                $file_block = $_FILES[$block];

                                if (!empty($filename)) {
                                    if (File::isAllowedType($file_block['type'][$pos][$count])) {
                                        $imgurl = storageName($filename, $file_block['size'][$pos][$count]);
                                        if(move_uploaded_file($file_block['tmp_name'][$pos][$count], $upload_path . $imgurl)) {
                                            chmod($upload_path . $imgurl, 0777);
                                            createthumb($upload_path . $imgurl, $upload_path . 'thumbs/' . $imgurl, 200, 0, false);
                                            createthumb($upload_path . $imgurl, $upload_path . 'medium/' . $imgurl, 400, 0, false);

                                            $block_details = array(
                                                'details' => $imgurl,
                                                'content_block' => $content_block_id
                                            );

                                            $block_details_id = $block_obj->insertBlockDetails($block_details);
                                        } else {
                                            $_SESSION[PF.'ERROR'] = 'ERROR! unable to upload file';
                                        }
                                    } else {
                                        $_SESSION[PF . 'ERROR'] = "ERROR! wrong file type";
                                    }
                                } else {
                                    $imgurl = null;
                                }

                            }

                        }

                    }

                }

                if ($content_id) {
                    $_SESSION[PF . 'MSG'] = "<strong>" . $_POST['title'] . "</strong> has been successfully added";
                }else {
                    $_SESSION[PF . 'ERROR'] = "Error while Inserting data";
                }
            }
        }

		if($_POST['action'] == 'add') {

			$title=$_POST['title'];

			$array_search = array(':enmDeleted' => '0');
			$cont_obj->setPrepare($array_search);
			$result = $cont_obj->getContentCount("enmDeleted = :enmDeleted");

			if (isset($_FILES['imgurl']['name']) && !empty($_FILES['imgurl']['name'])) {
				if (File::isAllowedType($_FILES['imgurl']['type'])) {
					if ($_POST['cont_type'] == 'n') {
						$upload_path = UPLOAD_PATH . 'content/news/';
					} elseif ($_POST['cont_type'] == 'p') {
						$upload_path = UPLOAD_PATH . 'content/pressreleases/';
					} elseif ($_POST['cont_type'] == 'e') {
						$upload_path = UPLOAD_PATH . 'content/events/';
					}
					$time = time();
					move_uploaded_file($_FILES['imgurl']['tmp_name'], $upload_path . $time . '_' . $_FILES['imgurl']['name']);
					$imgurl = $time . '_' . $_FILES['imgurl']['name'];
					chmod($upload_path . $time . '_' . $_FILES['imgurl']['name'], 0777);
					createthumb($upload_path . $imgurl, $upload_path . 'thumbs/' . $imgurl, 35, 35, false);
					createthumb($upload_path . $imgurl, $upload_path . 'medium/' . $imgurl, 140, 140, false);
				} else {
					$_SESSION[PF . 'ERROR'] = "wrong file type";
					_locate(SITE_URL . "content/add");
				}
			} else {
				$imgurl = null;
			}


			if (isset($_FILES['pdf_file']['name']) && !empty($_FILES['pdf_file']['name'])) {
				$upload_path = UPLOAD_PATH . 'content/pdf/';
				$time = time();
				move_uploaded_file($_FILES['pdf_file']['tmp_name'], $upload_path . $time . '_' . $_FILES['pdf_file']['name']);
				$pdfurl = $time . '_' . $_FILES['pdf_file']['name'];
			} else {
				$pdfurl = null;
			}

			$id = isset($_POST['id']) ? $_POST['id'] : 0;
			$slug = String::generateSEOString($_POST['title']);
			$slug = generateUniqueName($slug, $id, 'mst_content', 'strSlug', 'id', '1');

			$data = array(
				'strTitle' => $_POST['title'],
				'strContentType' => $_POST['cont_type'],
				'dtContent' => date('Y-m-d', strtotime($_POST['content_date'])),
				'strDescription' => $_POST['content'],
				'strSlug' => $slug,
				'dtiCreated' => TODAY_DATETIME,
				'idCreatedBy' => $_SESSION[PF . 'USERID'],
				'strContentImg' => $imgurl,
				'strPdfFile' => $pdfurl);

			if (isset($_POST['url']) && !empty($_POST['url'])) {
				$data['strUrl'] = $_POST['url'];
			}

			$rsData = $cont_obj->insertData($data);
			//strat code for insert category id related to content id into rel_content table
			if (isset($_POST['sel_category']) && !empty($_POST['sel_category'])) {
				for ($i = 0; $i < count($_POST['sel_category']); $i++) {
					$content_data = array(
						'intCategoryID' => $_POST['sel_category'][$i],
						'intContentID' => $rsData,
						'dtiCreated' => TODAY_DATETIME,
						'idCreatedBy' => $_SESSION[PF . 'USERID']);
					$rsContentData = $cont_obj->insertCategoryData($content_data);
				}
			}


            if (isset($tag_id) && !empty($tag_id)) {


                foreach($tag_id as $tag_id_value) {
                    $rel_tag_data = [
                        'intTagID' => $tag_id_value,
                        'intContentID' => $rsData
                    ];

                    $cont_obj->insertRelTagData($rel_tag_data);

                }

            }


			if ($rsContentData) {
				$_SESSION[PF . 'MSG'] = "<strong>" . $_POST['title'] . "</strong> has been successfully added";
		    }else {
			    $_SESSION[PF . 'ERROR'] = "Error while Inserting data";
			}
		 //}
		}

        if($_POST['action'] == 'edit') {

			$title = $_POST['title'];

			/*$array_search = array('enmDeleted' => '0','strTitle' => $title,'id'=>$_POST['id']);

			$result = $cont_obj->getContentCount($array_search);*/
			$array_search = array(':enmDeleted' => '0', ':id' => $_POST['id']);
			$cont_obj->setPrepare($array_search);
			$result = $cont_obj->getContentCount("enmDeleted = :enmDeleted and id != :id");


            $id = isset($_POST['id']) ? $_POST['id'] : 0;

            if (isset($_FILES['imgurl']['name']) && !empty($_FILES['imgurl']['name'])) {
                if (File::isAllowedType($_FILES['imgurl']['type'])) {
                    if ($_POST['cont_type'] == 'n') {
                        $upload_path = UPLOAD_PATH . 'content/news/';
                    } elseif ($_POST['cont_type'] == 'p') {
                        $upload_path = UPLOAD_PATH . 'content/pressreleases/';
                    } elseif ($_POST['cont_type'] == 'e') {
                        $upload_path = UPLOAD_PATH . 'content/events/';
                    }
                    //$upload_path = $module_path.'/upload/';
                    $time = time();
                    move_uploaded_file($_FILES['imgurl']['tmp_name'], $upload_path . $time . '_' . $_FILES['imgurl']['name']);
                    $imgurl = $time . '_' . $_FILES['imgurl']['name'];
                    chmod($upload_path . $time . '_' . $_FILES['imgurl']['name'], 0777);
                    createthumb($upload_path . $imgurl, $upload_path . 'thumbs/' . $imgurl, 35, 35, false);
                    createthumb($upload_path . $imgurl, $upload_path . 'medium/' . $imgurl, 140, 140, false);
                } else {
                    $_SESSION[PF . 'ERROR'] = "wrong file type";
                    _locate(SITE_URL . "content/list");
                }
            } elseif (isset($_POST['oldfile']) && !empty($_POST['oldfile'])) {
                $imgurl = $_POST['oldfile'];
            } else {
                $imgurl = null;
            }

            //code for pdf file start here
            if (isset($_FILES['pdf_file']['name']) && !empty($_FILES['pdf_file']['name'])) {
                //$upload_path = $module_path . 'upload/pdf/';
                $upload_path = UPLOAD_PATH . 'content/pdf/';
                $time = time();
                move_uploaded_file($_FILES['pdf_file']['tmp_name'], $upload_path . $time . '_' . $_FILES['pdf_file']['name']);
                $pdfurl = $time . '_' . $_FILES['pdf_file']['name'];

            } elseif (isset($_POST['h_pdffile']) && !empty($_POST['h_pdffile'])) {
                $pdfurl = $_POST['h_pdffile'];
            } else {
                $pdfurl = null;
            }
            //end here

            $slug = String::generateSEOString($_POST['title']);
            $slug = generateUniqueName($slug, $id, 'mst_content', 'strSlug', 'id', '1');


            $modified = array(
                'strTitle' => $_POST['title'],
                'strContentType' => $_POST['cont_type'],
                'dtContent' => date('Y-m-d', strtotime($_POST['content_date'])),
                'strDescription' => $_POST['content'],
                'strSlug' => $slug,
                'dtiModified' => TODAY_DATETIME,
                'idModifiedBy' => $_SESSION[PF . 'USERID'],
                'strContentImg' => $imgurl,
                'strPdfFile' => $pdfurl,
                'id' => $id);

            if (isset($_POST['url']) && !empty($_POST['url'])) {
                $modified['strUrl'] = $_POST['url'];
            }
            //pr($modified);exit;
            $rsData = $cont_obj->updateData($modified);

            if (isset($tag_id) && !empty($tag_id)) {

                $cont_obj->deleteTag("intContentID = " . $id);

                foreach($tag_id as $tag_id_value) {
                    $rel_tag_data = [
                        'intTagID' => $tag_id_value,
                        'intContentID' => $_POST['id']
                    ];

                    $cont_obj->insertRelTagData($rel_tag_data);

                }

            }

            //End here

            if ($rsData) {
                $_SESSION[PF . 'MSG'] = "<strong>" . $_POST['title'] . "</strong> has been successfully Updated";
            } else {
                $_SESSION[PF . 'ERROR'] = "Error while Updateing data";
            }
		}
		_locate(SITE_URL."content/list");
	}
?>