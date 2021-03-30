document.getElementById('fileToUpload').addEventListener('change', function(e) {
    var filename = e.target.files[0].name;
    document.getElementById('label-text').innerHTML = filename;
    validateFile(e);
});

function enterUploader(e) {
    document.getElementById('label-text').innerHTML = "Go";
    document.getElementById('file-upload-label').className = "";
    document.getElementById('file-upload-label').classList.add("file-enter-uploader");
}

function leaveUploader(e) {
    document.getElementById('label-text').innerHTML = "Upload file";
    document.getElementById('file-upload-label').className = "";
    //document.getElementById('file-upload-label').classList.remove("file-enter-uploader");
}

function validateFile(e) {
    if (draggableVerification(e)) {
        document.getElementById('label-text').innerHTML = e.dataTransfer.files[0].name;
        document.getElementById('file-upload-label').className = "";
        document.getElementById('file-upload-label').classList.add("file-successful-drop");
        document.getElementById('submit-button').disabled = false;
    } else {
        document.getElementById('label-text').innerHTML = "Incorrect file type";
        document.getElementById('file-upload-label').className = "";
        document.getElementById('file-upload-label').classList.add("file-unsuccessful-drop");
        document.getElementById('submit-button').disabled = true;
    }
}

function draggableVerification(event) {
    // var e;
    // if (event.target !== undefined) {
    //     e = event.target;
    //     console.log(e);
    // } else if (event.dataTransfer !== undefined) {
    //     e = event.dataTransfer;
    //     console.log(e);
    // } else {
    //     console.log("error: file not found");
    //     return false;
    // }
    if (event.dataTransfer.types) {
        for (var i = 0; i < event.dataTransfer.types.length; i++) {
            if (event.dataTransfer.types[i] == "Files") {
                var filename = event.dataTransfer.files[0].name;
                var isHtml = filename.match(/([a-zA-Z0-9\s_\\.\-\(\):])+(.html)$/i);
                console.log(filename);
                if (isHtml) {
                    return true;
                }
            }
        }
    }

    return false;

}