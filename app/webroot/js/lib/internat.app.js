if(!internat) var internat = {};

internat.App = function(cfg){
	this.init(cfg);
}

internat.App.prototype = {
	label: 'No label',
	modules: [],
	id: Math.random(10000000)+"",	
	init: function(cfg){
		$.extend(this,cfg);
	},
	addModule: function(module){
		this.modules.push(module);
	},
	render: function(){},
	renderModule: function(i){
		this.modules[i].render();
	},
	resizeModules: function(){
		for (var i = 0; i < this.modules.length; i++){
			this.modules[i].resize();
		};
	},
	resizeModule: function(i){
		this.modules[i].resize();
	}
};

internat.TabbedApp = function(cfg){
	this.init(cfg);
};

internat.TabbedApp.prototype = $.extend(internat.App.prototype,{
	tabBarId: null,
	tabPanelId: null,
	layout: null,
	$Tabs: null,
	render: function(){
		$TabButtons = $('#'+this.tabBarId);
		$TabButtons.html();
		var m;
		for (var i = 0; i < this.modules.length; i++){
			m = this.modules[i];
			$TabButtons.append('<li><a href="#'+m.layoutId+'"><span>'+m.label+'</span></a></li>');
		};
		
		var instance = this;
		var onShow = function(){
			instance.resizeTabLayout();
		}
		
		// best to create the tabs first, because is 'container' for the tab-layout (ApplicationLayout)
		this.$Tabs = $("#tabs").tabs({
			show: onShow // resize layout EACH TIME the layout-tab becomes 'visible'
		});
		
		// use different outer-layout classNames to simplify/clarify CSS
		this.layout = $('body').layout({ 
			name:						"PageLayout"
		,	triggerEventsOnLoad:		false
		,	north__paneSelector:		"#"+this.tabBarId
		,	center__paneSelector:		"#"+this.tabPanelId
		,	center__onresize:			function(){
				var selected = this.$Tabs.tabs('option', 'selected');
				this.resizeModule(selected);
			}
		,	spacing_open:				0
		/*	OLD - uses 1-pane with header & 'content' divs instead of north & center 'panes'
			center__paneSelector:		".page-layout-center"
		,	contentSelector:			"#TabPanelsContainer"
		*/
		, 	onresizeall:function(){
				
			}
		});
		
		this.resizeTabLayout();
	},
	resizeTabLayout: function(){
		
		if (!this.$Tabs) return; // make sure tabs are initialized
		console.log("resizeTabLayout");
		var selected = this.$Tabs.tabs('option', 'selected');
		// ONLY resize the layout when first tab is 'visible'
		// now resize the outermost layout to fit the new container size...
		
		this.layout.resizeAll(); // ...triggers cascading resize of inner-layouts - if initialized
		
		// render Module if it is not already rendered
		this.renderModule(selected);
		this.resizeModule(selected);
	}
});