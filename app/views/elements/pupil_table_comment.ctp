<?= $html->link('Kommentar anzeigen',
			'javascript:;',
			array(
				'class' => 'only-icon '.(empty($comments)?'icon-comment-add':'icon-comments'),
				'title' => 'Kommentare',
				'onclick' => 'showTableDialog(this,"pupils_ajax","comments",'.$pupil['id'].');')); ?>