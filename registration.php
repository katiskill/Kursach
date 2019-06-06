<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Registration</title>
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
            <span class="navbar-brand white"><h3 class="headers">Registration</h3></span>
        </div>
    </nav>
    <div class="container">
        <div class="row justify-content-center align-items-center form">
            <form method="POST" action="" id="registForm">
                <div class="form-group">
                    <label  for="login">
                        <span class="white" id="loginLabel">Login:</span>
                    </label>
                    <input type="text" class="form-control" id="Rlogin" name="login" placeholder="Enter your login..." required>
                </div>
                <div class="form-group">
                    <label  for="password">
                        <span class="white" id="passwordLabel">Password:</span>
                    </label>
                    <input type="password" class="form-control" id="Rpassword" name="password" placeholder="Enter your password..." required>
                </div>
                <div class="form-group">
                    <label  for="password">
                        <span class="white" id="passwordLabel">Repeat password:</span>
                    </label>
                    <input type="password" class="form-control" id="repPassword" name="repPassword" placeholder="Repeat your password..." required>
                    <br>
                    <button type="submit" class="btn btn-success" id="checkRegistration" name="checkRegistration" onclick="Registration(event)">Registration</button>
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