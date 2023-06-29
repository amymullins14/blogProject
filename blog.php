<?php 

//start a new session or resume existing session when page is loaded
session_start();
include('config.php');

//defining database connection parameters
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'projectUser'; //user with reduced privileges
$DATABASE_PASS = '5Iix/r1PyO7sixqf';
$DATABASE_NAME = 'blogProject';

//open a connection to the SQL database
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

//if the login button is pressed, check the username and password entered is valid.
if(isset($_POST['login'])){

    //store the username and password entered 
    $uname = $_POST['uname'];
    $pword = $_POST['pword'];

    //prepare statement to prevent SQL injection
    $stmt = $con->prepare('SELECT userId, username, pword FROM accounts WHERE Username = ?');
        $stmt->bind_param('s', $uname);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($uid, $uname, $hashpword);
            $stmt->fetch();
            //checks the hashed password in the database matches the plain text password entered by the user.
            if (password_verify($pword, $hashpword)){

                // Create sessions variables, so we know the user is logged in, they act like cookies 
            $_SESSION['validUser'] = TRUE;
            $_SESSION['uid'] = $uid;
            $_SESSION['uname'] = $uname;
        
            } else{
                //the password is invalid so set an error session variable
                $_SESSION['error'] = "1";
            }
    } else{
        //the username is invalid so set an error session variable.
        $_SESSION['error'] = "1";
    }
}

//storing comments in the comments table when the submit button is pressed.
if(isset($_POST['submitCom1'])){
    $commentCont = $_POST['commentCont1'];
    //parameterised query to stop sql injection
    $stmt = $con->prepare('INSERT INTO comments(userid, commentText, blogNum) VALUES (?, ?, 1)');
        $stmt->bind_param('ss', $_SESSION['uid'], $commentCont);
        $stmt->execute();
        $_SESSION['blogID'] = 1;
        unset($_POST['submitCom1']);
        header("Refresh:0");
        
        
}
if(isset($_POST['submitCom2'])){
    $commentCont = $_POST['commentCont2'];
    $stmt = $con->prepare('INSERT INTO comments(userid, commentText, blogNum) VALUES (?, ?, 2)');
        $stmt->bind_param('ss', $_SESSION['uid'], $commentCont);
        $stmt->execute();
        $_SESSION['blogID'] = 2;
        unset($_POST['submitCom2']);
        header("Refresh:0");
}
if(isset($_POST['submitCom3'])){
    $commentCont = $_POST['commentCont3'];
    $stmt = $con->prepare('INSERT INTO comments(userid, commentText, blogNum) VALUES (?, ?, 3)');
        $stmt->bind_param('ss', $_SESSION['uid'], $commentCont);
        $stmt->execute();
        $_SESSION['blogID'] = 3;
        unset($_POST['submitCom3']);
        header("Refresh:0");
}
if(isset($_POST['submitCom4'])){
    $commentCont = $_POST['commentCont4'];
    $stmt = $con->prepare('INSERT INTO comments(userid, commentText, blogNum) VALUES (?, ?, 4)');
        $stmt->bind_param('ss', $_SESSION['uid'], $commentCont);
        $stmt->execute();
        $_SESSION['blogID'] = 4;
        unset($_POST['submitCom4']);
        header("Refresh:0");
}
    ?>
<html>
<link rel="stylesheet" href="blog.css" type="text/css">
<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>


<body style="font-family: Georgia, serif";>
<?php 
//display the login button if the user is not logged in.
if(!isset($_SESSION['validUser'])){
?>
<div class="btnRight">
<button style="font-family: Georgia, serif;" class="loginButton" onclick="openForm()">LOGIN</button>
</div>

<?php
}else{
//display the welcome message and logout button if user is logged in
?>
<div style="background: #edf2f3;" class="btnRight">
<a style="font-family: Georgia, serif; color: #27445C;" >WELCOME <?php echo(strtoupper(htmlspecialchars($_SESSION['uname'])));?>!&emsp;&ensp;</a>
<a href="logout.php" class="loginButton">LOGOUT</a>
</div>
<div style="background: #edf2f3"> </div>
<?php
}
?>
<!-- Page Styling -->
<div class= "banner">
</div>

<!--HTML for the login form -->
<div id="loginForm" class="loginForm">
    <form method = "post" class="form-container">
    <label for="username">Username:</label><br>
        <input type="text" name="uname" required><br>
        <label for="password">Password:</label><br>
        <input type="password" name="pword" required><br>
        <input class="submit" type="submit" value="Login" name='login'>
        <button type="button" class="cancel" onclick="closeForm()">Close</button>
