<?php
    $id=$_POST['param1'];
    $mysqli= new mysqli("localhost","root","","learning");// открываем БД "learning" на хосте "localhost" с логином "root" и пустым паролем
	$mysqli->query("SET NAMES 'utf8'");// устанавливаем кодировку.
	if ($mysqli->connect_errno)
	{
    	printf("Соединение не удалось: %s\n", $mysqli->connect_error);
    	exit();
    }
    else
    {
        $mysqli->query("UPDATE `users` SET `token` = '' WHERE `users`.`id` = '$id'");// удаляем токен из нашей зписи в таблице пользователей
        session_start();
        unset($_SESSION["token".$id]);// удаляем сессию
        unset($_SESSION['admin'.$id]); 
		$mysqli->close();// закрываем БД
    }
?>