<?php
if(isset($_POST['id_doing'])){
    require '../db_conn.php';

    $id = $_POST['id_doing'];

    if(empty($id)){
       echo 'error';
    }else {
        $todos = $conn->prepare("SELECT id_doing, checked FROM todo WHERE id_doing=?");
        $todos->execute([$id]);

        $todo = $todos->fetch();
        $uId = $todo['id_doing'];
        $checked = $todo['checked'];

        $uChecked = $checked ? 0 : 1;

        $res = $conn->query("UPDATE todos SET checked=$uChecked WHERE id_doing=$uId");

        if($res){
            echo $checked;
        }else {
            echo "error";
        }
        $conn = null;
        exit();
    }
}else {
    header("Location: ../indextodo.php?mess=error");
}