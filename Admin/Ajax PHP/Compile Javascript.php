<?php
	if ($_POST["Path"] != null)
		echo html_entity_decode(file_get_contents($_POST["Path"]));
?>
