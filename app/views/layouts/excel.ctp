<?php
	$type = $filename;
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header("Content-Disposition: attachment; filename=\"".$type.".xlsx\"");
	header("Pragma: no-cache"); 
	header("Expires: 0"); 

	echo $content_for_layout ?>