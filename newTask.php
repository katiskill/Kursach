<?php
    $id=$_GET['id'];
    session_start();
    if (!isset($_SESSION['admin'.$id]) || $_SESSION['admin'.$id]!==$id){
        header("Location: Welcome.php");
    }
    else{
        $mysqli=new mysqli('localhost','root','','learning' );
        $obj=$mysqli->query("SHOW TABLES FROM `learning`");
        $arrayCount = 0;
        while ($row =$obj->fetch_row())
        {
            $row[0]=='users' || $row[0]=='popular_passwords' ? null: $tableNames[$arrayCount] = substr($row[0],2);
            $arrayCount++; //only do this to make sure it starts at index 0
        }
        $count=count($tableNames);
        function options($count,$tableNames){
            for ($i=0; $i < $count; $i++)
            { 
                print('<option class="add">'.$tableNames[$i].'</option>');
            }
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>New task</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <noscript>Please, activate JavaScript in your browser</noscript>

    <link rel='stylesheet'
          href='https://use.fontawesome.com/releases/v5.5.0/css/all.css' 
          integrity='sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU' 
          crossorigin='anonymous'> 
          
    <link href="main.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" 
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" 
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" 
          crossorigin="anonymous">
          
</head>
<body class="blueBackground">
    <nav class="navbar navbar-inverse">
        <div class="navbar-header">
            <a class="navbar-brand " href="Welcome.php?id=<?=$id?>"><i class="fas fa-home white icon"></i></a>
        </div>
        <div class="navbar-inner">
            <span class="navbar-brand white"><h3 class="headers">New task</h3></span>
        </div>
    </nav>
    <div class="row justify-content-center align-items-center" style="height: 40vh;">
        <form  method="POST" action="" id="formTask">
            <div class="form-group " id="wrapped" style="height: 25vh;">
                <p class="help-block white">Choose the module:</p>
                <select id="select" class="form-control" size="1"  required>
                    <option selected disabled>module</option>
                    <?php options($count,$tableNames); ?>
                </select>
                <br>

                <label id="before" for="section" class="control-label white" >Section:</label>
                <input type="text" class="form-control" id="section" name="section" placeholder="enter the section..." required>
                <br>

                <textarea name="theory" id="theory" cols="30" rows="7" placeholder="write the theoretical information..." required></textarea>
                <br>

                <label for="task" class="control-label white" >Task:</label>
                <br>

                <textarea name="task" id="task" cols="30" rows="7" placeholder="write the task..." required ></textarea>
                <br><br>

                <span class="help-block white" id="help" style="padding-left: 5vh" >Mark the right answers</span>
                <br>
                
                <label for="case1Div" class="white">Case1</label>
                <div id="case1Div">
                    <input type="checkbox" id="case1" name="case1" value="1">
                    <label for="case1" class="control-label white"><input type="text" id="case1Input"></label>
                </div>
                <br>

                <label for="case2Div" class="white">Case2</label>
                <div id="case2Div">
                    <input type="checkbox" id="case2" name="case2" value="2" >
                    <label for="case2" class="control-label white"><input type="text"  id="case2Input"></label>
                </div>
                <br>

                <label for="case3Div" class="white">Case3</label>
                <div id="case3Div">
                    <input type="checkbox" id="case3" name="case3" value="3">
                    <label for="case3" class="control-label white"><input type="text"  id="case3Input"></label>
                </div>
                <br>

                <label for="case4Div" class="white">Case4</label>
                <div id="case4Div">
                    <input type="checkbox" id="case4" name="case4" value="4">
                    <label for="case4" class="control-label white"><input type="text"  id="case4Input"></label>
                </div>
                <br>

                <button type="submit" class="btn btn-success" name="btnAddTask" id="btnAddTask" onclick="addTask()">Add task</button>
            </div>
        </form>-
    </div>
</body>
</html>
<script 
    src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" 
    integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" 
    crossorigin="anonymous">
</script>
<script src="learning.js"></script>