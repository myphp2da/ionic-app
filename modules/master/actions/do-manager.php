<?php

	if(isset($_POST['type'])) {

		$type = _b64($_POST['type'], 'decode');

		if(in_array($type, $master_obj::$_have_photo)) {

			$upload_path = UPLOAD_PATH . $type . '/';

			if (!file_exists($upload_path)) {
				mkdir($upload_path, 0777);
			}

			if (!file_exists($upload_path . 'thumbs/')) {
				mkdir($upload_path . 'thumbs/', 0777);
			}

			if (!file_exists($upload_path . 'medium/')) {
				mkdir($upload_path . 'medium/', 0777);
			}
		}
	}

    $imgurl = (isset($_POST['old_imgurl']) && !empty($_POST['old_imgurl'])) ? $_POST['old_imgurl'] : null;
    if (isset($_FILES['imgurl']['name']) && !empty($_FILES['imgurl']['name'])) {
        if (File::isAllowedType($_FILES['imgurl']['type'])) {
            $imgurl = File::storageName($_FILES['imgurl']['name'], $_FILES['imgurl']['size']);
            if(move_uploaded_file($_FILES['imgurl']['tmp_name'], $upload_path . $imgurl)) {
                chmod($upload_path . $imgurl, 0777);
                createthumb($upload_path . $imgurl, $upload_path . 'thumbs/' . $imgurl, 200, 0, false);
                createthumb($upload_path . $imgurl, $upload_path . 'medium/' . $imgurl, 400, 0, false);
            }
        } else {
            $_SESSION[PF . 'ERROR'] = "wrong file type";
            $imgurl = null;
        }
    }

	if(isset($_POST['action']) && !empty($_POST['action'])){
		
		if(isset($_POST['type'])) {

			$type = _b64($_POST['type'], 'decode');

			$input_name = str_replace('-', '_', $type).'_name';
			$name = ucwords(str_replace('-', ' ', $type));

			$db_name_field = 'str'.str_replace(' ', '', $name);

			if($_POST['action'] == 'add')
			{
				$type_name = $_POST[$input_name];
                $where_cond = $db_name_field." = '$type_name' and tinStatus != '2'";
				$result = $master_obj->getMasterCount($where_cond, $type);

				if($result!=0) {
					$_SESSION[PF.'MSG'] = "This ".$type_name." ".$type." is already taken!";
					_locate(SITE_URL."master/add?t="._b64($type));
				} 
				else{

					$data = $_POST;
					if(in_array($type, $master_obj::$_have_photo)) {
						$data['imgname'] = $imgurl;
					}

					$type_id = $master_obj->insertData($data, $type);
					if($type_id){
						$_SESSION[PF.'MSG']  = "<strong>".$_POST[$input_name]."</strong> has been successfully added";
					}else {
						$_SESSION[PF.'MSG']  = "Error while inserting data";
					}
				}
			}
			
			if($_POST['action'] == 'edit')
			{
				$input_name = str_replace('-', '_', $type).'_name';
				$name = ucwords(str_replace('-', ' ', $type));
				$db_name_field = 'str'.str_replace(' ', '', $name);

				$type_name = $_POST[$input_name];
				$where_cond = $db_name_field." = '$type_name' and tinStatus != '2' and id != ".$_POST['ID'];
				$result = $master_obj->getMasterCount($where_cond, $type);

				$type_id = $_POST['ID'];

				if($result!=0){
					$_SESSION[PF.'MSG'] = "This ".$type_name." ".$type." is already taken!";
					_locate(SITE_URL."master/edit?t="._b64($type)."&id=".$_POST['ID']);

				} else {

					$data = $_POST;
					if(in_array($type, $master_obj::$_have_photo)) {
						$data['imgname'] = $imgurl;
					}  //pr($data); exit;

					$rsData = $master_obj->updateData($data, $type);
					if ($rsData) {
						$_SESSION[PF . 'MSG'] = "<strong>" . $_POST[$input_name] . "</strong> has been successfully update";
					} /*else {
						$_SESSION[PF . 'MSG'] = "Error while update data";
					}*/
				}
			}
			
			if($_POST['action'] == 'bulk-add')
			{
				$names = explode("\n", $_POST['names']);
				
				if(sizeof($names) > 0) {	
					foreach($names as $iname) {
						$data[$name] = $iname;
						if(isset($_POST['parent'])) $data['parent'] = $_POST['parent'];
						$master_obj->insertData($data, $_POST['type']);
					}
					$_SESSION[PF.'MSG']  = "All categories have been successfully submitted";
				}
			}

			_class('DbDate');
			$dbDateObj = new DbDate();

			$dbDateObj->setAccount('account', $_SESSION[PF.'USERID']);

			$dateArray = array(
				'type' => $_POST['type'],
				'id' => $type_id,
				'date_type' => ($data['action'] == 'add') ? 'created' : 'modified',
				'remarks' => $_SESSION[PF . 'MSG']
			);

			$dbDateObj->logDate($dateArray);
			
			_locate($module_url."/list?t=".$_POST['type']);
			
		}
	}