	<div class="form-buttons">
		<input type="submit" name="data[submit]" class="big-icon icon-bullet-disk" value="Speichern" />
		<?php 
			if(isset($buttons)){
				foreach($buttons as $button){
					echo $button;
				}	
			}
			 ?>
		<input type="submit" name="data[cancel]" value="Abbrechen" />
	</div>
</form>
