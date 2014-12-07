<p><b>Hinweis</b>:Die Anmeldung erfolgt einmalig und ist für die gesamte Ausbildungsdauer gültig. Die Felder mit * (Sternchen) sind optional.</p>	
<br/>
<? @$session->flash(); ?>
<div id="form-status">
	<table cellspacing="0">
		<colgroup>
			<col width="20%"/>
			<col width="20%"/>
			<col width="20%"/>
			<col width="20%"/>
			<col width="20%"/>
		</colgroup>
		<tr>
			<td><span class="form-step">1</span> Persönliche Daten</td>
			<td><span class="form-step">2</span> Gesetzliche Verteter</td>
			<td><span class="form-step">3</span> Ausbildung</td>
			<td><span class="form-step">4</span> Internatsnutzung</td>
			<td><span class="form-step">5</span> Bestätigung</td>
		</tr>
		<tr>
			<?php for($i = 1; $i < 6; $i++): ?>
				<?php if($i < $page): ?><td class="bg-green"></td><?php endif; ?>
				<?php if($i == $page): ?><td class="bg-blue"></td><?php endif; ?>
				<?php if($i > $page): ?><td class="bg-grey"></td><?php endif; ?>
			<?php endfor; ?>
		</tr>
	</table>
</div>
<?php echo $this->element('register_form_start') ?>
	<? include('step'.$page.'.ctp') ?>
<?php
	if($page < 5){
		echo $this->element('register_form_end');
	}else{?>
	</div>
	<div class="register-form-buttons clearfix">
		<input type="submit" name="data[next]" value="Best&auml;tigen"/>
		<input type="submit" name="data[back]" value="Zur&uuml;ck"/>
	</div>
</form>
<?php }; ?>