</form>
</div>
<div style="font-family: Georgia, serif;"  class="header">
<h2>Welcome To My Blog!</h2>
<p>Click on the buttons in the menu to view and comment.</p>
</div>

<?php
        //display an error alert message if the username/password is incorrect.
        if(isset($_SESSION['error'])){ ?>
        <script>alert("Incorrect Username or Password!")</script>
        <?php
                       
    } ?>  

    <!--HTML to display the tabs -->
<div class="tab">
  <button class="tablinks" onclick="openTab(event, 'Post1')" id="1">Post 1</button>
  <button class="tablinks" onclick="openTab(event, 'Post2')" id="2">Post 2</button>
  <button class="tablinks" onclick="openTab(event, 'Post3')" id="3">Post 3</button>
  <button class="tablinks" onclick="openTab(event, 'Post4')" id="4">Post 4</button>
</div>

<!--HTML to display the content inside each tab -->
<div id="Post1" class="tabcontent" style="font-family: 'Montserrat';font-size: 20px;"><br><br>
  <h2>Post 1</h2>
  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam pulvinar consectetur pellentesque. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Quisque eget sollicitudin felis. Quisque eros lorem, tincidunt ut neque sit amet, finibus feugiat nisi. Praesent scelerisque lectus erat, non facilisis mi laoreet id. Suspendisse tempor, ipsum eu feugiat dignissim, mi est malesuada velit, ac sagittis tellus lectus vel nulla. Nunc vel ultricies tortor, quis faucibus purus. Pellentesque pretium fringilla ligula, et aliquet massa consequat ac.

<br><br>Aenean ut dictum sapien, et vehicula quam. Curabitur ut orci nec justo sollicitudin tincidunt in venenatis massa. Duis quis tortor gravida, molestie elit in, vestibulum dui. Donec porttitor vitae enim eu cursus. Mauris nec turpis ligula. Sed non porttitor nisl. Sed dignissim iaculis libero, at rutrum libero ultrices eget. In tempus, lectus quis commodo convallis, dolor sapien sollicitudin elit, at sollicitudin felis risus nec massa. Proin in mi ut libero mollis eleifend sed eget libero. Donec sit amet tellus ante. Etiam consequat ante ipsum, at vehicula lectus luctus at. Pellentesque vel tincidunt dui. Curabitur ligula neque, tincidunt nec vulputate ut, hendrerit in augue. Vestibulum sed lobortis ante, ac dapibus nisi. Sed et neque nec augue sodales varius et eu augue. Aliquam pellentesque dolor in neque condimentum pretium.</p>
<h3>Comments:</h3>
  <?php 

  //displays all the comments for the post
  $stmt = $con->prepare('SELECT accounts.username, comments.commentText, comments.blogNum FROM comments INNER JOIN accounts ON comments.userid = accounts.userid WHERE blogNum = 1;');
  $stmt->execute();
  $comResults = $stmt->get_result();
  while($rowData = $comResults->fetch_assoc()){?>
    <div style=" padding: 8px; margin-left:20px; text-indent: 10px;
    border-width:2px; border-style:solid; border-color:#81A2BD; ">
    <span style="font-weight:bolder;"><?php echo htmlspecialchars($rowData['username']);?></span><br>
    <span style="margin: 3px; font-size: 17px;"><?php echo htmlspecialchars($rowData['commentText']);?></span><br>
  </div><br>
<?php
  }
//if the user is logged in, display the comment form so the user can comment on the post.
  if(isset($_SESSION['validUser'])){ ?>
<br><form method="post">
<textarea style="font-size:17px; margin-left: 20px;" rows="5" cols="45" name="commentCont1" onkeyup="CharacterCount1(this);" placeholder="Write comment here..." maxlength="255" required></textarea>
<input style="font-size: 20px;" type="submit" value="Submit Comment" name="submitCom1" onclick="return confirm('Are you sure you want to submit this comment?')">
<div id="charCountVal1" style="font-size: 15px; margin-left: 14px;" >0 / 255</div>
                </form>
<?php 
  }
  ?>
</div>

<div id="Post2" class="tabcontent" style="font-family: 'Montserrat';font-size: 20px;"><br><br>
  <h2>Post 2</h2>
  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce rhoncus diam eget posuere tincidunt. Cras sollicitudin tellus ligula, quis sollicitudin neque consectetur a. Aliquam augue ante, ornare eleifend congue sit amet, vulputate eu orci. In nunc arcu, ultricies vitae ullamcorper vitae, egestas ac tortor. Suspendisse potenti. Mauris imperdiet eros a ipsum pulvinar, feugiat commodo dui mollis. Donec vehicula eget nunc id sagittis. Mauris tincidunt nulla nec diam vestibulum porta. Pellentesque interdum lectus leo, non finibus velit tincidunt nec. Ut et risus rutrum, lobortis nisl sit amet, venenatis augue.

