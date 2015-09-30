/**
 * @author krebbl
 */

Array.prototype.in_array = function (needle) {
    for (var i = 0; i < this.length; i++) if (this[i] === needle) return true;
    return false;
}

var loadDetails = function (el, model) {
    var detailDiv = $('#' + model + '_details');
    if (detailDiv.length > 0) {
        $('#' + model + '_details').html('<div class="ajax-loader"></div>').load('/index.php/addresses/details/' + el.value + '/' + model);
    }
}

var loadSchoolClasses = function (el) {
    $('#SchoolClassDiv').html('<div class="ajax-loader-s"></div>').load('/index.php/pupils_ajax/schoolclassselection/' + el.value);
}

var ivo = ivo || {};

ivo.canvas = null;

ivo.uploadProfileImage = function (input, callback) {
    if (!this.canvas) {
        this.canvas = document.createElement("canvas");
        this.canvas.style.visibility = "hidden";
        document.body.appendChild(this.canvas);
    }

    var filesToUpload = input.files;
    var file = filesToUpload[0];

    var img = document.createElement("img");
    var reader = new FileReader();
    reader.onload = function (e) {
        img.src = e.target.result
    }
    reader.readAsDataURL(file);

    var ctx = this.canvas.getContext("2d");
    ctx.drawImage(img, 0, 0);

    var MAX_WIDTH = 800;
    var MAX_HEIGHT = 600;
    var width = img.width;
    var height = img.height;

    if (width > height) {
        if (width > MAX_WIDTH) {
            height *= MAX_WIDTH / width;
            width = MAX_WIDTH;
        }
    } else {
        if (height > MAX_HEIGHT) {
            width *= MAX_HEIGHT / height;
            height = MAX_HEIGHT;
        }
    }
    this.canvas.width = width;
    this.canvas.height = height;
    var ctx = this.canvas.getContext("2d");
    ctx.drawImage(img, 0, 0, width, height);

    var dataurl = canvas.toDataURL("image/png");



}