<script type="text/javascript" charset="utf-8">
    $(document).ready(function () {
        showTabContent($('#active_tab').val());
        loadDetails($('#PupilSchoolId').get(0), 'School');
        loadDetails($('#PupilCompanyId').get(0), 'Company');
    })
</script>

<?= $form->create('Pupil', array('action' => 'edit')); ?>

<?php
# TAB MENU
if (!isset($this->data['active_tab'])) {
    $active_tab = 'pupil_fieldset';
} else {
    $active_tab = $this->data['active_tab'];
}
$tabs = array(
    'pupil_fieldset' => 'Person',
    'boarding_fieldset' => 'Internatsnutzung',
    's_c_fieldset' => 'Ausbildung',
    'comm_fieldset' => 'Kommentare',
    'bill_fieldset' => 'Rechnung'
);

$out = '<ul class="form-tabs clearfix">';
foreach ($tabs as $id => $label) {
    $out .= '<li><a href="javascript:;" id="' . $id . '_link" onclick="showTabContent(\'' . $id . '\');" class="' . (($active_tab == $id) ? 'active' : '') . '">';
    $out .= $label;
    $out .= '</a></li>';
}
$out .= '</ul>';
echo $out;
?>

<div class="form-body">
<input type="hidden" name="data[active_tab]" value="<?= $active_tab ?>" id="active_tab">

<div <?= $this->element('pupil_form_fieldset_start', array('id' => 'pupil_fieldset', 'active_tab' => $active_tab)) ?>>
    <fieldset>
        <legend>Persönliche Daten</legend>
        <div class="clearfix form-row">
            <?= $form->input('Pupil.id', array('type' => 'hidden')); ?>
            <?=
            $form->input('Pupil.firstname',
                array(
                    'label' => 'Vorname',
                    'div' => 'form-col'
                )); ?>
            <?=
            $form->input(
                'Pupil.lastname',
                array(
                    'label' => 'Nachname',
                    'div' => array(
                        'class' => 'form-col',
                    )
                )); ?>
            <?=
            $form->input(
                'Pupil.male',
                array(
                    'label' => 'Geschlecht',
                    'div' => array(
                        'class' => 'form-col',
                    ),
                    'options' => array(0 => 'Weiblich', 1 => 'Männlich')
                )
            )?>
        </div>
        <div class="clearfix form-row">
            <?=
            $form->input('Pupil.birthdate',
                array(
                    'label' => 'Geburtsdatum',
                    'dateFormat' => 'DMY',
                    'minYear' => date('Y') - 40,
                    'maxYear' => date('Y') - 14,
                    'class' => 'datefield',
                    'separator' => '.',
                    'div' => 'form-col'
                )
            ); ?>
            <?=
            $form->input(
                'Pupil.birthplace',
                array(
                    'label' => 'Geburtsort',
                    'div' => array(
                        'class' => 'form-col',
                    )
                )); ?>
            <?=
            $form->input(
                'Pupil.email',
                array(
                    'label' => 'Email',
                    'div' => array(
                        'class' => 'form-col',
                    )
                )); ?>
        </div>
        <div class="clearfix">
            <?=
            $form->input(
                'Pupil.nationality_id',
                array(
                    'label' => 'Nationalität',
                    'div' => array(
                        'class' => 'form-col',
                    )
                )); ?>
            <?=
            $form->input(
                'Pupil.county_id',
                array(
                    'label' => 'Landkreis',
                    'div' => array(
                        'class' => 'form-col',
                    )
                )); ?>
        </div>
    </fieldset>
    <fieldset>
        <legend>Kontaktdetails</legend>
        <div class="clearfix">
            <?=
            $this->element('address_form', array(
                'address_is_set' => true,
                'removable' => false,
                'address_path' => "Address.0",
                'address' => $this->data['Address'],
                'errors' => @$errors['Address']
            )) ?>
        </div>
    </fieldset>
    <fieldset>
        <legend>Gesetzliche Vertreter</legend>
        <?=
        $this->element('pupil_parent_form', array(
            'num' => 0,
            'pupilParent' => $this->data['PupilParent'][0],
            'addressErrors' => @$errors['pupilParentAddress0'],
            'phoneErrors' => @$errors['pupilParentPhoneNumber0'],
            'removable' => false,
            'errors' => @$errors['pupilParent0']))?>

        <div class="clearfix form-row">
            <?=
            $form->input('Pupil.splitted_custody',
                array(
                    'before' => '<br/>',
                    'label' => 'Geteiltes Sorgerecht',
                    'div' => array(
                        'class' => 'form-col checkbox'
                    )
                )) ?>
        </div>
        <br/>

        <?=
        $this->element('pupil_parent_form', array(
            'num' => 1,
            'pupilParent' => @$this->data['PupilParent'][1],
            'addressErrors' => @$errors['pupilParentAddress1'],
            'phoneErrors' => @$errors['pupilParentPhoneNumber1'],
            'removable' => true,
            'errors' => @$errors['pupilParent1']))?>
    </fieldset>
