<?php
    $login=null;
    $password=null;
    function generateToken($length)
    {
        $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ0123456789';
        $numChars = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; $i++) 
            $string .= substr($chars, rand(0, $numChars-1), 1);
        return $string;
    }
    if (isset($_POST['checkLogin'])) 
    {
        $login=htmlspecialchars($_POST['login']);
        $password=htmlspecialchars($_POST['password']);
        $mysqli= new mysqli("localhost","root","","learning");// открываем БД "learning" на хосте "localhost" с логином "root" и пустым паролем
        $mysqli->query("SET NAMES 'utf8'");// устанавливаем кодировку.
        if ($mysqli->connect_errno)// проверка на успешность открытия
        {
            printf("Соединение не удалось: %s\n", $mysqli->connect_error);
            exit();
        }
        else
        {
            $good=false;
            $admin=$mysqli->query("SELECT * FROM `users`");
            while ($row=$admin->fetch_assoc())
            {
                if ($row["login"]===$login && password_verify($password, $row["password"]))
                {
                    $id=$row['id'];
                    $good=true;
                }
            }
            if ($good) 
            {
                $token=generateToken(16);
                $mysqli->query("UPDATE `users` SET `token` = '$token' WHERE `users`.`login` = '$login'");
                session_start();
                $_SESSION['token'.$id]=$token;
                $string=$mysqli->query("SELECT `Role` FROM `users` WHERE `login` = '$login'");
                $row=$string->fetch_assoc();
                $row['Role']=='admin'? $_SESSION['admin'.$id]=$id: null;
                $mysqli->close();
                header("Location: Welcome.php?id=$id");
            }
            else
                echo "<script type=\"text/javascript\">alert(\"Incorrect login or password\")</script>";
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login form</title>
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
<body class="blueBackground">
    <nav class="navbar navbar-inverse">
        <div class="navbar-header">
            <a class="navbar-brand " href="Welcome.php"><i class="fas fa-home white icon"></i></a>
        </div>
        <div class="navbar-inner">
            <span class="navbar-brand white"><h3 class="headers">Sign in</h3></span>
        </div>
    </nav>
    <div class="container">
        <div class="row justify-content-center align-items-center form">
            <form method="POST" action="" id="Form">
                <div class="form-group">
                    <label  for="login">
                        <span class="white" id="loginLabel">Login:</span>
                    </label>
                    <input type="text" class="form-control" id="login" name="login" placeholder="Enter your login..." value="<?= $login; ?>" required>
                </div>
                <div class="form-group">
                    <label  for="password">
                        <span class="white" id="passwordLabel">Password:</span>
                    </label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password..." value="<?= $password; ?>" required>
                    <br>
                    <button type="submit" class="btn btn-success" id="checkLogin" name="checkLogin">Login</button>
                </div>
            </form>   
        </div>
    </div>   
</body>
</html>

<script 
    src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" 
    integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" 
    crossorigin="anonymous">
</script>
<script src="learning.js"></script>