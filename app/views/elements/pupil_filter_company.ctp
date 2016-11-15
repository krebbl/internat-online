<label for="companies">Firma</label>
<select name="companyId" onchange="this.form.submit()" id="companies">
	<option value="">Alle</option>
	<?php foreach ($companies as $company) : ?>
		<option
			value="<?= $company['Company']['id'] ?>"
			<?= (isset($companyId) && $company['Company']['id'] == $companyId) ? 'selected="selected"' : ''; ?>
			><?= $company['Company']['name'] ?></option>
	<?php endforeach ?>
</select>