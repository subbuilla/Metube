<?php 
require_once("commonFiles/config.php"); 
require_once("files/Classes/Sanitizer.php");
require_once("files/Classes/UserAccount.php");
require_once("files/Classes/Properties.php");

$userAccount =new UserAccount($con);
if(isset($_POST["signupButton"]))
{

    $firstName = Sanitizer::stringSanitizer($_POST["firstname"]);
    $lastName = Sanitizer::stringSanitizer($_POST["lastname"]);
    $email=Sanitizer::emailSanitizer($_POST["email"]);
    $userName=Sanitizer::userNameSanitizer($_POST["username"]);

    $password=$_POST["password"];
    $confirmPassword=$_POST["confirmpassword"];

    $resultKey=$userAccount->register($firstName,$lastName,$email,$password,$confirmPassword,$userName);

    if($resultKey)
    {
        //SUCCESS
        //REDIRECT to Index page
        echo "Success";
        header("location:index.php");
    }
    else{
        echo "failure";
    }

    echo $firstName;
    echo $lastName;
    echo $email;
    echo $password;
    echo $confirmPassword;
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
<div class="jumbotron" style="margin-left:20%;margin-right:20%;">
<div class="header text-center"><a class="navbar-brand signup display-3" href="index.php"><i class="fab fa-youtube fa-lg" style="color:red;"></i> Metube</a>
<h3 class="display-4">Sign Up</h3>
    <p>to continue to Metube</p>
</div>
    <div class="signupForm">
    
    <form action="signup.php" method="POST">
    <div class="form-group">
    <label for="firstname">First Name:</label>    
    <input type="text" name="firstname" class="form-control" id="firstname" value="<?php enteredValues('firstname') ?>" required placeholder="Jon">
    <?php echo $userAccount->displayError(Properties::$firstNameError); ?>
    </div>
    <div class="form-group">
    <label for="lastname">Last Name:</label>    
    <input type="text" name="lastname"class="form-control" id="lastname" value="<?php enteredValues('lastname') ?>" required placeholder="Snow">
    <?php echo $userAccount->displayError(Properties::$lastNameError); ?>
    </div>

    <div class="form-group">
    <label for="username">Username:</label>    
    <input type="text" name="username"class="form-control" id="username" value="<?php enteredValues('username') ?>" required placeholder="Jon99">
    <?php echo $userAccount->displayError(Properties::$userNameUniqueError); ?>
    </div>

    <div class="form-group">
    <label for="email">E-mail:</label>    
    <input type="email" name="email" class="form-control" id="email" value="<?php enteredValues('email') ?>" required placeholder="name@example.com">
    <?php  echo $userAccount->displayError(Properties::$emailInvalidError); ?>
    <?php echo $userAccount->displayError(Properties::$emailUniqueError); ?>
    </div>
    <div class="form-group">
    <label for="password">Password:</label>    
    <input type="password" name="password" class="form-control" id="password" value="<?php enteredValues('password') ?>" required placeholder="minimum 6 characters">
   
    </div>
    <div class="form-group">
    <label for="confirmpassword">Confirm Password:</label>    
    <input type="password" name="confirmpassword" class="form-control" id="confirmpassword" value="<?php enteredValues('confirmpassword') ?>" required placeholder="minimum 6 characters">
    <?php echo $userAccount->displayError(Properties::$passwordMatchError); ?>
    <?php echo $userAccount->displayError(Properties::$passwordLengthError); ?>

    </div>
    <div class="text-center" style="margin-top:20px">
        <button type="submit" class="btn btn-md btn-primary" name="signupButton">Sign Up <i class="fas fa-user-plus"></i></button>
        

    </div>
    <div class="text-center" style="margin-top:20px">
    <a href="login.php" class="text-dark" >Already have an account? Login here!</a>
    </div>
    </form>
    </div>

</div>
</div>
    



</body>
</html>