<?php
include 'db_helper.php';
header("Content-Type:application/json");
$db_helper = new DbHelper();
$db_helper->createDbConnection();
if($_SERVER["REQUEST_METHOD"]=="POST"){

$name = $_POST["name"];
$coleage = $_POST["college"];
 
$db_helper->insertNewUser($name,$coleage);

}
?>