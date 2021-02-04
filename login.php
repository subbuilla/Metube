<?php require_once("commonFiles/config.php");




require_once("files/Classes/Sanitizer.php");
require_once("files/Classes/UserAccount.php");
require_once("files/Classes/Properties.php");

$userAccount =new UserAccount($con);
if(isset($_POST["loginButton"]))
{

    $userName=Sanitizer::userNameSanitizer($_POST["username"]);
    $password=$_POST["password"];

    $resultKey=$userAccount->login($userName,$password);

    if($resultKey)
    {
        //SUCCESS
        //REDIRECT to Index page
        echo "Success";
        $_SESSION["loggedinUser"]=$userName;
        header("location:index.php");
    }
    else{
        echo "failure";
    }
}



function enteredValues($value)
    {
    if(isset($_POST[$value]))
    {
        echo $_POST[$value];
    }
    }
?>
<!DOCTYPE html>
<html>
<head>
<title>MeTube</title>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="files/css/style.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>



</head>
<body >

<div class="container" style="padding-top:66px;">
<div class="jumbotron" style="margin-left:25%;margin-right:25%;margin-top:15%">
<div class="header text-center"><a class="navbar-brand signup display-3" href="index.php"><i class="fab fa-youtube fa-lg" style="color:red;"></i> Metube</a>
<h3 class="display-4">Login</h3>
    <p>to continue to Metube</p>
</div>
    <div class="loginForm">
    
    <form action="login.php" method="POST">
  
    <div class="form-group">
    <label for="username">Username:</label>    
    <input type="text" name="username" class="form-control" id="username" value="<?php enteredValues('username') ?>" required placeholder="Jon99">
    </div>
    
    <div class="form-group">
    <label for="password">Password:</label>    
    <input type="password" name="password" class="form-control" id="password" required placeholder="********">
    <?php echo $userAccount->displayError(Properties::$loginFailed); ?>
    </div>
    
    <div class="text-center" style="margin-top:20px">
        <button type="submit" class="btn btn-md btn-primary" name="loginButton">Login <i class="fas fa-user"></i></button>
    </div>
    <div class="text-center" style="margin-top:20px">
    <a href="signup.php" class="text-dark" >Don't have an account yet? Sign Up here!</a>
    </div>
    </form>
    </div>

</div>
</div>
    



</body>
</html>