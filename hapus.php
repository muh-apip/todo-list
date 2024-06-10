<?php

error_reporting(E_ALL);

include './koneksi.php';
include './todo-list.php';

session_start();

if (!isset($_SESSION['username'])) {
    header("location:login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    if ($id > 0) {
        $todoList = new TodoList($conn);
        $todoList->deleteTodoById($id);
    }
}

header("location:index.php");  
exit;
?>
