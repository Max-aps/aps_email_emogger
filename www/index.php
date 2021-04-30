<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/styles.css" />
</head>

<body>
    <header class="container">
        <div class="logo-container col-2">
            <img src="assets/aps_logo.svg" alt="aps logo" />
        </div>
    </header>
    <div class="container form-container">
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <label for="fileToUpload" id="file-upload-label" ondragenter="enterUploader(event)" ondragleave="leaveUploader(event)" ondrop="validateFile(event)">
              <!-- ondragenter="enterUploader(event)" ondragleave="leaveUploader(event)" ondrop="validateFile(event)" -->
              <span id = "label-text">Upload File</span>
              <input type="file" name="fileToUpload" id="fileToUpload">
            </label>
            <button id="submit-button" type="submit" name="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>

    <script src="scripts/scripts.js"></script>
</body>

</html>