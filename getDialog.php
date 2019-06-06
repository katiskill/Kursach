<?php
    if(!isset($_POST['param1']) || !isset($_POST['param2']))
        header('Location: Welcome.php');
    else{
        $sender=$_POST['param1'];
        $id=$_POST['param2'];
        
        $mysqli=new mysqli('localhost','root','','learning');
        $mysqli->query("SET NAMES 'utf8'");// устанавливаем кодировку.
        if ($mysqli->connect_errno){// проверка на успешность открытия
            printf("Соединение не удалось: %s\n", $mysqli->connect_error);
            exit();
        }
        else{
            $selected=$mysqli->query("SELECT `Messages` FROM `users` WHERE `id`='$id'");
            $user=$selected->fetch_assoc();
            $json=json_decode($user['Messages'],true);
            $count=count($json[$sender]);
            print('<br><div class="row">');
                print('<div class="col-1"></div>');
                print('<div class="col-3"><h3 class="white" id="sender" style="left:50vh;height:10vh">'.$sender.'</h3></div>');
            print('</div>');  
            for ($i=0; $i < $count; $i++){ 
                print('<div class="row" >');
                    print('<div class="col-1 colMessage"></div>');
                    print('<div class="col-3 colMessage text-left white" style="border: 2px solid white;">'.$json[$sender][$i].'</div></div><br>');      
            }
            print('<br><div class="row" >');
                print('<div class="col-1 colMessage"></div>');
                    print('<textarea class="blueBackground white" style="border: 4px solid white;" id="answer" cols="40" rows="5" placeholder="Write your answer..."></textarea></div>');
            print('<br><div class="row" >');
                print('<div class="col-1"></div>');
                print('<button type="button" class="btn btn-success" onclick="sendAnswer()">Send answer</button></div>');     
        }
        $mysqli->close();
    }

?>