<?php
include 'db_helper.php';
header("Content-Type:application/json");
$db_helper = new DbHelper();
$db_helper->createDbConnection();
if($_SERVER["REQUEST_METHOD"]=="GET"){
$id = $_POST["id"];
$db_helper->deleteuser($id);
}
?>