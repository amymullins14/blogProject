<?php 
session_start();
include('config.php');
//defining database connection parameters
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'projectUser';
$DATABASE_PASS = '5Iix/r1PyO7sixqf';
$DATABASE_NAME = 'blogProject';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if(isset($_POST['login'])){
    $uname = $_POST['uname'];
    $pword = $_POST['pword'];

    $stmt = $con->prepare('SELECT userId, username, pword FROM accounts WHERE Username = ?');
        $stmt->bind_param('s', $uname);
        $stmt->execute();
        $stmt->store_result();
        echo("Hello");
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($uid, $uname, $hashpword);
            $stmt->fetch();
            echo("World");
            if (password_verify($pword, $hashpword)){
                // Create sessions variables, so we know the user is logged in, they act like cookies 
            $_SESSION['validUser'] = TRUE;
            $_SESSION['uid'] = $uid;
            

            } else{
                $_SESSION['error'] = "Incorrect Username/Password";
                echo("error");
            }
    } else{
        $_SESSION['error'] = "Incorrect Username/Password";
    }
}
   
    
    ?>
<html>
<head>
<style>
body {font-family: Arial;}

/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
  float: left;
    background-color: #edf2f3;
    width: 20%;
    height: 85%;
}

/* Style the buttons inside the tab */
.tab button {
    display: block;
    background-color: inherit;
    color: #122729;
    padding: 22px 16px;
    width: 100%;
    border: none;
    outline: none;
    text-align: center;
    cursor: pointer;
    transition: 0.3s;
    font-size: 17px;
    font-family: 'IBM Plex Mono', monospace;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
</style>
</head>
<body>

<h2>Welcome To My Blog!</h2>
<?php 
if(!isset($_SESSION['validUser'])){
?>
<div class="login">
<button class="tablinks" onclick="openCity(event, 'Login')">Login</button>
</div>
<?php
}else{

?>
<a href="logout.php" >Logout</a>

<?php
}
?>
<div id="Login" class="tabcontent">
    <form method = "post">
    <label for="username">Username:</label><br>
        <input type="text" name="uname" required><br>
        <label for="password">Password:</label><br>
        <input type="password" name="pword" required><br>
        <input class="submit" type="submit" value="Login" name='login'>
</form>
</div>
<p>Click on the buttons in the menu to view and comment.</p>
<?php
                //display the error message to the user if the error session variable is set.
                    if(isset($_SESSION['error'])){
                        $error = $_SESSION["error"];
                        echo($error);
                    }

                ?>  
<div class="tab">
  <button class="tablinks" onclick="openCity(event, 'Post1')">Post 1</button>
  <button class="tablinks" onclick="openCity(event, 'Post2')">Post 2</button>
  <button class="tablinks" onclick="openCity(event, 'Post3')">Post 3</button>
  <button class="tablinks" onclick="openCity(event, 'Post4')">Post 4</button>
</div>

<div id="Post1" class="tabcontent">
  <h3>Post 1</h3>
  <p>London is the capital city of England.</p>
</div>

<div id="Post2" class="tabcontent">
  <h3>Post 2</h3>
  <p>Paris is the capital of France.</p> 
</div>

<div id="Post3" class="tabcontent">
  <h3>Post 3</h3>
  <p>Tokyo is the capital of Japan.</p>
</div>
<div id="Post4" class="tabcontent">
  <h3>Post 4</h3>
  <p></p>
</div>

<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>
   
</body>
</html> 
<?php

unset($_SESSION["error"]);
?>


