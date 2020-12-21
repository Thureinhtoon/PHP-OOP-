<?php
require_once "inc/header.php";
if(isset($_GET['id'])){
    $id = $_GET['id']; 
    $sql = "delete from crud where id=?";
    $res =$pdo->prepare($sql)->execute([$id]);
    header('location:index.php?delete=success');
}
?>