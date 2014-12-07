<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
<head>
	<title><?= @$title_for_layout ?> - internat.online</title>
	<link rel="shortcut icon" href="favicon.ico"> 
	<link rel="icon" type="image/ico" href="/favicon.ico">
	<?= $html->charset(); ?>
	<?= $html->css(array('screen','print','start/jquery-ui-1.7.2.custom.css')); ?>
	<?= $javascript->link(
		array('jquery-1.3.2.min.js','jquery-ui-1.7.2.custom.min.js', 'date.js', 'date_de.js', 'common.js', 'register.js')); ?>
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
	<div id="center-container">
		<div id="header-wrapper" class="clearfix">
			<div id="logo">internat online</div>
		</div>
		<div id="page-wrapper2">
			<div id="main-wrapper" class="clearfix">
				<h1><?= @$title_for_layout ?></h1>
				<div id="content-wrapper">
	    			<?=$content_for_layout?>
				</div>
			</div>
		</div>
		<div id="footer-wrapper" style="clear: both;">
			Ein Service des Internats der Meininger Berufsschulen
		</div>
	</div>
</body>
</html>