<br><br>Phasellus vehicula, magna quis faucibus tincidunt, purus magna tempor magna, a suscipit ipsum augue vel ligula. Donec urna libero, fermentum nec ornare id, imperdiet eu velit. Nulla volutpat magna luctus lacus finibus, eget aliquam mauris facilisis. Mauris pharetra lobortis turpis sit amet luctus. Vestibulum sapien eros, elementum a quam eget, lobortis cursus dolor. In hac habitasse platea dictumst. Fusce mollis fermentum odio, pretium pellentesque magna bibendum sed. Aliquam rhoncus dictum risus, et luctus urna pulvinar nec.

<br><br>Morbi a tortor vitae libero rutrum mattis eget id magna. Fusce nisi diam, fermentum a eleifend at, egestas sit amet lectus. Vestibulum luctus purus convallis ipsum tempus dignissim. Donec ac justo cursus, mollis metus sed, suscipit erat. Vestibulum tortor nulla, vestibulum ut malesuada vel, lacinia eu est. Donec varius massa quis lectus convallis vehicula. Sed quis tortor at nisi dictum viverra ac sit amet est. Phasellus ipsum urna, viverra ut ultrices eget, dapibus fermentum tellus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p> 
<h3>Comments:</h3>
  <?php 
  $stmt = $con->prepare('SELECT accounts.username, comments.commentText, comments.blogNum FROM comments INNER JOIN accounts ON comments.userid = accounts.userid WHERE blogNum = 2;');
  $stmt->execute();
  $comResults = $stmt->get_result();
  while($rowData = $comResults->fetch_assoc()){ ?>
     <div style="padding: 8px; margin-left:20px; text-indent: 10px;
    border-width:2px; border-style:solid; border-color:#81A2BD; ">
    <span style="font-weight:bolder;"><?php echo htmlspecialchars($rowData['username']);?></span><br>
    <span style="margin: 3px; font-size: 17px;"><?php echo htmlspecialchars($rowData['commentText']);?></span><br>
  </div><br>
<?php
}
   if(isset($_SESSION['validUser'])){ ?>
  <br><form method="post">
<textarea style="font-size:17px; margin-left: 20px;" rows="5" cols="45" name="commentCont2" onkeyup="CharacterCount2(this);" placeholder="Write comment here..." maxlength="255" required></textarea>
<input style="font-size: 20px;" type="submit" value="Submit Comment" name='submitCom2' onclick="return confirm('Are you sure you want to submit this comment?')"> 
<div id="charCountVal2" style="font-size: 15px; margin-left: 14px;" >0 / 255</div>
 </form>

<?php
  }
?>
</div>


<div id="Post3" class="tabcontent" style="font-family: 'Montserrat';font-size: 20px;"><br><br>
  <h2>Post 3</h2>
  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus pulvinar magna mattis lorem efficitur vestibulum. Pellentesque at suscipit est, eget ultrices ligula. Cras nec cursus tellus. Proin eget augue eget felis faucibus auctor. Fusce varius elit a rhoncus porta. Aliquam porta nibh scelerisque elit gravida, vitae dapibus justo dignissim. Ut et erat euismod, vestibulum dolor sed, vehicula mi. Fusce volutpat diam id ligula gravida finibus. Cras tempor magna eu augue gravida, eget condimentum urna imperdiet. Curabitur non lacinia quam. Nulla placerat mauris in pretium sollicitudin. Nunc porttitor molestie scelerisque. Nam pellentesque sapien nec erat cursus finibus. In at sapien eget lorem pulvinar suscipit.

<br><br>Fusce blandit orci placerat lacus auctor, ultrices faucibus nibh lacinia. Nunc eget pharetra ex. Maecenas semper lorem sed justo egestas, et rutrum magna tempor. Fusce eleifend elementum rutrum. In venenatis eros ut nibh ultrices iaculis. Nulla fringilla lorem pretium metus lacinia, nec vehicula metus lacinia. In bibendum lectus eu semper efficitur. Donec egestas quis elit vel ultrices. Etiam hendrerit laoreet ornare. Donec tempor felis nec nisi pulvinar rhoncus. Curabitur eu pharetra lectus, in fermentum neque.

