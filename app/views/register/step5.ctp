<fieldset>
	<legend>Angaben zur Person</legend>
	<div class="form-row clearfix">
		<div class="form-col">
			<span class="label">Vorname</span><br/>
			<span class="input"><?= $page1['Pupil']['firstname'] ?></span>
		</div>
		<div class="form-col">
			<span class="label">Nachname</span><br/>
			<span class="input"><?= $page1['Pupil']['lastname'] ?></span>
		</div>
		<div class="form-col">
			<span class="label">Geschlecht</span><br/>
			<span class="input">
				<span class="input">
					<? switch($page1['Pupil']['male']){
						case 1: echo 'männlich'; break;
						case 2: echo 'weiblich'; break;
					} ?></span>
			</span>
		</div>
	</div>
	<div class="form-row clearfix">
		<div class="form-col">
			<span class="label">Geburtstag</span><br/>
			<span class="input">
				<?=($page1['Pupil']['birthdate']['day']) ?>.<?=($page1['Pupil']['birthdate']['month']) ?>.<?=($page1['Pupil']['birthdate']['year']) ?>
			</span>
		</div>
		<div class="form-col">
			<span class="label">Geburtsort</span><br/>
			<span class="input"><?= $page1['Pupil']['birthplace'] ?></span>
		</div>
		<?php if(!empty($page1['Pupil']['email'])): ?>
		<div class="form-col">
			<span class="label">E-Mail</span><br/>
			<span class="input"><?= $page1['Pupil']['email'] ?></span>
		</div>
		<?php endif; ?>
	</div>
	<div class="form-row clearfix">
		<div class="form-col">
			<span class="label">Nationalit&auml;t</span><br/>
			<span class="input"><?= $nationality['Nationality']['name'] ?></span>
		</div>
		<div class="form-col">
			<span class="label">Landkreis</span><br/>
			<span class="input"><?= $county['County']['name'] ?></span>
		</div>
	</div>
</fieldset>
<fieldset>
	<legend>Adresse</legend>
	<?= $this->element('address_details',array('address' => $page1['Address'])); ?>
</fieldset>
<?php for($i = 0; $i < 2 && !empty($page2['PupilParent'][$i]['firstname']);$i++): ?>
<fieldset>
	<legend>Gesetzlicher Vertreter <?= ($i+1) ?></legend>
	<div class="form-row clearfix">
		<div class="form-col">
			<span class="label">Vorname</span><br/>
			<span class="input"><?= $page2['PupilParent'][$i]['firstname'] ?></span>
		</div>
		<div class="form-col">
			<span class="label">Nachname</span><br/>
			<span class="input"><?= $page2['PupilParent'][$i]['lastname'] ?></span>
		</div>
	</div>
	<?php if($page2["PupilParent$i"]['ignore_address'] == 0): ?>
		<?= $this->element('address_details',array('address' => $page2['PupilParent'][$i]['address'])); ?>
	<?php else: ?>
		<div class="form-col">
			<span class="label">Adresse</span><br/>
			<span class="input">Gleiche Adresse wie oben</span>
		</div>
	<?php endif ?>
</fieldset>
<?php endfor; ?>
<fieldset>
	<legend>Ausbildung</legend>
	<?php if(isset($schoolClassType)): ?>
	<div class="form-row clearfix">
		<div class="form-col" style="width: 45%;">
			<span class="label">Ausbildungsrichtung</span><br/>
			<span class="input">
				<?= $schoolClassType['SchoolClassType']['name']?>
			 	(<?= $schoolClassType['SchoolClassType']['abbreviation'];?>)
			</span>
		</div>
		<div class="form-col">
			<span class="label">Beginn</span><br/>
			<span class="input"><?= $myHtml->date($schoolSemester['SchoolSemester']['start_date']) ?></span>
		</div>
	</div>
	<?php endif; ?>
	<div class="form-row clearfix">
		<div class="form-col" style="width: 45%;">
			<span class="label">Schule</span><br/>
			<span class="input"><?= @$school['name'] ?></span>
		</div>
		<div class="form-col" style="width: 45%;">
			<span class="label">Firma</span><br/>
			<span class="input"><?= @$company['name'] ?></span>
		</div>
	</div>
</fieldset>
<fieldset>
	<legend>Internatsnutzung</legend>
	<div class="form-row clearfix">
		<div class="form-col" style="width: 20%;">
			<span class="label">Tag der Anreise</span><br/>
			<span class="input"><?= $page4['Pupil']['arrival_day']['day'] ?>.<?= $page4['Pupil']['arrival_day']['month'] ?>.<?= $page4['Pupil']['arrival_day']['year'] ?></span>
		</div>
		<div class="form-col" style="width: 20%;">
			<span class="label">Dauerbeleger</span><br/>
			<span class="input">
				<?= ($page4['Pupil']['permanent'])?'JA':'NEIN'; ?>
			</span>
		</div>
		<div class="form-col" style="width: 20%;">
			<span class="label">Dauer der Anreise</span><br/>
			<span class="input"><?= $page4['Pupil']['min_to_arrive']?> Minuten</span>
		</div>
		<div class="form-col" style="width: 20%;">
			<span class="label">Dauer der Abreise</span><br/>
			<span class="input"><?= $page4['Pupil']['min_to_depart']?> Minuten</span>
		</div>
	</div>
	
</fieldset>
	