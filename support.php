<?php
    session_start();
    if (!isset($_GET['module']) || !isset($_GET['section']) || !isset($_GET['qz']) || !isset($_GET['id']) || !isset($_SESSION['token'.$_GET['id']]))
        header('Location: Welcome.php');
    else{
        $module=$_GET['module'];
        $section=$_GET['section'];
        $qz=$_GET['qz'];
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
            $obj=$mysqli->query("SHOW TABLES LIKE '%)".$module."'");// поиск таблицы модуля
            $row=$obj->fetch_row();// таблица модуля в ассоциативном массиве
            $fullModule=$row[0];// полное название модуля
            $moduleIndex=substr($row[0],0,1);// индекс модуля
            $previousModule=$moduleIndex-1;
            $sections = array();// массив секция модуля
            $list=$mysqli->query('SELECT `Section` FROM `'.$fullModule.'`');// выбираем секции из таблицы модуля
            while($row=$list->fetch_assoc())
                in_array($row['Section'],$sections)? null: $sections[]=$row['Section'];// заполняем массив секциями модуля
            $sectionIndex=array_search($section,$sections);// номер выбранной секции в массиве
            $previousSection=$sectionIndex-1;// номер предыдущей секции
            $subject=$mysqli->query('SELECT `login`,`Completed` FROM `users` WHERE `id`="'.$id.'"');// выбираем строку пройденных этапов в записи пользователя
            $row=$subject->fetch_assoc();// пройденнное в ассоциативном массиве
            if($moduleIndex!=1 && strpos($row['Completed'],$previousModule)===false || $sectionIndex!=0 && strpos($row['Completed'],$sections[$previous])===false){// редирект на главную при вопросе по недоступному заданию
                $mysqli->close();
                header('Location: Welcome.php');
            }
            else{
                $login=$row['login'];
                $tasks=array();// массив заданий к секции
                $question=$mysqli->query('SELECT `Question` FROM `'.$fullModule.'` WHERE `Section`="'.$section.'"');
                while($row=$question->fetch_assoc())
                    in_array($row['Question'],$tasks)? null: $tasks[]=$row['Question'];// заполняем массив заданиями секции
                $count=count($tasks);
                for ($i=0; $i <$count; $i++)
                    $i==$qz? $task=$tasks[$i]: null;
            }
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Support</title>
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
<body class="greyBackground">
    <nav class="navbar navbar-inverse blueBackground">
        <div class="navbar-header">
            <a class="navbar-brand " href="quiz.php?module=<?=$module?>&&section=<?=$section?>&&qz=<?=$qz?>&&id=<?=$id?>"><i class="fas fa-long-arrow-alt-left white icon"></i></a>
        </div> 
        <div class="navbar-inner">
            <span class="navbar-brand white"><h3>Support</h3></span>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center form">
            <form  method="POST" action="" id="formSupport">
                <div class="form-group" id="formGroupSupport">
                    <input type="hidden" id="hhhSupport" value="<?=$login?>">
                    <label for="supportMessage" class="control-label white" >Write your question. For correct sending your message, please, don't use double quotes:</label>
                    <br>
                    <textarea class="text-left" name="supportMessage" id="supportMessage" cols="50" rows="15" placeholder="" required>  Hello, I have a question about task '<?=$task?>' in module '<?=$module?>' section '<?=$section?>'</textarea>
                    <br><button class="btn btn-primary" id="buttonSupport" onclick="support(event)">Send</button>
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
<?php $mysqli->close();?>