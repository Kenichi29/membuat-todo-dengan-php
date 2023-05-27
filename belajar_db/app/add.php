<?php

if(isset($_POST['doing']))
{
    require '../db_conn.php';

    $title = $_POST['doing'];

    if(empty($title))
    {
        header("Location: ../indextodo.php?mess=error");
    }
    else
    {
        $stmt = $conn->prepare("INSERT INTO todo(doing) VALUE(?)");
        $res = $stmt->execute([$title]);

        if($res)
        {
            header("Location: ../indextodo.php?mess=success");
        }
        else
        {
            header("Location: ../indextodo.php");
        }
        $conn = null;
        exit();
        
    }
}
else
{
    header("Location: ../indextodo.php?mess=error");
}