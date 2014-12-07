<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
 
<title>Tabbed Layout</title> 
 
<?= $html->css(array('base/ui.all.css','internat/ui.table.css')); ?>
 
<style type="text/css"> 
body { /* main body fonts and backgrounds */
	font: 0.6em 'Trebuchet MS', Helvetica, FreeSans, Arial, sans-serif;
}
 
/* 
*	JQUERY LAYOUT CLASSES
*/
 
.ui-layout-resizer { /* all 'resizer-bars' */
	background: #888;
}
.ui-layout-toggler { /* all 'toggler-buttons' */
	background: #CCC;
}
.inner-north { /* contextual help and message */
	background: #FFFDD6;
}
.inner-center ,
.inner-west ,
.inner-north {
	padding-bottom:	0 !important;
}
.pane {	/* custom class used to HIDE layout-panes until Layout initializes */
	display: none;
}
 
/*
 *	PageLayout Panes - Tab Buttons & Panels
 */
#TabButtons {			/* North */
}
#TabPanelsContainer {	/* Center */
	
	}
	#tabs .ui-tabs-panel {
		/* don't need border or rounded corners - tabs 'fill' the pane */
		border:		0;
	}
 
	/*
	 *	Tab #2
	 */
	#Documentation {
		background:	#FFF;	/* DEBUG - WHITE */
	}
 
.ui-panel-header {
	font-weight: bold;
	font-size: 14px;
	text-align: left;
	height: 33px;
	border-bottom: 1px solid #bbbbbb;
	border-left: 1px solid #cccccc;
	border-right: 1px solid #cccccc;
	border-top: 1px solid #FFF;
	background: url(css/internat/img/header-panel-bg.gif) repeat-x;
}

.ui-panel-header  h2{
	font-size:13px;
	line-height:22px;
	margin:6px 10px;
	font-weight: 800;
}
.ui-panel-header  a.header-close{
	position:absolute;
	right:10px;
	top:10px;
}





.search-box{
	padding: 10px;
}

.subhead {
	padding: 3px 4px;
}
.footer {
	padding: 3px 4px;
	border-top: 1px solid;
	}
	.footer p,
	.footer div,
	.footer form,
	.footer span {
		display: inline;
	}
 
.ui-widget-content {
	padding:	3px 7px;
	overflow:	auto;
}
 
.outer-north {
	background-color:  #1785cd;
	border-top: 4px solid #EEE;
	overflow:	visible;
}



.fg-button { 
   outline: 0; 
   font-weight: bold;
   margin:4px 0px 0 8px;
   padding: 0.2em 0.8em 0.2em 1.7em;
   text-decoration:none !important; 
   cursor:pointer; 
   position: relative; 
   text-align: center; 
   zoom: 1; 
}

a.fg-button {
	float:left;
}

.fg-button-icon-left .ui-icon {
	left:0.2em;
	margin-left:0;
	right:auto;
}

.fg-button .ui-icon {
	left:50%;
	margin-left:-8px;
	margin-top:-8px;
	position:absolute;
	top:50%;
}

.fg-button-icon-left .ui-icon {
	left:0.2em;
	margin-left:0;
	right:auto;
}

.fg-button-icon-right {
	padding-right:2.1em;
}

#selectable .ui-selecting td { background: #FECA40; }
#selectable .ui-selected td { background: #F39814; color: white; }
 
</style>
<?= $this->element('modules/pupils/css'); ?>
<?= $this->element('modules/companies/css'); ?>
<?= $javascript->link(
		array(	'lib/jquery-1.3.2.min.js',
				'lib/jquery-ui-1.7.2.custom.min.js',
				'lib/jquery.layout.js',
				'lib/internat.module.js',
				'lib/internat.app.js',
				'lib/date.js', 
				'lib/date_de.js')); ?>
<!--- the jquery.layout-1.3.0.rc11.js has debugging code specific to THIS PAGE
<script type="text/javascript" src="../lib/js/jquery.layout-latest.js"></script>
<script type="text/javascript" src="../lib/js/jquery.layout-1.2.0.timers.js"></script>
---> 
 
<script type="text/javascript"> 
 
	var PageLayout, ApplicationLayout, InnerLayout, $Tabs;
 	var App = new internat.TabbedApp({
		tabBarId: "TabButtons",
		tabPanelId: "TabPanelsContainer"
	})
 	
	$(document).ready(function () { 
		App.render();
		
		$('.fg-button').hover(
			function(){ 
				$(this).addClass("ui-state-hover"); 
			},
			function(){ 
				$(this).removeClass("ui-state-hover"); 
			}
		)
	});
	
	</script> 
	<?= $this->element('modules/pupils/js'); ?>
	<?= $this->element('modules/companies/js'); ?>
</head> 
<body> 
 
<h1>Loading...</h1> 
 
<div id="tabs" class="page-layout-center"> 
 
	<ul id="TabButtons" class="pane"> 
		
	</ul> 
 
	<!-- wrap tab-panels in ui-layout-content div --> 
	<div id="TabPanelsContainer" class="pane"> 
		<?= $this->element('modules/pupils/layout'); ?>	
		<?= $this->element('modules/companies/layout'); ?>		
	</div><!-- END TabPanelsContainer --> 
 
</div><!-- /#tabs --> 
 
</body> 
</html>