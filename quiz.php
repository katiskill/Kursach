<?php
    session_start();
    if (!isset($_GET['module']) || !isset($_GET['section']) || !isset($_GET['qz']) || !isset($_GET['id']) || !isset($_SESSION['token'.$_GET['id']]))
        header("Location: Welcome.php");
    else{
        $module=$_GET['module'];
        $section=$_GET['section'];
        $quiz=$_GET['qz'];
        $next=$quiz+1;
        $id=$_GET['id'];
        $mysqli=new mysqli('localhost','root','','learning');// открыть БД
        $mysqli->query("SET NAMES 'utf8'");// устанавливаем кодировку.
        if ($mysqli->connect_errno)// проверка на успешность открытия
        {
            printf("Соединение не удалось: %s\n", $mysqli->connect_error);
            exit();
        }
        else
        {
            function printCases($question){
                $count=0;
                foreach ($question as $key => $value){
                    if (strpos($key,'Case')!==false && $value!==''){
                        $num=substr($key,4,1);
                        $count++;
                        print('<div class="casesInQuiz">');
                            print('<label for="'.$key.'Var" ><b>'.$key.'</b></label>');
                            print('<div id="'.$key.'Var">');
                                print('<input type="checkbox" id="'.$key.'InQuiz" name="'.$key.'" value="'.$num.'">');
                                print('<label for="'.$key.'InQuiz" id="'.$key.'Variant" class="control-label">'.$value.'</label>');
                        print('</div></div><br>');
                    }
                } 
            }
            $obj=$mysqli->query("SHOW TABLES LIKE '%)".$module."'");
            $row=$obj->fetch_row();
            $moduleIndex=substr($row[0],0,1);// индекс модуля
            $params=json_encode(array($moduleIndex.')'.$module,$section,$quiz));
            $select=$mysqli->query('SELECT * FROM `'.$row[0].'` WHERE `Section`="'.$section.'" LIMIT '.$quiz.',1 ');
            $question=$select->fetch_assoc();
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?=$section;?></title>
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
    <nav class="navbar navbar-expand-lg blueBackground">
        <div class="navbar-header">
            <a data-toggle="tooltip" title="Back to the module" class="navbar-brand " href="module.php?module=<?=$module?>&&index=<?=$moduleIndex;?>&&id=<?=$id;?>"><i class="fas fa-long-arrow-alt-left white icon"></i></a>
        </div> 
        <div class="navbar-inner"><span class="navbar-brand white"><h3><?=$section;?></h3></span></div>
        <div>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a  href="support.php?module=<?=$module?>&&section=<?=$section?>&&qz=<?=$quiz?>&&id=<?=$id?>" data-toggle="tooltip" title="Need support?">
                    <i class="far fa-question-circle white icon"></i>
                    </a>&nbsp
                </li>
                <li class="nav-item">
                    <a  href="account.php?id=<?=$id?>" data-toggle="tooltip" title="My account">
                    <i class='far fa-address-card white icon'></i>
                    </a>
                </li>
                <li class="nav-item"><button class="btn btn-sm blueBackground white" type="submit" id="exit" value="'.$id.'" onclick="Exit()" data-toggle="tooltip" title="Exit from account"><h5>Exit</h5></button></li>
            </ul>
        </div>
    </nav>
    <br>
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col"></div>
            <div class="col-6" id="theoryInQuiz">
                <b><h2>Theory:</h2></b>
                <?=$question['Theory']?>
            </div>
            <div class="col"></div>
        </div>
        <br>
        <div class="row justify-content-center align-items-center">
            <div class="col"></div>
            <div class="col-4 text-center" id="questionInQuiz">
                <p><b><?=$question['Question'];?></b></p>
                <hr>
                <?php printCases($question);?>
                <input type='hidden' id='hidden' value='<?=$params?>'>
                <input type='hidden' id='idInQuiz' value='<?=$id?>'>
                <button type="submit" class="btn btn-success" style="width:100px;" onclick="Answer()">check</button>
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