<?php
/*
Widget Name: Search Box
Widget Type: nothing
*/
?>
	  <form class="searchForm cf" name="search_form" id="search_form" action="" method="get">
			<label>
            <input type="text" name="q" id="q" placeholder="Search" class="inputText" 
                 value="<?php echo trim(@$serch_value);?>" /></label>
            <label><input name="" type="submit" value="Search" class="button"></label>
       </form>