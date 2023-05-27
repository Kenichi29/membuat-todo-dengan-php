<?php

if(isset($_POST['id_doing'])){
    require '../db_conn.php';

    $id = $_POST['id_doing'];

    if(empty($id)){
       echo 0;
    }else {
        $stmt = $conn->prepare("DELETE FROM todo WHERE id_doing=?");
        $res = $stmt->execute([$id]);

        if($res){
            echo 1;
        }else {
            echo 0;
        }
        $conn = null;
        exit();
    }
}else {
    header("Location: ../indextodo.php?mess=error");
}