<?= $html->link((isset($car['id'])?'PKW '.' '.$car['name'].' '.$car['color'].' '.$car['sign']:''),
			'javascript:;',
			array(
				'class' => 'only-icon '.(isset($car['id'])?'icon-car':'icon-car-add'),
				'title' => 'PKW bearbeiten',
				'onclick' => 'showTableDialog(this,"pupils_ajax","car",'.$pupil['id'].');')); ?>