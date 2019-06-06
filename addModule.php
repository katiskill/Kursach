<?php
    if (!isset($_POST['param1']))
        header('Location: Welcome.php');
    else{
        $module=$_POST['param1'];
        $mysqli=new mysqli('localhost','root','','learning' );
        $obj=$mysqli->query("SHOW TABLES FROM `learning`");
        $arrayCount = 0;
        $same=false;
        while ($row =$obj->fetch_row())
        {
            $row[0]=='users' || $row[0]=='popular_passwords' ? null: $tableNames[$arrayCount] = substr($row[0],2);
            $arrayCount++; //only do this to make sure it starts at index 0
        }
        $count=count($tableNames);
        for ($i=0; $i < $count; $i++)
            $module===$tableNames[$i]? $same=true: null;
        if ($same)
            echo 1;
        else{
            $number=$arrayCount-1;
            $mysqli->query('CREATE TABLE `'.$number.')'.$module.'`( `Section` VARCHAR(50),`Theory` TEXT, `Question` VARCHAR(100),`Case1` VARCHAR(50),`Case2` VARCHAR(50),`Case3` VARCHAR(50),`Case4` VARCHAR(50),`Answers` VARCHAR(100),PRIMARY KEY (`Question`))');
            echo $module;
            $mysqli->close();// закрываем БД 
        }
    }
?>