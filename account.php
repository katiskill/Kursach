<?php
    session_start();
    if (!isset($_GET['id']) || !isset($_SESSION['token'.$_GET['id']]))
        header("Location: Welcome.php");
    else{
        $id=$_GET['id'];
        $mysqli=new mysqli('localhost','root','','learning');
        $mysqli->query("SET NAMES 'utf8'");// устанавливаем кодировку.
        if ($mysqli->connect_errno)// проверка на успешность открытия
        {
            printf("Соединение не удалось: %s\n", $mysqli->connect_error);
            exit();
        }
        else
        {
            $allSections=array();
            $completedSections=array();
            $obj=$mysqli->query('SHOW TABLES LIKE "%)%"');// поиск таблиц модулей
            $countAllModuls=$obj->num_rows;// общее кол-во модулей в курсе
            while($table=$obj->fetch_row()){
                $module=$mysqli->query('SELECT `Section` FROM `'.$table[0].'`');
                while($row=$module->fetch_assoc())
                    !in_array($row['Section'],$allSections)? $allSections[]=$row['Section'] : null;
            }  
            $selected=$mysqli->query('SELECT `login`,`Role`,`Messages`,`Completed` FROM `users` WHERE `id`="'.$id.'"');
            $user=$selected->fetch_assoc();
            $mail=json_decode($user['Messages'],true);
            $completed=json_decode($user['Completed'],true);
            if($completed!==null){
                foreach ($completed as $module => $sections){
                    $count=count($sections);
                    for ($i=0; $i <$count ; $i++)
                        $completedSections[]=$sections[$i];
                }
                $countCompletedModuls=count(array_keys($completed));// кол-во пройденных(начатых) модулей
                $countCompletedSections=count($completedSections);// кол-во пройденных секций
            }
            else{
                $countCompletedModuls=0;
                $countCompletedSections=0;
            }
            $countAllSections=count($allSections);// общее кол-во секций в курсе
            $progress=$countCompletedSections/$countAllSections*100;// отношение количества пройденных секций к общему числу секций в процентах
            
                                                        //Создаём массив отправителей из строки `Messages` из БД
            function getSenders($mail){
                $users=array_keys($mail);
                return $users; 
            }
                                                        //Формируем опции в выпадающем списке по отправителям сообщений                                           
            function printSenders($senders){
                $count=count($senders);
                for ($i=0; $i < $count; $i++) 
                    print('<li class="category-title">'.$senders[$i].'</li>');
            }
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        <?=$user['login'];?>    
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <noscript>Please, activate JavaScript in your browser</noscript> 
    
    <link rel='stylesheet'
          href='https://use.fontawesome.com/releases/v5.5.0/css/all.css' 
          integrity='sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU' 
          crossorigin='anonymous'> 

    <link rel="stylesheet" 
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" 
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" 
          crossorigin="anonymous"> 
    <link href="main.css" rel="stylesheet" type="text/css">
</head>
<body class="blueBackground" onload="drawProgress('<?=$progress?>')">
    <nav class="navbar navbar-expand-lg blueBackground">
        <div class="navbar-header">
            <a data-toggle="tooltip" title="Back" class="navbar-brand " href="Welcome.php?id=<?=$id;?>"><i class="fas fa-long-arrow-alt-left white icon"></i></a>
        </div> 
        <div class="navbar-inner"><span class="navbar-brand white"><h3 style="padding-left: 15vh;">Hello, @<?=$user['login'];?></h3></span></div>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <button class="btn dropdown-toggle blueBackground white" data-toggle="dropdown">Messages<b class="navbar-toggler-icon" ></b></button>
                <ul class="dropdown-menu" style="border: 2px solid antiquewhite;">
                    <?php printSenders(getSenders($mail));?>
                </ul>
            </li>
        </ul>
    </nav>
    <input type="hidden" id="hiddenInAccount" value="<?=$id?>">
    <div class="container-fluid" id="main">
        <div class="row justify-content-center align-items-center form" id="progress">
            <canvas id="canvas" width="500" height="360">Your browser don't support 'Canvas' :(</canvas>
            <ul class="white list" >
                <li id="progressHeader">Your progress:</li><br>
                <li class="progressItem">completed <?=$progress?>% of course</li>
                <li class="progressItem"><?=$countCompletedSections?> sections of <?=$countAllSections?> in total</li>
                <li class="progressItem"><?=$countCompletedModuls?> moduls of <?=$countAllModuls?> in total</li>
            </ul>
        </div>   
    </div>     
</body>
</html>
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>﻿
<!-- Bootstrap -->
<script 
    src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" 
    integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" 
    crossorigin="anonymous">
</script>
<!-- myScript -->
<script src="learning.js"></script>
<script type="text/javascript">viewMessages();</script>
<?php $mysqli->close();?>