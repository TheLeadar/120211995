<?php
include 'db_helper.php';
header("Content-Type:application/json");
$db_helper = new DbHelper();
$db_helper->createDbConnection();
if($_SERVER["REQUEST_METHOD"]=="POST"){
$id = $_POST["id"];
$name = $_POST["name"];
$coleage = $_POST["college"];

$db_helper->updateUser($id,$name,$colleage);
}
?>