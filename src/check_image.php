<?php
require_once("lib/medoo.php");
require_once("includes/settings.php");

$database = new medoo([
    'database_type' => 'mysql',
    'database_name' => $settings["db"]["name"],
    'server' => $settings["db"]["host"],
    'username' => $settings["db"]["user"],
    'password' => $settings["db"]["pass"],
    'charset' => 'utf8'
]);

$item = $database->select('lsww_fbimages_items', [
    'redirect',
    'image',
    'type'
], [
    'keyword' => $_GET['image']
]);

if(strpos($_SERVER['HTTP_USER_AGENT'],'visionutils') !== false || strpos($_SERVER['HTTP_USER_AGENT'],'facebookexternalhit') !== false) {
    header('Content-Type: image/'.$item[0]['type']);
    readfile(str_replace($settings["domain"],"",$item[0]['image']));
} else {
    header("HTTP/1.1 301 Moved Permanently");
    header("Location:".$item[0]['redirect']);
    exit;
}
?>