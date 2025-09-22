<?php
ob_start(); 
include 'connect_db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $conn->query("DELETE FROM todos WHERE id=$id");
    header("Location: index.php"); // redirect ต้องมาก่อน HTML ใดๆ
    exit;
}
