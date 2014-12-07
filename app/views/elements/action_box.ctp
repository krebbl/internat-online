<div class="action-box clearfix">
		<input type="hidden" name="data[last_url]" value="<?= $html->url(); ?>" />
		<?php if(!isset($delete) || $delete): ?>
		<input type="submit" name="data[delete]" class="small-icon icon-delete-s" value="Entfernen" onclick="return confirm('Wirklich löschen?')"/>
		<?php endif ?>

		<?php foreach($elements as $element): ?>
			<?= $element ?>
			
		<?php endforeach ?>
		
		<?php if(@$add): ?>
			<input 
				type="submit" 
				name="data[create]" 
				value="<?= (isset($add_label))?$add_label:'Neu erstellen'; ?>" 
				class="small-icon icon-add-s" 
				style="float: right;" />
		<?php endif ?>
</div>