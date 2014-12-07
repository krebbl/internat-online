<?php $session->flash('auth'); ?>
<?= $form->create('User', array('url' => array('controller' => 'users', 'action' =>'login'))); ?>
<div class="form-body">
	<fieldset>
	<legend>Login</legend>
	<div class="form-row clearfix">
		<?= $form->input('User.username', array(
							'label' => 'Benutzername',
							'div' => array(
									'class' => 'form-col',
									'style' => 'width: 20%;'
								)
							)); ?>
		<?= $form->input('User.password', array(
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
	<input type="submit" name="data[submit]" value="Login" />
</div>
</form>