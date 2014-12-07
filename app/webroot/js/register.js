/**
 * @author krebbl
 */

var disableAddress = function(el,id){
	$('#'+id).toggle(!el.checked);
}

var showForm = function(el){
	var link = $(el);
	var input = link.parent('div').prev('div').show().find('input[type=hidden]:first');
	var name = input.attr('name');
	name = name.substring(0,name.length - 4) + "[add]";
	var val = parseInt(input.attr('value'));
	if(val > 0){
		input.next('input[type=hidden]').remove();
	}else{
		input.after('<input type="hidden" value="true" name="'+name+'"/>');
	}
	link.hide().next().show();
};

var hideForm = function(el){
	var link = $(el);
	var input = link.parent('div').prev('div').hide().find('input[type=hidden]:first');
	var name = input.attr('name');
	name = name.substring(0,name.length - 4) + "[remove]";
	var val = parseInt(input.attr('value'));
	if(val > 0){
		input.after('<input type="hidden" value="true" name="'+name+'"/>');
	}else{
		input.next('input[type=hidden]').remove();
	}
	link.hide().prev().show();
};

var showCreateForm = function(el,name){
	var cb = $(el);
	var checked = cb.attr('checked');
	$('#Pupil'+name+'Id').attr('disabled',checked);
	$('#'+name+'_details').toggle(!checked);
	$('#'+name+'_form').toggle(checked);
}

var toggleForm = function(el){
	var cb = $(el);
	var checked = cb.attr('checked');
	if(checked){
		showForm($('#addParentLink'));
		$('#removeParentLink').hide();
	}else{
		hideForm($('#removeParentLink'));
		
	}
}