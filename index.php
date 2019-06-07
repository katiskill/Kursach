<?php
    $mysqli=new mysqli('localhost','root','','learning' );// открываем БД 'learning' с логином 'root' пустым паролем н хосте 'localhost' 
    $obj=$mysqli->query("SHOW TABLES FROM `learning`");// объект, содержащий информацию о всех таблицах в БД
    $arrayCount = 0;
    session_start();// открываем сессию
    if (isset($_GET['id']) && isset($_SESSION['token'.$_GET["id"]]))// проверка на авторизованность пользователя 
        $id=$_GET['id'];
    while ($row =$obj->fetch_row())
    {
        $row[0]=='users' || $row[0]=='popular_passwords' ? null: $tableNames[$arrayCount] = $row[0];// добавляем в массив названия всех таблиц, кроме 'users' и 'popular_passwords'
        $arrayCount++; //only do this to make sure it starts at index 0
    }
    function printModuls($tableNames,$mysqli,$id)// функция вывода на экран списка модулей
    {
        $subject=$mysqli->query("SELECT `Role`,`Completed` FROM `users` WHERE `id`='".$id."'");// выбираем запись пользователя в таблице пользователей
        $row=$subject->fetch_assoc();// в ассоциативный массив
        $assoc=json_decode($row['Completed'],true);
        $moduleName=substr($tableNames[0],2);
        $moduleIndex=substr($tableNames[0],0,1);// индекс модуля
        print('<div class="row">');// вывод на экран списка модулей
            print('<div class="col"></div>');
        if($id!==null){
            if( $assoc===null || !in_array($moduleIndex,array_keys($assoc))){
                print('<div class="col-5 module">');
                    print('<a class="moduleLink" href="module.php?module='.$moduleName.'&&index='.$moduleIndex.'&&id='.$id.'">'.$moduleName.'</a>');
            }
            elseif(in_array($moduleIndex,array_keys($assoc))){
                print('<div class="col-5 module success">');
                    print('<a class="white" href="module.php?module='.$moduleName.'&&index='.$moduleIndex.'&&id='.$id.'">'.$moduleName.'</a>');
            }
        }
        else{
                print('<div class="col-5 module">');
                    print('<a class="moduleLink disabled">'.$moduleName.'</a>');
        }         
                print('</div>');
            print('<div class="col"></div>');
        print('</div>');
        
        $count=count($tableNames);
        for ($i=1; $i < $count; $i++)
        { 
            $moduleName=substr($tableNames[$i],2);// название модуля без индекса и )
            $moduleIndex=substr($tableNames[$i],0,1);// индекс модуля
            $previous=$moduleIndex-1;
            if($id!==null){
                print('<div class="row">');// вывод на экран списка модулей
                    print('<div class="col"></div>');
                        if($assoc!==null && in_array($previous,array_keys($assoc))){
                            print('<div class="col-5 module">');
                                print('<a class="moduleLink " href="module.php?module='.$moduleName.'&&index='.$moduleIndex.'&&id='.$id.'">'.$moduleName.'</a>');  
                        }    
                        else if ($assoc!==null && in_array($moduleIndex,array_keys($assoc))){
                            print('<div class="col-5 module success">');   
                                print('<a class="white" href="module.php?module='.$moduleName.'&&index='.$moduleIndex.'&&id='.$id.'">'.$moduleName.'</a>');
                        }
                        else{
                            print('<div class="col-5 module">');
                                print('<a class="moduleLink disabled">'.$moduleName.'</a>');// иначе недоступна (также для случая неавторизованного входа) 
                        }
                        print('</div>');
                        print('<div class="col"></div>');
                print('</div>');
            }
            else{
                print('<div class="row">');
                        print('<div class="col"></div>');
                        print('<div class="col-5 module">');
                            print('<a class="moduleLink disabled">'.$moduleName.'</a></div>');
                        print('<div class="col"></div>');
                print('</div>');
            }
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>JavaScript learning</title>
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
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
</head>
<body class="blueBackground">
    <nav class="navbar navbar-expand-lg">
        <?php
            if (isset($id) && isset($_SESSION['admin'.$id]) && $_SESSION['admin'.$id]===$id)// если пользователь-админ, то ему доступно выпадающее меню с добавлением новых модулей и заданий к курсу
            {
                print('<div class="dropdown">');
                    print('<a href="" class="nav-link dropdown-toggle white" id="DropdownMenuLink" data-toggle="dropdown">Add...</a>');
                    print('<ul class="dropdown-menu">');
                        print('<li><span class="dropdown-item"><button class="btn add" type="submit" onclick="addModule()">new module</button></span></li>');
                        print('<li><span class="dropdown-item "><button class="btn add" type="submit" onclick="goTask('.$id.')">new task</button></span></li>');
                    print('</ul></div>');
            }
        ?>
        <div class="navbar-inner">
            <a class="navbar-brand white" href=""><h3 id="welcomeHeader">Welcome to the JavaScript learning</h3></a>
        </div> 
        <div>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <?php
                        if(isset($id)){
                            print('<a  href="account.php?id='.$id.'" data-toggle="tooltip" title="My account"><i class="far fa-address-card white icon"></i></a>');
                            print('</li>');
                            print('<li>');
                            print ('<button class="btn blueBackground white" type="submit" id="exit" value="'.$id.'" onclick="Exit()"><h5>Exit</h5></button>');// если пользователь авторизован, то вместо кнопки 'login' появляется кнопка 'exit'
                        }                                               
                        else
                            print ('<button class="btn blueBackground white" type="submit" onclick="goLogin()"><h5>Login</h5></button>'); 
                    ?>
                </li>
                <li><button class="btn blueBackground white" type="submit" onclick="goRegistration()"><h5>Registration</h5></button></li>
            </ul>
        </div>
        
    </nav>
    <div class="container-fluid" id="moduls">
        <br><br><br><br><br><br>
        <?php
            isset($id)? null: $id=null;
            printModuls($tableNames,$mysqli,$id); 
        ?>
    </div>
</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script 
    src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" 
    integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" 
    crossorigin="anonymous">
</script>
<script src="learning.js"></script>
<?php $mysqli->close();// закрываем БД?>