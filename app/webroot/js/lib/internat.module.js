/**
 * @author krebbl
 */

if(!internat) var internat = {};

internat.Module = function(cfg){
	this.init(cfg);
}

internat.Module.prototype = {
	label: 'No label',
	id: Math.random(10000000)+"",	
	init: function(cfg){
		$.extend(this,cfg);
	},
	/**
	 * 	This method will be called, when the App has to render the Module
	 */
	render: function(){},
	resize: function(){},
	onResize: function(){},
	onRender: function(){},
};

internat.LayoutModule = function(cfg){
	this.init(cfg);
};

internat.LayoutModule.prototype = $.extend(internat.Module.prototype,{
	isResized: false,
	layoutId: null,
	$layoutContainer: null,
	layout: null,
	layoutOpt: {},
	innerLayoutId : null,
	$innerLayoutContainer: null,
	innerLayout: null,
	init: function(cfg){
		$.extend(this,cfg);
		
		this.layoutOpt.center__paneSelector = ".outer-center";
		this.layoutOpt.north__paneSelector = ".outer-north";
		this.layoutOpt.south__paneSelector = ".outer-south";
		this.layoutOpt.west__paneSelector = ".outer-west";
		this.layoutOpt.east__paneSelector = ".outer-east";
		
		this.layoutOpt.center__onresize = function(){
			var l = this.innerLayout;
			l.resizeAll();
		}
		
		this.innerLayoutOpt.center__paneSelector = ".inner-center";
		this.innerLayoutOpt.north__paneSelector = ".inner-north";
		this.innerLayoutOpt.south__paneSelector = ".inner-south";
		this.innerLayoutOpt.west__paneSelector = ".inner-west";
		this.innerLayoutOpt.east__paneSelector = ".inner-east";
	},
	render: function(){
		// render outer layout
		if(!this.layout){
			this.$layoutContainer = $('#'+this.layoutId);
			this.$layoutContainer.show();
			if ( this.$layoutContainer.is(':visible') ){
				this.layout = this.$layoutContainer.layout(this.layoutOpt);
				
			}
		}
		// render inner layout
		if(!this.innerLayout){
			this.$innerlayoutContainer = $('#'+this.innerLayoutId);
			this.$innerlayoutContainer.show();
			if ( this.$innerlayoutContainer.is(':visible') ){
				this.innerLayout = this.$innerlayoutContainer.layout(this.innerLayoutOpt);
				
			}
		}
		this.onRender();
	},
	resize: function(){
		this.isResized = false;
		if(!this.$layoutContainer) return;
		// make sure Container element is not hidden
 		this.$layoutContainer.show();
		// if Container is still not visible, then must be INSIDE a hidden element
		if ( !this.$layoutContainer.is(':visible') ) return; // ABORT
		
		this.layout.resizeAll();
		this.isResized = true;
		this.onResize();
	}
});

internat.TableModule = function(cfg){
	this.init1(cfg);
};

internat.TableModule.prototype = $.extend(internat.Module.prototype,{ 
	tableId: null,
	$tableContainer: null,
	$tableHead: null,
	$tableBody: null, 
	rowRenderer: function(colIndex){},
	init1: function(cfg){
		$.extend(this,cfg);
	},
	render1: function(){
		// Create new Header
		// create 
	},
	loadData: function(){
		
	}
});
