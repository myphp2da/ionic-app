<?php

$where = "p.strSlug='$req[slug]'";
$page = $page_obj->getPage($where);
echo $theme_url.'front'.'/'.$page['strSlug'];
/*//_e($module_url);*/?><!--/front/--><?php /*_e($page['strTemplate']);*/
//echo $module_url.'/'.$page['strTemplate'];
?>