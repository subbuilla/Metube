<?php require_once("commonFiles/header.php"); 
      require_once("commonFiles/config.php"); 
      require_once("files/Classes/Sanitizer.php");
      require_once("files/Classes/UserAccount.php");
      require_once("files/Classes/Properties.php");

      $emailResult = false;
      $userAccount = new UserAccount($con);

      if(isset($_POST["UpdateFirstName"]))
      {
          
          $sanitizedFirstName=Sanitizer::stringSanitizer($_POST["firstname"]);
          $result=$userAccount->updateFirstName($sanitizedFirstName,$loggedInUserName);
          

      }

      if(isset($_POST["UpdateLastName"]))
      {
        $sanitizedLastName=Sanitizer::stringSanitizer($_POST["lastname"]);
          $result=$userAccount->updateLastName($sanitizedLastName,$loggedInUserName);
        
      }
      if(isset($_POST["UpdateEmail"]))
      {
        $sanitizedEmail=Sanitizer::emailSanitizer($_POST["email"]);
        $emailResult=$userAccount->updateEmail($sanitizedEmail,$loggedInUserName);
        
        
      }
      if(isset($_POST["UpdatePassword"]))
      {
        $currentPassword=$_POST["currentpassword"];
        $newPassword=$_POST["newpassword"];
        $confirmNewPassword=$_POST["confirmnewpassword"];


        $result=$userAccount->updatePassword($currentPassword,$newPassword,$confirmNewPassword,$loggedInUserName);
        
      }
     // <?php echo $userAccount->displayError(Properties::$firstNameError); 

?>


<div class="container" style="padding-top:66px;">
<div class="jumbotron" style="margin-left:20%;margin-right:20%;">
<div class="header text-center"><a class="navbar-brand signup display-3" href="index.php"><i class="fab fa-youtube fa-lg" style="color:red;"></i> Metube</a>
<h3 class="display-4">Update Your Profile</h3>  
</div>
    

    <form action="updateProfile.php" method="POST">
    <div class="text-center" style="margin-top:20px">
        <button type="submit" class="btn btn-block btn-primary" name="fnUpdateButton">Update Your First Name</button>
    </div>
    </form>
    <?php
            if(isset($_POST["fnUpdateButton"]))
            {
                echo "<form action='updateProfile.php' method='POST'>
                
                <div class='form-group mt-3'>
                <label for='firstname'>New First Name:</label>    
                <input type='text' name='firstname' class='form-control' id='firstname'  required placeholder='Jon'>
                </div>
                <div class='text-right'>
                <button type='submit' class='btn btn-outline-primary' name='UpdateFirstName'>Update</button>
                </div>
                </form>";
            }
    ?>

    <form action="updateProfile.php" method="POST">
    <div class="text-center" style="margin-top:20px">
        <button type="submit" class="btn btn-block btn-primary" name="lnUpdateButton">Update Your Last Name</button>
    </div>
    </form>

    <?php
            if(isset($_POST["lnUpdateButton"]))
            {
                echo "<form action='updateProfile.php' method='POST'>
                
                <div class='form-group mt-3'>
                <label for='lastname'>New Last Name:</label>    
                <input type='text' name='lastname' class='form-control' id='lastname'  required placeholder='Snow'>
                </div>
                <div class='text-right'>
                <button type='submit' class='btn btn-outline-primary' name='UpdateLastName'>Update</button>
                </div>
                </form>";
            }
    ?>

    <form action="updateProfile.php" method="POST">
    <div class="text-center" style="margin-top:20px">
        <button type="submit" class="btn btn-block btn-primary" name="emailUpdateButton">Update Your Email</button>
    </div>
    </form>

    <?php
        if(isset($_POST["emailUpdateButton"]))
        {
            echo "<form action='updateProfile.php' method='POST'>
            
            <div class='form-group mt-3'>
            <label for='email'>New Email Id:</label>    
            <input type='email' name='email' class='form-control' id='email'  required placeholder='name@example.com'>
            </div>
            <div class='text-right'>
            <button type='submit' class='btn btn-outline-primary' name='UpdateEmail'>Update</button>
            </div>
            </form>";
        }
    ?>


    <form action="updateProfile.php" method="POST">
    <div class="text-center" style="margin-top:20px">
        <button type="submit" class="btn btn-block btn-primary" name="passwordUpdateButton">Update Your Password</button>
    </div>
    </form>

    <?php
            if(isset($_POST["passwordUpdateButton"]))
            {
                echo "<form action='updateProfile.php' method='POST'>
                
                <div class='form-group mt-3'>
                <label for='currentpassword'>Current Password:</label>    
                <input type='password' name='currentpassword' class='form-control' id='currentpassword'  required placeholder='********'>
                </div>
                <div class='form-group mt-3'>
                <label for='newpassword'>New Password:</label>    
                <input type='password' name='newpassword' class='form-control' id='newpassword'  required placeholder='minimum 6 characters'>
                </div>
                <div class='form-group mt-3'>
                <label for='confirmnewpassword'>Confirm New Password:</label>    
                <input type='password' name='confirmnewpassword' class='form-control' id='confirmnewpassword'  required placeholder='minimum 6 characters'>
                </div>
                <div class='text-right'>
                <button type='submit' class='btn btn-outline-primary' name='UpdatePassword'>Update</button>
                </div>
                </form>";
            }
    ?>
    <?php echo $userAccount->displayError(Properties::$firstNameError); ?>
    <?php echo $userAccount->displayError(Properties::$lastNameError); ?>
    <?php  echo $userAccount->displayError(Properties::$emailInvalidError); ?>
    <?php echo $userAccount->displayError(Properties::$emailUniqueError); ?>
    <?php echo $userAccount->displayError(Properties::$passwordMatchError); ?>
    <?php echo $userAccount->displayError(Properties::$passwordLengthError); ?>
    <?php echo $userAccount->displayError(Properties::$passwordMismatchError); ?>


    <?php echo $userAccount->displaySuccess(Properties::$SuccessfulUpdateFN); ?>
    <?php echo $userAccount->displaySuccess(Properties::$SuccessfulUpdateLN); ?>
    <?php echo $userAccount->displaySuccess(Properties::$SuccessfulUpdateEmail);
        // if($emailResult)
        // {
        //     sleep('5');
        //     session_destroy();
        //     header('Location:index.php');
        // }    
    ?>
    <?php echo $userAccount->displaySuccess(Properties::$SuccessfulUpdatePassword); ?>




</div>
</div>

<?php require_once("commonFiles/footer.php")?>
