<?php
    if (!isset($_POST['param1']))
        header('Location: Welcome.php');
    else{
        $mysqli=new mysqli('localhost','root','','learning');
        $mysqli->query("SET NAMES 'utf8'");// устанавливаем кодировку.
        if ($mysqli->connect_errno)// проверка на успешность открытия
        {
            printf("Соединение не удалось: %s\n", $mysqli->connect_error);
            exit();
        }
        else
        {
            $admins = array();
            $params=json_decode($_POST['param1'],true);
            $login=$params['login'];
            $message=$params['message'];
            $admin=$mysqli->query('SELECT `id`,`Messages` FROM `users` WHERE `Role`="admin"');
            while($row=$admin->fetch_assoc()){
                $admins[]=$row['id'];
                $json=$row['Messages'];
            }
            $assoc=json_decode($json,true); 
            if($assoc!==null){
                array_key_exists($login,$assoc)? $assoc[$login][]=$message : $assoc+=array($login=>array($message));
                $encoded=addslashes(json_encode($assoc));
            }
            else
                $encoded=addslashes(json_encode(array($login=>array($message)))); 
            foreach ($admins as $key => $value)
                $check=$mysqli->query("UPDATE `users` SET `Messages`='$encoded' WHERE `id`='$value'");
        }
        $mysqli->close();
    }
?>