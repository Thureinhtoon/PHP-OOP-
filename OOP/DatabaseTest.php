<?php

require_once("Database.php");

$db = new Database();
echo $db->isConnected() ? "DB Connected" : "DB not Connected";

if(!$db->isConnected()){
	echo $db->getError();
	die('Unable to connect');
}

$db->query("SELECT * FROM users");
var_dump($db->resultSet());

echo "Rows: " .$db->rowCount();
var_dump($db->single());

$db->query("SELECT * FROM users where id =:id");
$db->bind(':id',2);
var_dump($db->single());