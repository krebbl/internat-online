<fieldset>
	<legend>Ausbildungsklasse</legend>
	<div class="form-row clearfix">
		<?= $this->element('pupil_form_school_class2'); ?>
	</div>
</fieldset>
<fieldset>
	<legend>Schule</legend>
	<?php $newSchool = (isset($this->data['NewSchool']) && $this->data['NewSchool'] == 1) ?>
	<div class="form-row clearfix">
		<?= $form->input('Pupil.school_id', 
				array(
					'label' => 'Schule',
					'type' => 'select', 
					'div' => array(
						'class' => 'form-col',
						'style' => 'width: 66%'
					),
					'disabled' => $newSchool,
					'onchange' => 'loadDetails(this,"School")',
					'empty' => '(auswählen)')); ?>
		<?= $form->input('NewSchool', 
				array(
					'before' => '<br/>',
					'label' => 'Andere Schule als hier aufgelistet',
					'type' => 'checkbox', 
					'div' => array(
						'class' => 'form-col checkbox',
						'style' => 'width: 22%'
					),
					'onchange' => 'showCreateForm(this,"School")')); ?>
	</div>
	<div class="form-row" id="School_details">
	</div>
	<div id="School_form" 
		<?= ($newSchool)?'':'style="display: none"'?>>
		<div class="form-row clearfix" >
			<?= $form->input(
					'School.name',
					array(
						'label' => 'Name der Schule',
						'div' => array(
							'class' => 'form-col',
							'style' => 'width: 60%'
						)
			)); ?>
		</div>
		<div class="form-row">
			<div class="clearfix">
				<?= $this->element('address_form',array(
					'address_is_set' => true,
					'removable' => false,
					'address_path' => "SchoolAddress",
					'address' => @$this->data['SchoolAddress'],
					'errors' => @$errors['SchoolAddress']
				)) ?>
			</div>
		</div>
	</div>
</fieldset>
<fieldset>
	<legend>Firma</legend>
	<?php $newCompany = (isset($this->data['NewCompany']) && $this->data['NewCompany'] == 1) ?>
	<div class="clearfix form-row">
		<?= $form->input('Pupil.company_id', 
				array(
					'label' => 'Firma',
					'type' => 'select', 
					'div' => array(
						'class' => 'form-col',
						'style' => 'width: 66%'
					),
					'disabled' => $newCompany,
					'onchange' => 'loadDetails(this,"Company")',
					'empty' => '(auswählen)')); ?>
		<?= $form->input('NewCompany', 
				array(
					'before' => '<br/>',
					'label' => 'Andere Firma als hier aufgelistet',
					'type' => 'checkbox', 
					'div' => array(
						'class' => 'form-col checkbox',
						'style' => 'width: 22%'
					),
					'onchange' => 'showCreateForm(this,"Company")')); ?>
	</div>
	<div class="clearfix form-row" id="Company_details">
	</div>
	<div id="Company_form" <?= $newCompany?'':'style="display: none"'?>>
		<div class="form-row clearfix" >
			<?= $form->input(
					'Company.name',
					array(
						'label' => 'Name der Firma',
						'div' => array(
							'class' => 'form-col',
							'style' => 'width: 60%'
						),
						'errors' => @$errors['Company']
			)); ?>
		</div>
		<div class="form-row">
			<div class="clearfix">
				<?= $this->element('address_form',array(
					'address_is_set' => true,
					'removable' => false,
					'address_path' => "CompanyAddress",
					'address' => @$this->data['CompanyAddress'],
					'errors' => @$errors['CompanyAddress']
				)) ?>
			</div>
		</div>
	</div>
</fieldset>
