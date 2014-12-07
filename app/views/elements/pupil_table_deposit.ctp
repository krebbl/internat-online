<?php if(isset($deposit['id'])){ ?>
	<div title="eingezahlt am <?= $myHtml->date($deposit['paid_in']); ?>">
		<?php if(isset($deposit['paid_out']) && $deposit['paid_out'] != '0000-00-00' && $deposit['paid_out'] != '0001-01-01'){?>
		<div class="only-icon icon-tick" title="ausgezahlt am <?= $myHtml->date($deposit['paid_out']);?>">ausgezahlt</div>
		<?php }else{ ?>
			<?= $html->link('Kaution auszahlen', 
			'javascript:;',
			array(
				'class' => 'only-icon icon-money-delete',
				'title' => 'Kaution auszahlen',
				'onclick' => 'showTableDialog(this,"pupils_ajax","deposit",'.$pupil['id'].');'
			)); ?>
		<?php }?>
		<?= $deposit['block'].'/'.$deposit['nr']; ?>	
	</div>	
<?php }else{ ?>
	<?= $html->link('einzahlen',
				'javascript:;',
				array(
					'class' => 'only-icon icon-money-add',
					'title' => 'Kaution einzahlen',
					'onclick' => 'showTableDialog(this,"pupils_ajax","deposit",'.$pupil['id'].');')); ?>	
<?php } ?>