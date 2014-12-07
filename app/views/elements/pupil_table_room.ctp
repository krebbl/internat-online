<?= $html->link('Zimmer geben', 
	'javascript:;',
	array(
		'class' => 'only-icon icon-door',
		'title' => 'Zimmer geben',
		'onclick' => 'showTableDialog(this,"pupils_ajax","room",'.$pupil['id'].');'));
?>
<?php if(isset($pupil['room']) && $pupil['room'] != ''){ ?>
<?php echo 'R:'.$pupil['room']; ?>
<?php } ?>