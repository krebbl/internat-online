<?php if($pupil['checked_out'] == '' || $pupil['checked_out'] == '0001-01-01'){ ?>
	<?= $html->link('Abmelden', 
	'javascript:;',
	array(
		'class' => 'only-icon icon-check-out',
		'title' => 'Abmelden',
		'onclick' => 'showTableDialog(this,"pupils_ajax","checkout",'.$pupil['id'].');'));
?>
<?php }else if($pupil['banished']){ ?>
	<div class="only-icon icon-status-busy" title="Ausgewiesen am <?= $myHtml->date($pupil['checked_out']); ?>">Ausgewiesen </div>
<?php }else{ ?>
	<div class="only-icon icon-status-offline" title="Abgemeldet am <?= $myHtml->date($pupil['checked_out']); ?>">Abgemeldet </div>
<?php }?>