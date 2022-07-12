<?php
$file = $_FILES['image']['name'];
$path = 'image/';
$target = $path . basename($file);

if(validateFile($file)) {
    if ( ! is_dir($path)) {
        mkdir($path);
    }
    move_uploaded_file($_FILES['image']['tmp_name'], $target);
}
else {
    echo "Расширение файла может быть только jpg или png";
}

function validateFile($name): bool
{
    $info = pathinfo($name, PATHINFO_EXTENSION);
    return ($info == "jpg" || $info == "png");
}