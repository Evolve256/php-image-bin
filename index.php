<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>Upload Image</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" crossorigin="anonymous">
    <style>
        .files input {
            padding: 120px 0px 85px 30.4%;
            text-align: center !important;
            margin: 0;
            width: 100% !important;
        }
        .files{ position:relative}
        .color input{ background-color:#f1f1f1;}
        .files:before {
            position: absolute;
            bottom: 30px;
            left: 0;  pointer-events: none;
            width: 100%;
            right: 0;
            height: 100px;
            content: "Drag an image here or select one.";
            display: block;
            margin: 0 auto;
            font-weight: 600;
            text-align: center;
        }
        body{ font: 14px sans-serif; }
        .wrapper{ width: 670px; padding: 20px; }
    </style>
</head>
<body>
<div class="wrapper">
    <h2>Image Uploader</h2>
    <p>All images are deleted from the server after being viewed.</p>
    <div class="well">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                        <div class="form-group files">
                            <label>Upload Your File </label><br>
                            <input type="file" class="form-control" id="f" name="f" accept="image/png, image/gif, image/jpeg, image/jpg">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div><br>
        <?php
        session_start();
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $target_dir = "i/";
            $target_file = $target_dir . basename($_FILES["f"]["name"]);
            $uploadOk = 1;
            $uploadError = "";
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            $rand = $target_dir.bin2hex(random_bytes(4)).".".$imageFileType;
            if (isset($_POST["submit"])) {
                $check = getimagesize($_FILES["f"]["tmp_name"]);
                if ($check !== false) {
                    $uploadOk = 1;
                } else {
                    $uploadError = "Error: File is not an image.";
                    $uploadOk = 0;
                }
            }
            if (file_exists($target_file)) {
                $uploadError = "Error: File already exists.";
                $uploadOk = 0;
            }
            if ($_FILES["f"]["size"] > 500000) {
                $uploadError = "Error: Your file is too large.";
                $uploadOk = 0;
            }
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif") {
                $uploadError = "Error: Only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }
            if(!file_exists($_FILES['f']['tmp_name']) || !is_uploaded_file($_FILES['f']['tmp_name'])) {
                $uploadError = 'Error: No file was uploaded.';
                $uploadOk = 0;
            }
            if ($uploadOk == 0) {
                echo '<div class="alert alert-danger">'.$uploadError."</div>";
            } else {
                if (move_uploaded_file($_FILES["f"]["tmp_name"], $rand)) {
                    echo '<div class="alert alert-success">'."The file " . "<a href='//" . php_uname("n") . "/i.php?i=" . ltrim($rand, "i/") . "'>". php_uname("n") . "/i.php?i=" . ltrim($rand, "i/") . "</a>" ." has been uploaded." . "</div>";
                } else {
                    echo '<div class="alert alert-danger">'.$uploadError."</div>";
                }
            }
        }
        ?>
    </div>
</div>
</body>
</html>