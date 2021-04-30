<?php
    include 'emogrify.php';

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $uploadOk = 1;
    error_log( "files: ".implode($_FILES["fileToUpload"]));

    //start file upload validation
    if($imageFileType != "html"){
        echo $imageFileType;
        echo "invalid file type\n";
        $uploadOk = 0;
    }
    if (file_exists($target_file)) {    
        echo "file already exists\n";
        $uploadOk = 0;
    }
    //end file upload validation

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "error: file was not uploaded.\n";
    // if everything is ok, try to upload file
    } else {
        if (isset($_FILES["fileToUpload"]["tmp_name"])) {
            emogrifyUpload($_FILES["fileToUpload"]["tmp_name"]);
            //testTemp($_FILES["fileToUpload"]["tmp_name"]);
        } else {
            echo "error uploading file.\n";
        }

        // if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        //     echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.\n";
        // } else {
        //     echo "error uploading file.\n";
        // }
    }
?>