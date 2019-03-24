<?php

// Prevent caching.
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 01 Jan 1996 00:00:00 GMT');

//setup default timezone
date_default_timezone_set ('Asia/Hong_Kong');

// The JSON standard MIME header.
header('Content-type: application/json');

//prep cloudinary backup
require_once 'vendor/autoload.php';
include 'cloudinarySettings.php';

$anyoneIn = "";
// This $_GET[] parameter is sent by our javascript client.
$locate=$_GET['locate'];
$status = $_GET['id'];
if ($status == "yes") {
    $anyoneIn = "有人";
} else if ($status == "no") {
    $anyoneIn = "冇人";
}


if ($anyoneIn !== ""){
    //combine all inputs to JSON-ish array
    $arr=array('stat'=>$anyoneIn,'time'=>date("y-m-d H:i:s"),'place'=>$locate);
    //Write an encoded JSON to plain txt
    $file=fopen($locate.".txt","w");
    fwrite($file, json_encode($arr));
    fclose($file);
    //Backup data to Cloudinary
    \Cloudinary\Uploader::upload(getcwd() . DIRECTORY_SEPARATOR . $locate.".txt" , array("use_filename" => TRUE, "unique_filename" => false, "folder" => "cr000","overwrite" => TRUE, "resource_type" => "auto"));
};

// Here's some data that we want to send via JSON.
// We'll include the parameter so that we
// can show that it has been passed in correctly.
// You can send whatever data you like.

if (!file_exists($locate.txt)){
    //Get backup from Cloudinary
    $getBack = fopen(cloudinary_url("cr000/".$locate.".txt", array("resource_type" => "raw")), 'r');
    file_put_contents($locate.".txt", $getBack);
};
    $file=fopen($locate.".txt","r");
    $show = fread($file,filesize($locate.".txt"));
    fclose($file);

// Send the data.
if ($show !==false){
echo $show;
};
?>

