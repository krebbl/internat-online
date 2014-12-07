<p><b>Hinweis</b>: Hier kannst du nachträglich deinen Anmeldebogen ausdrucken.</p>	
<br/>
<? @$session->flash(); ?>
<?= $form->create('Print', array('url' => array('controller' => 'print', 'action' =>'bypw'))); ?>
<div class="form-body">
	<fieldset>
	<legend>Passwort eingeben</legend>
	<div class="form-row clearfix">
		<?= $form->input('Pupil.password', array(
							'label' => 'Passwort',
							'div' => array(
									'class' => 'form-col',
									'style' => 'width: 20%;'
								)
							)); ?>
	</div>
	</fieldset>
</div>
<div class="form-buttons">
	<input type="submit" name="data[submit]" value="Ausdrucken" />
</div>
</form>