<?php
    session_start();
    if (!isset($_GET['module']) || !isset($_GET['index']) || !isset($_GET['id']) || !isset($_SESSION['token'.$_GET['id']]))
        header("Location: Welcome.php");
    else{
        $module=$_GET['module'];// название модуля
        $moduleIndex=$_GET['index'];// индекс модуля в БД
        $id=$_GET['id'];// id пользователя
        $mysqli=new mysqli('localhost','root','','learning');// открыть БД
        $mysqli->query("SET NAMES 'utf8'");// устанавливаем кодировку.
        if ($mysqli->connect_errno)// проверка на успешность открытия
        {
            printf("Соединение не удалось: %s\n", $mysqli->connect_error);
            exit();
        }
        else
        {
            function getSections($mysqli,$moduleIndex,$module){
                $sections = array();
                $table=$mysqli->query("SELECT * FROM `".$moduleIndex.")".$module."`");
                while($row=$table->fetch_assoc()){
                    $same=false;
                    for ($i=0; $i < count($sections); $i++)
                        $row['Section']===$sections[$i]? $same=true: null;
                    !$same? array_push($sections,$row['Section']): null;// если в массиве секций нет текущего считанного значения, добавляем значение в массив
                }
                return $sections;// возващаем массив секций модуля	
            }
            function printSections($sections,$mysqli,$module,$id){
                $count=count($sections);// количество секций в модуле
                $user=$mysqli->query("SELECT `Role`,`Completed` FROM `users` WHERE `id`='".$id."'");
                $row=$user->fetch_assoc();
                // Первая секция
                if(strpos($row['Completed'],$sections[0])!==false){
                    print('<div class="col-2 module success section">');
                    print('<a class="white " href="quiz.php?module='.$module.'&&section='.$sections[0].'&&qz=0&&id='.$id.'">'.$sections[0].'</a></div>&nbsp');
                }
                else{
                    print('<div class="col-3 module section">');
                    print('<a class="moduleLink " href="quiz.php?module='.$module.'&&section='.$sections[0].'&&qz=0&&id='.$id.'">'.$sections[0].'</a></div>&nbsp');
                }
                // Остальные
                for ($i=1; $i <$count; $i++){
                    $previous=$i-1; 
                    if (strpos($row['Completed'],$sections[$i])!==false){
                        print('<div class="col-3 module success section">');
                            print('<a class="white " href="quiz.php?module='.$module.'&&section='.$sections[$i].'&&qz=0&&id='.$id.'">'.$sections[$i].'</a></div>&nbsp');
                    }
                    elseif ($row['Role']=='admin' || strpos($row['Completed'],$sections[$previous])!==false){
                        print('<div class="col-3 module section">');
                            print('<a class="moduleLink " href="quiz.php?module='.$module.'&&section='.$sections[$i].'&&qz=0&&id='.$id.'">'.$sections[$i].'</a></div>&nbsp');
                    }
                    else{
                        print('<div class="col-3 module section">');
                            print('<a class="moduleLink disabled">'.$sections[$i].'</a></div>&nbsp');
                    }
                }
            }
        } 
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?=$module;?></title>
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
            <a class="navbar-brand " href="Welcome.php?id=<?=$id;?>"><i class="fas fa-home white icon"></i></a>
        </div> 
    </nav>
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center form" style="margin-left: 30vh;">
            <div class="col"></div>
            <div class="col-10">
                <div class="row">
                    <?php printSections(getSections($mysqli,$moduleIndex,$module),$mysqli,$module,$id)?>
                </div>
            </div>
            <div class="col"></div>
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
<?php $mysqli->close();?>