<br><br>In in rutrum augue. In rutrum pretium neque, quis pellentesque libero placerat finibus. Nullam augue libero, vehicula sit amet elit et, iaculis sollicitudin dui. Proin feugiat elit et mauris commodo, ac placerat est commodo. Proin ultrices felis eget enim venenatis dapibus. Sed ante enim, lacinia a sodales ac, bibendum efficitur quam. In sem urna, mollis ut nunc a, mattis pharetra magna. In hac habitasse platea dictumst. Fusce vel aliquet nibh, quis elementum massa. Quisque suscipit ex ac purus hendrerit luctus.

<br><br>Morbi luctus erat vel aliquet tempus. Sed tincidunt lorem ac ante efficitur aliquet. Nullam lobortis diam non ante consectetur, vitae tristique nulla pharetra. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Aliquam id pellentesque leo. Vivamus nec odio pretium, pharetra augue nec, consequat elit. Vestibulum tellus purus, sagittis at ligula eu, accumsan bibendum nisl. Integer ultrices pulvinar dolor, non pulvinar augue dignissim ut. Aliquam suscipit eu nisl sed blandit. In dui nisl, blandit non lorem at, porttitor aliquam eros. Proin ac mattis risus. Donec ullamcorper nisl non mollis sodales. Nunc felis risus, fermentum quis sem eu, vestibulum semper mi. Vestibulum mollis hendrerit ligula, quis vulputate odio congue sit amet. Pellentesque tempus, eros consectetur congue congue, ipsum dui pharetra augue, ut interdum orci risus scelerisque erat. In eu risus sed risus lobortis vulputate in id elit.
</p>
<h3>Comments:</h3>
  <?php $stmt = $con->prepare('SELECT accounts.username, comments.commentText, comments.blogNum FROM comments INNER JOIN accounts ON comments.userid = accounts.userid WHERE blogNum = 3;');
  $stmt->execute();
  $comResults = $stmt->get_result();
  while($rowData = $comResults->fetch_assoc()){ ?>
     <div style="padding: 8px; margin-left:20px; text-indent: 10px;
    border-width:2px; border-style:solid; border-color:#81A2BD; ">
    <span style="font-weight:bolder;"><?php echo htmlspecialchars($rowData['username']);?></span><br>
    <span style="margin: 3px; font-size: 17px;"><?php echo htmlspecialchars($rowData['commentText']);?></span><br>
  </div><br><?php
}
   if(isset($_SESSION['validUser'])){ ?>
  <br><form method="post">
<textarea style="font-size:17px; margin-left: 20px;" rows="5" cols="45" name="commentCont3" onkeyup="CharacterCount3(this);" placeholder="Write comment here..." maxlength="255" required></textarea>
<input style="font-size: 20px;" type="submit" value="Submit Comment" name='submitCom3' onclick="return confirm('Are you sure you want to submit this comment?')">
<div id="charCountVal3" style="font-size: 15px; margin-left: 14px; " >0 / 255</div>
       </form>

<?php
  }
  ?>
</div>
<div id="Post4" class="tabcontent" style="font-family: 'Montserrat';font-size: 20px;"><br><br>
  <h2>Post 4</h2>
  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque eget venenatis ipsum. Cras quam leo, tristique sed consequat ut, auctor quis eros. Curabitur ante orci, condimentum in ipsum nec, suscipit luctus odio. Praesent id dui volutpat, commodo lectus non, mattis elit. Suspendisse orci ipsum, bibendum nec arcu scelerisque, vestibulum consectetur purus. Pellentesque laoreet blandit quam, vel luctus erat elementum et. Nunc sed erat at dui semper laoreet et vitae magna.

<br><br>Nulla tempus lorem turpis, eu ullamcorper tortor fringilla quis. Curabitur finibus tortor non dui feugiat tincidunt. Sed laoreet, lorem faucibus ullamcorper feugiat, sapien tortor cursus sapien, vitae tincidunt felis erat quis felis. Sed et est eu quam sodales sollicitudin. Donec ac augue laoreet, imperdiet neque vel, porta diam. Aliquam nec viverra nisl. Vestibulum dictum tellus quis diam faucibus, accumsan vehicula justo sodales. Aenean mollis sagittis finibus.

