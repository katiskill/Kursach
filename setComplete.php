<?php
    if (!isset($_POST['param1']))
        header('Location: Welcome.php');
    else{
        $DBdata=json_decode($_POST['param1'],true);
        $moduleIndex=$DBdata['moduleIndex'];
        $moduleName=$DBdata['moduleName'];
        $section=$DBdata['section'];// название секции
        $id=$DBdata['id'];// id пользователя
        $mysqli=new mysqli('localhost','root','','learning');// открыть БД
        $mysqli->query("SET NAMES 'utf8'");// устанавливаем кодировку.
        if ($mysqli->connect_errno){// проверка на успешность открытия
            printf("Соединение не удалось: %s\n", $mysqli->connect_error);
            exit();
        }
        else{
            $select=$mysqli->query('SELECT `Completed` FROM `users` WHERE `id`="'.$id.'"');
            $completed=$select->fetch_assoc();
            $assoc=json_decode($completed['Completed'],true);
            if($assoc!==null){
                array_key_exists($moduleIndex,$assoc)? $assoc[$moduleIndex][]=$section : $assoc+=array($moduleIndex=>array($section));
                $encoded=addslashes(json_encode($assoc));
            }
            else
                $encoded=json_encode(array($moduleIndex=>array($section)));

            $mysqli->query("UPDATE `users` SET `Completed`='$encoded' WHERE `id` = '$id'");                             
        }
        $mysqli->close();
    }
?>