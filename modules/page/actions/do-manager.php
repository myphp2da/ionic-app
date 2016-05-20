<?php
if(isset($_POST['action']) && !empty($_POST['action'])){

    if($_POST['action'] == 'save-contact') {

        $contact_data = $_POST;
        $contact = $page_obj->saveContact($contact_data);
        if($contact){

            // Send mail to administrator
            _class('emailer');
            $emailObj = new emailer();

            $email_data = array(
                'theme_url' => $theme_url,
                'fullname' => ADMIN_NAME,
                'to' => 'mitesh@nascentinfo.com',
                'contact_name' => $_POST['name'],
                'contact_email' => $_POST['email'],
                'contact_subject' => $_POST['subject'],
                'contact_message' => $_POST['message'],
                'subject' => SITE_TITLE.' : New Contact Received ('.$_POST['name'].')'
            ); //pr($email_data);
            $emailObj->sendMail('contact', $email_data);

            $_SESSION[PF.'MSG']  = "Your contact has been successfully saved";
        } else {
            $_SESSION[PF.'ERROR']  = "Error while inserting data";
        }

        _locate(SITE_URL.'confirm');
    }

		if(isset($_POST['action']) && $_POST['action'] == 'add'){

			$title=$_POST['title'];
			$where_cond = "tinStatus = '2' and strTitle='$title'";
			$result = $page_obj->getPagesCount($where_cond);

			if($result!=0) {
				$_SESSION[PF.'MSG'] = "This ".$_POST['title']." is already taken!";
				_locate(SITE_URL."page/add");
			}else {


				$slug = String::generateSEOString($_POST['title']);
				$slug = generateUniqueName($slug, 0, 'mst_pages', 'strSlug', 'id', '1');

				$insert_data = array('strSlug' => $slug,
					'strTitle' => $_POST['title'],
					'txtDescription' => $_POST['content'],
					'txtShortDescription' => $_POST['shortcontent'],
					'idCreatedBy' => $_SESSION[PF . 'USERID'],
					'dtiCreated' => TODAY_DATETIME,
					'strTemplate' => $_POST['page_template']);
//pr($insert_data);
				$rsData = $page_obj->insertData($insert_data);
				if ($rsData) {
					$_SESSION[PF . 'MSG'] = "<strong>" . $_POST['title'] . "</strong> has been successfully Added";
				} else {
					$_SESSION[PF . 'ERROR'] = "Error while inserting data";
				}
			}
		}
		else if(isset($_POST['action']) && $_POST['action'] == 'edit')
		{
			$id = isset($_POST['id']) ? $_POST['id'] : 0;


			$title=$_POST['title'];
			$where_cond = "tinStatus = '2' and strTitle='$title' and id!=".$_POST['id'];
			$result = $page_obj->getPagesCount($where_cond);

			if($result!=0) {
				$_SESSION[PF.'MSG'] = "This ".$_POST['title']." is already taken!";
				_locate(SITE_URL."page/edit?id=".$_POST['id']);
			}else {

				$slug = String::generateSEOString($_POST['title']);
				$slug = generateUniqueName($slug, $id, 'mst_pages', 'strSlug', 'id', '1');

				$modified = array('id' => $id,
					'strSlug' => $slug,
					'strTitle' => $_POST['title'],
					'txtDescription' => $_POST['content'],
					'txtShortDescription' => $_POST['shortcontent'],
					'strTemplate' => $_POST['page_template'],
					'dtiModified' => TODAY_DATETIME,
					'idModifiedBy' => $_SESSION[PF . 'USERID']);

				$rsData = $page_obj->updateData($modified);
				if ($rsData) {
					$_SESSION[PF . 'MSG'] = "<strong>" . $_POST['title'] . "</strong> has been successfully Updated";
				} else {
					$_SESSION[PF . 'ERROR'] = "Error while inserting data";
				}
			}
		}
		_locate(SITE_URL."page/list");
}
?>