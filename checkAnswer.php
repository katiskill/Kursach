<?php
    if (!isset($_POST['param1']) || !isset($_POST['param2'])){
        header('Location: Welcome.php');
    }
    else{
        $cases=json_decode($_POST['param1']);// массив введённых отвеов
        $countCases=count($cases);// длина массива введённых отвеов
        $DBdata=json_decode($_POST['param2']);// массив параметров, содержащий название модуля, секции и номер вопроса
            $module=$DBdata[0];// название модуля
            $section=$DBdata[1];// название секции
            $questionNumber=$DBdata[2];// номер текущего вопроса
        $countAnswers=count($DBdata);// длина массива параметров
        $casesStr='';
        for ($i=0; $i <$countCases; $i++)
        { 
            $casesStr.=$cases[$i].';';
        }
        $mysqli=new mysqli('localhost','root','','learning');// открыть БД
        $mysqli->query("SET NAMES 'utf8'");// устанавливаем кодировку.
        if ($mysqli->connect_errno)// проверка на успешность открытия
        {
            printf("Соединение не удалось: %s\n", $mysqli->connect_error);
            exit();
        }
        else
        {
            $select=$mysqli->query('SELECT* FROM `'.$module.'` WHERE `Section`="'.$section.'" LIMIT '.$questionNumber.',1');
            $row=$select->fetch_assoc();
            $select=$mysqli->query('SELECT `Question` FROM `'.$module.'` WHERE `Section`="'.$section.'" ');
            while($questions=$select->fetch_assoc()){
                $last=$questions['Question'];
            }
            if ($casesStr===$row['Answers'] && $row['Question']===$last){
               echo 1;// возвращаем 1 в случае, если пользователь верно ответил на последний вопрос в секции, т.е. секция завершилась.
            }
            elseif ($casesStr===$row['Answers']) {
                echo 2;// возвращаем 2 в случае, если пользователь верно ответил на вопрос 
            }
            else
                echo 0;// 0, если пользователь ответил неверно.
        }
        $mysqli->close(); 
    }
?>