<br><br>Aenean posuere mollis ligula et egestas. Donec in nisi eu erat dignissim eleifend vitae id purus. Sed tincidunt diam diam, id pellentesque tortor vulputate at. Suspendisse eu sapien sem. Suspendisse potenti. Maecenas vitae aliquam risus. Donec odio neque, convallis ut auctor sed, mollis convallis nibh. Maecenas rutrum neque ac ipsum laoreet luctus. Duis pharetra mollis odio, in tempus mauris auctor quis. Praesent interdum efficitur nunc et suscipit.</p>
<h3>Comments:</h3>
  <?php $stmt = $con->prepare('SELECT accounts.username, comments.commentText, comments.blogNum FROM comments INNER JOIN accounts ON comments.userid = accounts.userid WHERE blogNum = 4;');
  $stmt->execute();
  $comResults = $stmt->get_result();
  while($rowData = $comResults->fetch_assoc()){ ?>
    <div style="padding: 8px; margin-left:20px; text-indent: 10px;
    border-width:2px; border-style:solid; border-color:#81A2BD ; ">
    <span style="font-weight:bolder;"><?php echo htmlspecialchars($rowData['username']);?></span><br>
    <span style="margin: 3px; font-size: 17px;"><?php echo htmlspecialchars($rowData['commentText']);?></span><br>
  </div><br><?php
}
 if(isset($_SESSION['validUser'])){ ?>
  <br><form method="post">
<textarea style="font-size:17px; margin-left: 20px;" rows="5" cols="45" name="commentCont4" onkeyup="CharacterCount4(this);" placeholder="Write comment here..." maxlength="255" required></textarea>
<input style="font-size: 20px;" type="submit" value="Submit Comment" name='submitCom4' onclick="return confirm('Are you sure you want to submit this comment?')">
<div id="charCountVal4" style="font-size: 15px; margin-left: 14px;" >0 / 255</div>
               </form>

<?php
  }
  ?>
</div>



<script>
    //open and close login form
function openForm() {
  document.getElementById("loginForm").style.display = "block";
}
function closeForm() {
  document.getElementById("loginForm").style.display = "none";
}

//function for opening a tab when the button is clicked.
function openTab(evt, blogName) {
  var i, tabcontent, tablinks;
  //hides content for all tabs
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  //clears all tabs from the active classname
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  //displays the content for the tab that has been clicked, and sets its class name to active.
  document.getElementById(blogName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>

<?php 
//if the user has just submitted a comment, reload the page with the current post selected
if(isset($_SESSION['blogID'])){
    if($_SESSION['blogID']==1){
        ?>
        <script>
        document.getElementById("1").click();
        </script>
        <?php
    }else if($_SESSION['blogID']==2){
        ?>
        <script>
        document.getElementById("2").click();
        </script>
        <?php
    }else if($_SESSION['blogID']==3){
        ?>
        <script>
        document.getElementById("3").click();
        </script>
        <?php
    }else{
        ?>
        <script>
        document.getElementById("4").click();
        </script>
        <?php
    }
}else{ //if no comment has been submitted, the default tab is Post 1
    ?>
    <script>
document.getElementById("1").click();
        </script> <?php
}
?>
</script>
   
</body>
</html> 
<!--Gets the number of characters in each comment input box so the characters can be counted -->
<script>
function CharacterCount1(object){
	document.getElementById("charCountVal1").innerHTML = object.value.length+' /255';
}
function CharacterCount2(object){
	document.getElementById("charCountVal2").innerHTML = object.value.length+' /255';
}
function CharacterCount3(object){
	document.getElementById("charCountVal3").innerHTML = object.value.length+' /255';
}
function CharacterCount4(object){
	document.getElementById("charCountVal4").innerHTML = object.value.length+' /255';
}
</script>

<!-- Session timeout after 30 mins-->
<script type="text/javascript">
        var secsCounter = 0;
        var timer = null;
        var timeOutSecs = 1800; //30 minutes

        //if the mouse is moved, clicked or a key is pressed, the counter is set back to 0
        document.onclick = function () { secsCounter = 0; };
        document.onmousemove = function () { secsCounter = 0; };
        document.onkeypress = function () { secsCounter = 0; };

        //calls the checkCount() function at 1 second intervals
        timer = window.setInterval(checkCount, 1000);
        
        function checkCount() {
            secsCounter++;
            //if the seconds counter is greater or equal to the timeout seconds, alert the user that the session has timed out and redirect.
            if (secsCounter >= timeOutSecs) {
                window.clearInterval(timer);
                alert('Session Timed Out!\n Please Log In');
                window.location = "logout.php";
            }
        }
    </script>
<?php

//stops the error alert from being constantly displayed to the screen after a user has entered incorrect credentials.
unset($_SESSION["error"]);
?>


