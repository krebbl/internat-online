<div class="form-row clearfix">
	<div class="form-col">
		<span class="label">Strasse</span><br/>
		<span class="input"><?= $address['street'] ?></span>
	</div>
	<div class="form-col" style="width: 8%;">
		<span class="label">PLZ</span><br/>
		<span class="input"><?= $address['zipcode'] ?></span>
	</div>
	<div class="form-col" style="width: 20%;">
		<span class="label">Ort</span><br/>
		<span class="input"><?= $address['city'] ?></span>
	</div>
</div>
<div class="form-row clearfix">
	<div class="form-col">
		<span class="label">Telefon</span><br/>
		<span class="input"><?= $address['home_nr'] ?></span>
	</div>
	<?php if(!empty($address['fax_nr'])): ?>
	<div class="form-col">
		<span class="label">Fax</span><br/>
		<span class="input"><?= $address['fax_nr'] ?></span>
	</div>
	<?php endif ?>
	<?php if(!empty($address['mobile_nr'])): ?>
	<div class="form-col">
		<span class="label">Handy</span><br/>
		<span class="input"><?= $address['mobile_nr'] ?></span>
	</div>
	<?php endif ?>
</div>