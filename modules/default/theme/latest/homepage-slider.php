<?php 
/*
Widget Name: Volunteer Homepage Slider
Widget Type: main-homepage
*/
 	if(!class_exists('default')) _module('default');
    $defObj = new defaultclass();
	
	$rsData = $defObj->homePageSlider();
	$image_url = SITE_URL.'default/upload/default/large/';
	$image_path = SITE_PATH.'default/upload/default/large/';

	foreach($rsData as $value) {
		if(file_exists($image_path.$value['strImageName'])) {
?>
	  <li>
		<img src="<?php echo $image_url.$value['strImageName'];?>">      	  	
	  </li>
<?php
		}
	}
?>