</div>
<div <?= $this->element('pupil_form_fieldset_start', array('id' => 'boarding_fieldset', 'active_tab' => $active_tab)) ?>>
    <fieldset>
        <legend>An- und Abreise</legend>
        <div class="clearfix form-row">
            <?=
            $form->input('Pupil.min_to_arrive',
                array(
                    'label' => 'Dauer der Hinfahrt (in Min)',
                    'div' => array(
                        'class' => 'form-col'
                    )
                )) ?>
            <?=
            $form->input('Pupil.min_to_depart',
                array(
                    'label' => 'Dauer der R&uuml;ckfahrt (in Min)',
                    'div' => array(
                        'class' => 'form-col'
                    )
                )) ?>
        </div>
        <div class="clearfix form-row">
            <?=
            $form->input('Pupil.arrival_day',
                array(
                    'label' => 'Tag der Anreise',
                    'dateFormat' => 'DMY',
                    'class' => 'datefield',
                    'separator' => '.',
                    'div' => array(
                        'class' => 'form-col'
                    )
                )) ?>
            <?=
            $form->input('Pupil.permanent',
                array(
                    'before' => '<br/>',
                    'label' => 'Dauerbeleger',
                    'div' => array(
                        'class' => 'form-col checkbox'
                    )
                )) ?>
        </div>
    </fieldset>
    <fieldset id="kaution" class="">
        <legend>Kaution</legend>
        <?=
        $this->element('deposit_form', array(
            'removable' => true,
            'deposit' => $this->data['Deposit'],
            'errors' => @$errors['Deposit']
        )) ?>
    </fieldset>
    <fieldset class="">
        <legend>Abrechnung</legend>
        <div class="clearfix form-row">
            <?=
            $form->input('Pupil.rent_on_account',
                array(
                    'before' => '<br/>',
                    'label' => 'Miete auf Rechnung',
                    'div' => array(
                        'class' => 'form-col checkbox'
                    )
                )) ?>
            <?=
            $form->input('Pupil.food_on_account',
                array(
                    'type' => 'select',
                    'options' => array('0' => '-', '1' => 'Halbpension', '2' => 'Vollpension'),
                    'before' => '<br/>',
                    'label' => 'Essen auf Rechnung',
                    'div' => array(
                        'class' => 'form-col checkbox'
                    )
                )) ?>
        </div>
    </fieldset>
    <fieldset id="car" class="">
        <legend>Auto</legend>
        <div class="clearfix form-row">
            <?=
            $this->element('car_form', array(
                'car_is_set' => true,
                'removable' => true,
                'car_path' => "PupilCar",
                'car' => $this->data['PupilCar'],
                'errors' => @$errors['PupilCar']
            )) ?>
        </div>
    </fieldset>
</div>
<div <?= $this->element('pupil_form_fieldset_start', array('id' => 's_c_fieldset', 'active_tab' => $active_tab)) ?>>
    <fieldset>
        <legend>Ausbildungsklasse</legend>
        <div class="clearfix form-row">
            <?= $this->element('pupil_form_school_class'); ?>
        </div>
    </fieldset>
    <fieldset>
        <legend>Schule</legend>
        <div class="clearfix form-row">
            <?=
            $form->input('Pupil.school_id',
                array(
                    'label' => 'Schule',
                    'type' => 'select',
                    'div' => array(
                        'class' => 'form-col',
                        'style' => 'width: 66%'
                    ),
                    'onchange' => 'loadDetails(this,"School")',
                    'empty' => '(auswählen)')); ?>
        </div>
        <div class="clearfix form-row" id="School_details">
        </div>
    </fieldset>
    <fieldset>
        <legend>Firma</legend>
        <div class="clearfix form-row">
            <?=
            $form->input('Pupil.company_id',
                array(
                    'label' => 'Firma',
                    'type' => 'select',
                    'div' => array(
                        'class' => 'form-col',
                        'style' => 'width: 66%'
                    ),
                    'onchange' => 'loadDetails(this,"Company")',
                    'empty' => '(auswählen)')); ?>
        </div>
        <div class="clearfix form-row" id="Company_details">
        </div>
    </fieldset>
</div>
<div <?= $this->element('pupil_form_fieldset_start', array('id' => 'comm_fieldset', 'active_tab' => $active_tab)) ?>>


    <fieldset>
        <legend>Kommentare</legend>
        <?php
        if (!empty($this->data['PupilComment'])) {
            foreach ($this->data['PupilComment'] as $PupilComment):?>
                <div class="comment-text"><?= $PupilComment['text'] ?></div>
                <div class="comment-details">
                    <?= $PupilComment['created'] ?> von
                    <?= $PupilComment['User']['username'] ?>
                </div>
            <?php
            endforeach;
        } else {
            ?>
            Keine Kommentare
        <?php } ?>
    </fieldset>
</div>
<div <?= $this->element('pupil_form_fieldset_start', array('id' => 'bill_fieldset', 'active_tab' => $active_tab)) ?>>
    <fieldset>
        <legend>Rechnung</legend>

    </fieldset>
</div>
</div>
<?php
if (isset($this->data['Pupil']['id'])) {
    $buttons = array('<input type="submit" name="data[print]" class="small-icon icon-print-s" value="Drucken"/>');
} else {
    $buttons = array();
}
?>
<?=
$this->element('edit_form_end',
    array('buttons' => $buttons)) ?>