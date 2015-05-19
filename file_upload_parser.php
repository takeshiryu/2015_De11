<?php

$fileName = $_FILES["file1"]["name"]; // The file name
//------------Security purpose
$ext = pathinfo($fileName, PATHINFO_EXTENSION);
$fileName = md5($fileName . '' . time());
$fileName = $fileName . '_.' . $ext;
//------------Security purpose
$fileTmpLoc = $_FILES["file1"]["tmp_name"]; // File in the PHP tmp folder
$fileType = $_FILES["file1"]["type"]; // The type of file it is
$fileSize = $_FILES["file1"]["size"]; // File size in bytes
$fileErrorMsg = $_FILES["file1"]["error"]; // 0 for false... and 1 for true
$target_dir = "uploads/"; // Upload folder
$target_file = $target_dir . basename($fileName); // Upload path
$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION); // File extension
// If file not chosen
if (!$fileTmpLoc) {
    echo "ERROR: Please browse for a file before clicking the upload button.";
    exit();
}

// If wrong extension
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    echo "ERROR: Only JPG, JPEG, PNG & GIF files are allowed.";
    exit();
}

//If file is not an image
$check = getimagesize($fileTmpLoc);
if ($check == false) {
    echo "ERROR: File is not an image.";
    exit();
}

// If file existed
if (file_exists($target_file)) {
    echo "ERROR: File already exists.";
    exit();
}

// else upload
if (move_uploaded_file($fileTmpLoc, "uploads/$fileName")) {
    echo "$fileName upload is complete";
} else {
    echo "move_uploaded_file function failed";
}
?>