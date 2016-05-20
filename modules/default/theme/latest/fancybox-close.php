<?php /*print_r($_SESSION);*/ if(isset($_SESSION[PF.'MSG']) || isset($_SESSION[PF.'ERROR'])) { ?>
<script type="text/javascript">parent.location.reload(); parent.$.fancybox.close();</script>
<?php } else { include_once(SITE_PATH.'errors/404.php'); };?>