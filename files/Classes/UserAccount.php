<?php
class UserAccount
{
    private $con;
    private $errorMessages = array();
    private $successMessages =array();

    public function __construct($con)
    {
        $this->con=$con;
    }

    public function register($firstName,$lastName,$email,$password,$confirmPassword,$userName)
    {
        try{
        $this->validateFirstName($firstName);
        $this->validateLastName($lastName);
        $this->validateEmail($email);
        $this->validatePassword($password,$confirmPassword);
        $this->validateUserName($userName);



        if(empty($this->errorMessages))
        {
            $password = hash("sha512",$password);
            $query = $this->con->prepare("INSERT INTO user_accounts(firstName,lastName,email,password,userName) VALUES(:fn,:ln,:em,:pd,:un)");
            $query->bindParam(":fn",$firstName);
            $query->bindParam(":ln",$lastName);
            $query->bindParam(":un",$userName);
            $query->bindParam(":em",$email);
            $query->bindParam(":pd",$password);
            return $query->execute();
        }
        else{
            return false;
        }
    }
    catch(Exception $e)
    {
        echo"Some Error Occured: ".$e->getMessage();
    }
    }

    public function login($userName,$password)
    {
        try
        {
        $password=hash("sha512",$password);
        $query = $this->con->prepare("SELECT * from user_accounts where userName=:un and password=:pw");
        $query->bindParam(":un",$userName);
        $query->bindParam(":pw",$password);
        $query->execute();

        if($query->rowCount() ==1)
        {
            return true;
        }
        else
        {
            array_push($this->errorMessages,Properties::$loginFailed);
            return false;
        }
        }
        catch(Exception $e)
    {
        echo"Some Error Occured: ".$e->getMessage();
    }
        
    }


    

    private function validateFirstName($firstName)
    {
        //Making Sure firstName has only Alphabets or spaces
        
        $fnNospaces = str_replace(" ","",$firstName);
        if(!ctype_alpha($fnNospaces))
        {
            array_push($this->errorMessages,Properties::$firstNameError);
        }
        
        
    }
    private function validateLastName($lastName)
    {
        //Making Sure lastName has only Alphabets or spaces
        
        $lnNospaces = str_replace(" ","",$lastName);
        if(!ctype_alpha($lnNospaces))
        {
            array_push($this->errorMessages,Properties::$lastNameError);
        }
    }
    private function validateEmail($email)
    {

        if(!filter_var($email,FILTER_VALIDATE_EMAIL))
        {
            array_push($this->errorMessages,Properties::$emailInvalidError);
            return;
        }
        $query = $this->con->prepare("SELECT email from user_accounts where email=:em");
        $query->bindParam(":em",$email);
        $query->execute();
        if($query->rowCount()!= 0)
        {
            array_push($this->errorMessages,Properties::$emailUniqueError);
        }
    }




    private function validateUserName($userName)
    {

        
        $query = $this->con->prepare("SELECT userName from user_accounts where userName=:un");
        $query->bindParam(":un",$userName);
        $query->execute();
        if($query->rowCount()!= 0)
        {
            array_push($this->errorMessages,Properties::$userNameUniqueError);
        }
    }








    private function validatePassword($password,$confirmPassword)
    {
        if($password != $confirmPassword)
        {
            array_push($this->errorMessages,Properties::$passwordMatchError);
            return;
        }
        if(strlen($password)<6)
        {
            array_push($this->errorMessages,Properties::$passwordLengthError);
        }   
    }

//Update Functions

public function updateFirstName($firstName,$userName)
    {
        try
        {
            $this->validateFirstName($firstName);

            if(empty($this->errorMessages))
            {
            $query = $this->con->prepare("UPDATE user_accounts SET firstName =:fn where userName=:un");
            $query->bindParam(":fn",$firstName);
            $query->bindParam(":un",$userName);
            $result= $query->execute();
            if($result)
            {
                array_push($this->successMessages,Properties::$SuccessfulUpdateFN);
                return $result;
            }
            else{
                return false;
            }
            }
            else{
                return false;
            }
        }
        catch(Exception $e)
    {
        echo"Some Error Occured: ".$e->getMessage();
    }
    }
   

    public function updateLastName($lastName,$userName)
    {
        try{
            $this->validateLastName($lastName);
            if(empty($this->errorMessages))
            {
            $query = $this->con->prepare("UPDATE user_accounts SET lastName =:ln where userName=:un");
            $query->bindParam(":ln",$lastName);
            $query->bindParam(":un",$userName);
            $result= $query->execute();
            if($result)
            {
                array_push($this->successMessages,Properties::$SuccessfulUpdateLN);
                return $result;
            }
            else{
                return false;
            }
            }
            else{
                return false;
            }
        }
        catch(Exception $e)
        {
        echo"Some Error Occured: ".$e->getMessage();
        }
        
    }

    public function updateEmail($newEmail,$userName)
    { 
        try{
        $this->validateEmail($newEmail);
        if(empty($this->errorMessages))
            {
            $query = $this->con->prepare("UPDATE user_accounts SET email =:em where userName=:un");
            $query->bindParam(":un",$userName);
            $query->bindParam(":em",$newEmail);
            $result= $query->execute();
            if($result)
            {
                array_push($this->successMessages,Properties::$SuccessfulUpdateEmail);
                return $result;
            }
            else{
                return false;
            }
            
            }
            else{
                return false;
            }
        }
        catch(Exception $e)
        {
        echo"Some Error Occured: ".$e->getMessage();
        }
    }

    public function updatePassword($currentPassword,$newPassword,$confirmNewPassword,$userName)
    {
        try
        {
            $hashedCurrentPassword = hash("sha512",$currentPassword);
            $query = $this->con->prepare("SELECT password from user_accounts where userName=:un");
            $query->bindParam(":un",$userName);
            $query->execute();
            $passwordData = $query->fetch(PDO::FETCH_ASSOC);
            $originalPassword=$passwordData["password"];
            if($hashedCurrentPassword!=$originalPassword)
            {
                array_push($this->errorMessages,Properties::$passwordMismatchError);
                return false;
            }
            else
            {
            $this->validatePassword($newPassword,$confirmNewPassword);
            }

            if(empty($this->errorMessages))
            {
                $hashedNewPassword =hash("sha512",$newPassword); 
                $query1 = $this->con->prepare("UPDATE user_accounts SET password =:pd where userName=:un");
            $query1->bindParam(":pd",$hashedNewPassword);
            $query1->bindParam(":un",$userName);
            $result= $query1->execute();   

            if($result)
            {
                array_push($this->successMessages,Properties::$SuccessfulUpdatePassword);
                return $result;
            }
            else{
                return false;
            }



            }
            else{
                return false;
            }
            
        }
        catch(Exception $e)
        {
        echo"Some Error Occured: ".$e->getMessage();
        }
    }




//Display


    public function displayError($error)
    {
        if(in_array($error,$this->errorMessages))
        {
            return "<span class='error text-center text-danger'>$error</span>";
        }
    }

    public function displaySuccess($success)
    {
        if(in_array($success,$this->successMessages))
        {
            return "<span class='text-center text-success'>$success</span>";
        }
    }


    public function emptySuccessMessages()
    {
        $this->successMessages =array();
    }


}
?>