<?php require_once("commonFiles/config.php"); 
      require_once("files/Classes/UserBean.php");
      require_once("files/Classes/Video.php");
      require_once("files/Classes/VideoGrid.php"); 
      require_once("files/Classes/VideoGridItem.php");  

$loggedInUserName="";
if(isset($_SESSION["loggedinUser"]))
{
  $loggedInUserName=$_SESSION["loggedinUser"];

}
$loggedInUser = new UserBean($con,$loggedInUserName);




?>
<!DOCTYPE html>
<html>
<head>
<title>MeTube</title>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="files/css/style.css">


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
<script src="files/js/jsfile.js"></script>

<script type='text/javascript'>











var tags = [  
    "guitar", 
    "soccer", 
    "graffiti", 
    "ping-pong", 
    "Gopro", 
    "cards", 
    "dog", 
    "fish", 
    "rare", 
    "hockey", 
    "surfing", 
    "short music video" 
      ]; 
  
      /*list of available options*/ 
     var n= tags.length; //length of datalist tags     
  
     function ac(value) { 
        document.getElementById('datalist').innerHTML = ''; 
         //setting datalist empty at the start of function 
         //if we skip this step, same name will be repeated 
           
         l=value.length; 
         //input query length 
     for (var i = 0; i<n; i++) { 
         if(((tags[i].toLowerCase()).indexOf(value.toLowerCase()))>-1) 
         { 
             //comparing if input string is existing in tags[i] string 
  
             var node = document.createElement("option"); 
             var val = document.createTextNode(tags[i]); 
              node.appendChild(val); 
  
               document.getElementById("datalist").appendChild(node); 
                   //creating and appending new elements in data list 
             } 
         } 
     } 














function myFunction(val) {
  var objDiv = document.getElementById(val);
objDiv.scrollTop = objDiv.scrollHeight;
  }



  function myFunction1() {
     document.getElementById("comment").focus();
}












function videoByCategory(str) {
  if (str=="") {
    document.getElementById("cate").innerHTML="";
    return;
  }
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("cate").innerHTML=this.responseText;
    }
  }
  xmlhttp.open("GET","vidbyCate.php?q="+str,true);
  xmlhttp.send();
}









</script>


</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
<button class="btn hamburgermenu" >
<span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="index.php"><i class="fab fa-youtube fa-lg" style="color:red;"></i> Metube</a>
  <button class="navbar-toggler btn " type="button" data-toggle="collapse" data-target="#navbar-collapse-content" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        Menu <i class="fas fa-caret-square-down" ></i>
  </button>

  <div class="collapse navbar-collapse" id="navbar-collapse-content">
    
    <form class="form-inline my-2 my-lg-0 mr-auto search-bar" action="search.php" method="GET">
      <input class="form-control mr-sm-2 search" list="datalist" onkeyup="ac(this.value)" type="search" placeholder="Search" aria-label="Search" name="term">
      <datalist id="datalist"> 
  
<option value="guitar"></option> 
<option value="soccer"></option> 
<option value="graffiti"></option> 
<option value="ping-pong"></option> 
<option value="Gopro"></option> 
<option value="cards"></option> 
<option value="dog"></option> 
<option value="fish"></option> 
<option value="rare"></option> 
<option value="hockey"></option> 
<option value="surfing"></option> 
<option value="short music video"></option> 
  
<!-- This data list will be edited through javascript     -->
</datalist>
      <button class="btn btn-dark my-2 my-sm-0" type="submit">Search <i class="fab fa-searchengin"></i></button>
    </form>
<?php
 if($loggedInUserName=="")
 {
    echo "<ul class='navbar-nav'>
      <li class='nav-item'>
        <a class='nav-link' href='signup.php'>Sign up <i class='fas fa-user-plus'></i> </a>
      </li>
      <li class='nav-item'>
        <a class='nav-link' href='login.php'>Log In <i class='fas fa-user'></i></a>
      </li>
    </ul>";
   }

    else
   
    {
    echo "<ul class='navbar-nav'>
    <li class='nav-item'>
     <a class='text-danger nav-link' href='#'>Welcome ".$loggedInUser->getFirstName()." </a>
     </li>
     <li class='nav-item'>
         <a class='nav-link' href='upload.php'>Upload <i class='fas fa-upload'></i></a>
     </li>
   
     <li class='nav-item'>
     <a class='nav-link' href='logout.php'>Log Out <i class='fas fa-sign-out-alt'></i></a>
     </li>
     </ul>";
    } 
 ?>   
  </div>
</nav>


<div id="side-nav" style="display:none;">
<div class="sidebar-menu">
<ul style="list-style-type:none;">
      <li class='nav-item'>
        <a class='nav-link text-danger' href='index.php'>Home</a>
      </li>
      <li class='nav-item'>
      
    <a class='nav-link text-danger' href='CategorySearch.php'>Search by Category</a>
  </li>
      <?php
      if($loggedInUserName!="")
      {
      echo"<li class='nav-item'>
        <a class='nav-link text-danger' href='updateProfile.php'>Update Profile</a>
      </li>
      <li class='nav-item'>
      <a class='nav-link text-danger' href='contacts.php'>Contacts</a>
    </li> 
    
    <li class='nav-item'>
      <a class='nav-link text-danger' href='messages.php'>Mailbox</a>
    </li>
    
    <li class='nav-item'>
    <a class='nav-link text-danger' href='channels.php'>Your Channel</a>
  </li>
  
  
  <li class='nav-item'>
    <a class='nav-link text-danger' href='playlist.php?id='>Your Playlist</a>
  </li>

  <li class='nav-item'>
    <a class='nav-link text-danger' href='favoritelist.php?id='>Favorite List</a>
  </li>
  
  
  
  ";
      }
      ?>
  </ul>
</div>

</div> 

<div id="main-section">
    <div id="content" class="container-fluid">