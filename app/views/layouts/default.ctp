<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
<head>
	<title><?= @$title_for_layout ?> - internat.online</title>
	<?= $html->charset(); ?>
	<?= $html->css(array('screen','print','start/jquery-ui-1.7.2.custom.css')); ?>
	<?= $javascript->link(
		array('jquery-1.3.2.min.js','jquery-ui-1.7.2.custom.min.js', 'date.js', 'date_de.js', 'common.js', 'register.js','admin.js')); ?>
	<!--[if IE]>
		<?=  $javascript->link('jquery.bgiframe.js') ?>
	<![endif]-->

	<!-- jquery.datePicker.js -->
	<?=  $javascript->link('jquery.datePicker.js'); ?>
	<!--[if lte IE 7]>
		<?=  $javascript->link('ie7.js'); ?>
	<![endif]-->
	<!--[if lte IE 6]>
		<?=  $javascript->link('ie6.js') ?>
	<![endif]-->
</head>
<body>
	<div id="container">
		<div id="menu-wrapper" class="clearfix">
			<div id="logo"><?= $html->link('Übersicht', '/admin', array('class' => 'only-icon','style' => 'width: 100%;')); ?></div>
			<ul id="menu">
				<?php if($authorized): ?>
				<li>
					<div>Schüler</div>
					<ul id="pupil-menu">
						<li><?= $html->link('Anwesend','/pupils'); ?></li>
						<li><?= $html->link('Abgemeldet', '/pupils/checkedout'); ?></li>
						<li><?= $html->link('Aktuelle Belegung', '/pupils/current'); ?></li>
					</ul>
				</li>
				<li>
					<div>Institutionen</div>
					<ul id="institut-menu">
						<li><?= $html->link('Schulen anzeigen', '/schools'); ?></li>
						<li><?= $html->link('Firmen anzeigen', '/companies'); ?></li>
					</ul>
				</li>
				<li>
					<div>Organisation</div>
					<ul id="boarding-menu">
						<li><?= $html->link('Semesterübersicht', '/school_semesters'); ?></li>
						<li><?= $html->link('Ausbildungsrichtungen', '/school_class_types'); ?></li>
						<li><?= $html->link('Ausbildungsklassen', '/school_classes'); ?></li>
					</ul>
				</li>
				<li>
					<div>Benutzer</div>
					<ul id="boarding-menu">
						<!--<li><?= $html->link('Einschreibung', '/school_semesters'); ?></li> -->
						<!--<li><?= $html->link('Benutzer', '/users'); ?></li> -->
						<li><?= $html->link('Abmelden >', '/users/logout'); ?></li>
					</ul>
				</li>
				<?php endif; ?>
			</ul>
		</div>
		<div id="page-wrapper">
			<div class="clearfix"></div>
			<div id="main-wrapper" class="clearfix">
				<h1><?= @$title_for_layout ?></h1>
				<?= @$session->flash('success'); ?>
				<?= @$session->flash('error'); ?>
				<div id="content-wrapper">
	    			<?= $content_for_layout ?>
				</div>
			<div id="footer-wrapper" style="clear: both;"></div>
		</div>
	</div>
</body>
</html>