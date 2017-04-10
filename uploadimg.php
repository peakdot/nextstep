<?php
function uploadImage ($file, $target_file_name, $width, $height, $destination){
    $uploadOk = 1;

    //Get image type
    $imageFileType = trim(strtolower(pathinfo(basename($_FILES[$file]["name"]),PATHINFO_EXTENSION)));
    $target_file =$target_file_name.".".$imageFileType;


    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES[$file]["tmp_name"]);
        if($check !== false) {
            //echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            return "picexterr";
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    if (!file_exists($_FILES[$file]["tmp_name"])) {
        return "picincerr1";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES[$file]["size"] > 50*1024*1024) {
        return "pictoolarge";
        $uploadOk = 0;
    }

    if ($_FILES[$file]["size"] < 3*1024) {
        return $_FILES[$file]["size"];
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        return "picexterr".$imageFileType;
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        return "picincerr2";
    // if everything is ok, try to upload file
    } else {
        if (saveImage($_FILES[$file]["tmp_name"], $imageFileType, $width, $height, $destination.$target_file)){
            return "succ";
        } else {
            return "picincerr3";
        }
    }
}

function uploadImageX ($file, $target_file_name, $imageFileType, $tmp_name, $size, $destination){
    $uploadOk = 1;
    $target_file =$target_file_name.".".$imageFileType;

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($tmp_name);
        if($check !== false) {
            //echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            return "picexterr";
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    if (!file_exists($tmp_name)) {
        return "picincerr1";
        $uploadOk = 0;
    }

    // Check file size
    if ($size > 50*1024*1024) {
        return "pictoolarge";
        $uploadOk = 0;
    }

    if ($size < 3*1024) {
        return $_FILES[$file]["size"];
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        return "picexterr".$imageFileType;
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        return "picincerr2";
    // if everything is ok, try to upload file
    } else {
        list($width, $height) = getimagesize($tmp_name);
        if (saveImage($tmp_name, $imageFileType, $width, $height, $destination.$target_file)){
            return "succ";
        } else {
            return "picincerr3";
        }
    }
}

function saveImage($source, $ext, $def_width, $def_height, $destination) {
    list($width, $height) = getimagesize($source);
    $ratioh = $height / $def_height;
    $ratiow = $width / $def_width;
    $ratio = min($ratioh, $ratiow);
    // New dimensions
    $newwidth = intval($ratio * $width);
    $newheight = intval($ratio * $height);
    $size = min($width, $height);
    $newwidth = $def_width;
    $newheight = $def_height;

    $newImage = imagecreatetruecolor($newwidth, $newheight);

    $sourceImage = null;

    // Generate source image depending on file type
    switch ($ext) {
        case "jpg":
        $sourceImage = imagecreatefromjpeg($source);
        break;
        case "jpeg":
        $sourceImage = imagecreatefromjpeg($source);
        break;
        case "gif":
        $sourceImage = imagecreatefromgif($source);
        break;
        case "png":
        $sourceImage = imagecreatefrompng($source);
        break;
    }

    if ($sourceImage == false){
        return false;
    }

    if(imagecopyresampled($newImage, $sourceImage, 0, 0, 0, 0, $newwidth, $newheight, $width, $height)==false){
        return false;
    }

    echo $source."<br>".$destination."<br>".$ext."<br>";
    // Output file depending on type
    switch ($ext) {
        case "jpg":
        $res = imagejpeg($newImage, $destination);
        break;
        case "jpeg":
        $res = imagejpeg($newImage, $destination);
        break;
        case "gif":
        $result = imagegif($newImage, $destination);
        break;
        case "png":
        $res = imagepng($newImage, $destination);
        break;
        default: 
        return false;
    }

    if($res == false){
        return false;
    } else {        
        return true;
    }
}

function createNameforImage() {
    $seed = str_split('abcdefghijklmnopqrstuvwxyz'.'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.'0123456789'); 
    // and any other characters
    shuffle($seed); 
    // probably optional since array_is randomized; this may be redundant
    $rand = '';
    foreach (array_rand($seed, 30) as $k) $rand .= $seed[$k];   
    $date = Date("Y").Date("m").Date("d").Date("H").Date("i");
    $accpro = $date.'_'.$rand;
    return $accpro;
}
?>