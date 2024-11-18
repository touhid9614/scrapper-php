$("#section-fileupload").hide();
$("#section-foldercreate").hide();
$("#temp-new-div").hide();
$("#loding").hide();


function finding_index(element) { return element == "templates"; }

function createNew(path) {
    $("#new_dir").empty();
    $("#active_dir").empty();
    $("#loding").show()

    var str = path;
    var oldPath = str.split("/");
    var removeIndex = oldPath.findIndex(finding_index);

    var newPath = '';
    $("#active_dir").append("Active Directori : templates / ");
    for (let index = 0; index < oldPath.length - 1; index++) {
        var newPath = newPath + oldPath[index] + '/';
        if (index > removeIndex) {
            $("#active_dir").append("<a href='#' onclick='createNew(&quot;" + newPath + "&quot;)'>" + oldPath[index] + "</a> / ");

        }

    }
    jQuery.ajax({
        url: 'ajax.php',
        method: 'GET',
        dataType: 'JSON',
        data: 'path=' + path + '&act=' + 'get_dir'
    }).done(function (response) {
        $("#loding").hide();
        response.forEach(element => {
            var myPath = element['path'].toString();

            if (element['type'] == "folder") {
                $("#new_dir").append("<div class='col-md-2 temp-manager'><a href='#' onclick='createNew(&quot;" + myPath + "&quot;)'> <i class='fas fa-folder-open font120'></i> <br>" + element['name'] + "</a></div>");

            } else {
                $("#new_dir").append("<div class='col-md-2 temp-manager'><a href='#' onclick='viewImage(&quot;" + myPath + "&quot;)'> <i class='fas fa-image font120'></i> <br>" + element['name'] + "</a></div>");

            }
        });
        $("#new_dir").append("<div class='col-md-2 temp-manager'><a href='#' onclick='createNewFolder(&quot;" + path + "&quot;)'> <i class='fas fa-plus-square font120'></i> <br>Create Folder or Upload file</a> </div>");
    });

    $("#full_directory").val(path);
    // console.log("path=" + path);
}

function createNewFolder(path) {
    $("#full_directory").val(path);
    $.magnificPopup.open({
        items: {
            src: '#modalForm' // ID of modal that you want to show
        },
        type: 'inline'
    })
}

function viewImage(path) {
    $("#imgLink").attr("src", "https://dummyimage.com/600x400/ccc8cc/ccc8cc.png");

    var res = path.split("\/");
    var newPath = "";
    for (let index = 5; index < res.length; index++) {
        newPath = newPath + '/' + res[index];
    }
    $("#myImage").empty();
    $.magnificPopup.open({
        items: {
            src: '#viewTheImage' // ID of modal that you want to show
        },
        type: 'inline'
    })

    $("#imgLink").attr("src", newPath);
    $form = "<br><form method='POST'><input type='hidden' name='path' value='" + path + "'><div class='col-md-4'></div><div class='col-md-4'><button type='submit' name='submit_button' value='delete' class='btn btn-danger btn-block'>Delete</button></div></form>"
    $("#myImage").append($form);


}

function showDirectory() {
    $("#section-foldercreate").show();
    $("#section-fileupload").hide()
}

function showFileUpload() {
    $("#section-foldercreate").hide();
    $("#section-fileupload").show()
}