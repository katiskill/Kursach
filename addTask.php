<?php
    if (!isset($_POST['param1']) || !isset($_POST['param2']) || !isset($_POST['param3']))
        header("Location: Welcome.php");
    else{
        $answers=json_decode($_POST['param1'],true);
        $cases=json_decode($_POST['param2'],true);
            $case1=$cases['1'];
            $case2=$cases['2'];
            $case3=$cases['3'];
            $case4=$cases['4'];
        $params=json_decode($_POST['param3'],true);
            $module=$params['module'];
            $section=$params['section'];
            $theory=$params['theory'];
            $task=$params['task'];
        $right=implode(';',$answers).';';
        $mysqli= new mysqli("localhost","root","","learning");// открываем БД "learning" на хосте "localhost" с логином "root" и пустым паролем
        $mysqli->query("SET NAMES 'utf8'");// устанавливаем кодировку.
        if ($mysqli->connect_errno)// проверка на успешность открытия
        {
            printf("Соединение не удалось: %s\n", $mysqli->connect_error);
            exit();
        }
        else{
            $obj=$mysqli->query("SHOW TABLES LIKE '%)".$module."'");
            $row=$obj->fetch_row();
            $row=$mysqli->query("INSERT INTO `".$row[0]."` (`Section`,`Theory`,`Question`,`Case1`,`Case2`,`Case3`,`Case4`,`Answers`) VALUES ('".$section."','".$theory."','".$task."','".$case1."','".$case2."','".$case3."','".$case4."','".$right."')");
            $mysqli->close();
        }
    }
?>