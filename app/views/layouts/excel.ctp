<?php
	(empty($type)) ? $type = 'applications' : $type = $type; 
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header("Content-Disposition: attachment; filename=\"slf2007-".$type."\""); 
	header("Pragma: no-cache"); 
	header("Expires: 0"); 

	echo $content_for_layout ?>