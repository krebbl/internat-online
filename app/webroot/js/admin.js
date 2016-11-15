$.ui.dialog.defaults.bgiframe = true;
$(document).ready(function () {
    $("#dialog").dialog({autoOpen: false, modal: true, width: 'auto'});
});

var tableRow = 0;
var tableColClass = "";
var actionTarget;

var showTableDialog = function (el, c, a, id) {
    tableRow = $(el).parents('tr').get(0).rowIndex;
    tableColClass = a;
    dialogURL = "/index.php/" + c + "/" + a + "dialog" + "/" + id;
    var tbody = $('#ContentTable').find('tbody');
    var row = tbody.get(0).rows[tableRow];
    actionTarget = $(row).find("." + tableColClass);

    $('#dialog').load(dialogURL, null, function () {
        $('#dialog').dialog('open');
    });
};

var showInvoiceDialog = function () {
    var c = 'pupils_ajax',
        a = 'invoice';

    var ids = $.map($("[name='data[Pupil][ids][]']:checked:not(:disabled)"), function (el) {
        return el.value
    });

    if (ids.length) {
        var dialogURL = "/index.php/" + c + "/" + a + "dialog?ids=" + ids.join(",");
        $('#dialog').load(dialogURL, null, function () {
            $('#dialog').dialog('open');
        });
    }

};

var tableDialogCB = function (response, status) {
    if (response.status == "success") {
        $('#dialog').dialog('close');
        alert('Erfolgreich eingetragen');
        if (actionTarget.get(0)) {
            actionTarget.html(response.html);
        }
    } else {
        $('#dialog').html(response.html);
        $('#dialog').dialog('open');
    }
};

var doAction = function (actionURL, t) {
    var dialogFormData = $('#DialogSetForm').serialize();
    if (t) {
        actionTarget = $(t);
    }
    $('#dialog').html('<div style="text-align: center; width: 200px;height: 100px; background: #ececec;">Bitte warten<br/><img src="/css/img/ajax-form-loader.gif" stlye="margin: 10px;"/></div>');
    $.post('/index.php' + actionURL, dialogFormData, tableDialogCB, 'json');
}

var doCheckAll = function (el) {
    if (el.checked) {
        $('input.default-checkbox:visible').attr("checked", true);
    } else {
        $('input.default-checkbox:visible').attr("checked", false);
    }
}

var confirmDelete = function () {
    var del = confirm("Wirklich löschen?");
    return del;
}

var filterTimeOutSet = false;
var filterTimeOutId = 0;
var visibleRowsLabel = false;
var filterMap = new Array();
var doFilter = function (filterId, filterFnc) {

    var s = $('#filter').val();
    if (!visibleRowsLabel) {
        visibleRowsLabel = $('#vr-label');
    }

    if (s.length < 2 && s.length > 0) {
        return false;
    }

    if (filterTimeOutSet) {
        window.clearTimeout(filterTimeOutId);
    }
    filterTimeOutSet = true;
    filterTimeOutId = window.setTimeout(function () {
        var str = s.split(" ");
        var visibleRows = 0;
        var table = $('#ContentTable');
        var hide = false;
        $.each(table.get(0).rows, function (ri) {
            hide = true;
            h2 = false;
            var j = 1;
            var html = "";
            for (var j = 1; j < this.cells.length; j++) {
                html = $.trim($(this.cells[j]).text().toLowerCase());
                for (var i = 0; i < str.length; i++) {
                    if ((html.indexOf(str[i].toLowerCase()) > -1)) {
                        hide = false;
                        break;
                    }
                    ;
                }
                if (!hide) {
                    break;
                }
            }
            ;
            if (hide) {
                $(this).hide().find("input").attr('disabled', 'disabled');
            } else {
                $(this).show().find("input").removeAttr("disabled");
                visibleRows++;
            }
        });
        filterTimeOutSet = false;
        visibleRowsLabel.html(visibleRows);
    }, 500);

}

var showTabContent = function (id) {
    if (id == "") return;
    var f = $('#active_tab');
    var t = f.attr('value');
    f.attr('value', id);
    $('div.tab').hide();
    $('a.active').removeClass('active');
    $('#' + id + '_link').addClass('active');
    $('#' + id).show();
}

var enablePayOut = function (el) {
    $(el).siblings('select').attr('disabled', !el.checked);
}