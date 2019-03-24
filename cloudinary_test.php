<?php
//prep cloudinary backup
require_once 'vendor/autoload.php';
include 'cloudinarySettings.php';
echo "loading ready ";
    //Get backup from Cloudinary
    $getBack = fopen(cloudinary_url("cr000/VA323.txt", array("resource_type" => "raw")), 'r');
    echo "getBack ";
    echo $getBack;
    file_put_contents("VA323.txt", $getBack);
    echo "wrote down";

?>
<html>
    <head></head>
    <body></body>
        </html>