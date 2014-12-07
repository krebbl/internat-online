/**
 * @author krebbl
 */

Array.prototype.in_array = function(needle) {
	for(var i=0; i < this.length; i++) if(this[ i] === needle) return true;
	return false;
}

var loadDetails = function(el,model){
	var detailDiv = $('#'+model+'_details');
	if (detailDiv.length > 0) {
		$('#' + model + '_details').html('<div class="ajax-loader"></div>').load('/index.php/addresses/details/' + el.value + '/' + model);
	}
}

var loadSchoolClasses = function(el){
	$('#SchoolClassDiv').html('<div class="ajax-loader-s"></div>').load('/index.php/pupils_ajax/schoolclassselection/'+el.value);
}