<?php
	header("Pragma: no-cache");
	header("Cache-Control: no-store, no-cache, max-age=0, must-revalidate");
	header('Content-Type: text/json');
?>
{
	status: "<?= (isset($status))?$status:'success'; ?>",
	message: "<?= (isset($message))?$message:''; ?>",
	url: "<?= (isset($url))?$url:''; ?>",
	html: "<?= (isset($content_for_layout))?str_replace(array("\n", "\r", "\t", "\o", "\xOB"), '',addslashes($content_for_layout)):''; ?>",
	data: '<?= (isset($data))?$data:''; ?>'
	
}