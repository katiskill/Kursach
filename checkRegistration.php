<?php
    if (!isset($_POST['param1']))
        header('Location: Welcome.php');
    else
    {
        $values=json_decode($_POST['param1'],true);
        $login=$values['login'];
        $password=$values['password'];
        $repPassword=$values['repPassword'];
        if ($password!=$repPassword)
            echo "Passwords are not same";
        else
        {
            $mysqli= new mysqli("localhost","root","","learning");// открываем БД
            $mysqli->query("SET NAMES 'utf8'");// устанавливаем кодировку
            if ($mysqli->connect_errno){// проверка на ошибку при открытии
                printf("Соединение не удалось: %s\n", $mysqli->connect_error);
                $mysqli->close();
                exit();
            }
            else// если открылась, то...
            { 
                $same=false;
                $result_same=$mysqli->query("SELECT `login` FROM `users`");
                while ($row=$result_same->fetch_assoc()) 
                    $row["login"]===$login? $same=true: null;
                if ($same){
                    $mysqli->close();
                    echo 'Same login already exist';
                }
                else
                {
                    $pop=false;
                    $result_pop=$mysqli->query("SELECT * FROM `popular_passwords`");
                    while($row=$result_pop->fetch_assoc())
                        $password===$row["password"]? $pop=true: null;	
                    if ($pop){
                        $mysqli->close();
                        echo 'Your password is too popular';
                    }
                    else
                    {
                        function generateToken($length)
                        {
                            $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
                            $numChars = strlen($chars);
                            $string = '';
                            for ($i = 0; $i < $length; $i++) 
                                $string .= substr($chars, rand(0, $numChars-1), 1);
                            return $string;
                        }
                        $token=generateToken(16);
                        $mysqli->query("INSERT INTO `learning`.`users` (`login`,
                                                                        `password`,
                                                                        `token`,
                                                                        `Role`,
                                                                        `Messages`,
                                                                        `Completed`) 
                                                                            VALUES ('".$login."','".password_hash($password,PASSWORD_BCRYPT)."','".$token."','user','','')");
                        $row=$mysqli->query("SELECT `id` FROM `users` ORDER BY `id` DESC LIMIT 1");
                        $ID=$row->fetch_assoc();
                        $id=$ID['id'];
                        session_start();
                        $_SESSION['token'.$id]=$token;
                        echo $id;
                        $mysqli->close();
                    }
                }		
            }
        }
    }
?>