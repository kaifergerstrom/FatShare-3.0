var fileName;

$('#fileToUpload').change(function(e) {
    $("#remove-img-post").fadeIn(500);
    $("#blah").fadeIn(500);
    var fileName = e.target.files[0].name;
    if (fileName.length > 35) {
        fileExtension = fileName.substr((fileName.lastIndexOf('.') + 1));
        fileName = fileName.substring(0, 35);
        newFileName = fileName + '.' + fileExtension;
    } else {
        newFileName = fileName;
    }
    document.getElementById("inputfilelabel").innerHTML = newFileName;
});

$("#remove-img-post").click(function(){
    var input = $("#fileToUpload");
    input.replaceWith(input.val('').clone(true));
    document.getElementById("inputfilelabel").innerHTML = 'Attach a file';
    $("#remove-img-post").fadeOut(500);
    $("#blah").fadeOut(500);
});

function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('#blah').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#fileToUpload").change(function() {
    readURL(this);
});