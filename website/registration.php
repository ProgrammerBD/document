
<?php
session_start();
$_SESSION['message'] ='';

$mysqli = new mysqli('localhost', 'root', '', 'choshmabd');

if($_SERVER['REQUEST_METHOD'] == 'POST'   ){
  // two password match
  if($_POST['password'] == $_POST['confirmpassword']){
    
    


    $username = $mysqli->real_escape_string($_POST['username']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $password = md5($_POST['password']);
    $contact = $mysqli->real_escape_string($_POST['contactno']);
    $avatar_path = $mysqli->real_escape_string('image/'.$_FILES['avatar']['name']);

    if (preg_match("!image!", $_FILES['avatar']['type']))
    {
        if(copy($_FILES['avatar']['tmp_name'], $avatar_path)){

          $_SESSION['username'] = $username;
            $_SESSION['avatar'] = $avatar_path;
          $sql = "INSERT INTO Registration (`UserName`, `Email`, `Contact`, `UserPassword`, `avatar`) VALUES ('$username', '$email', '$contact', '$password', '$avatar_path')";
    
          if($mysqli->query($sql) === true ){
            $_SESSION['message'] = 'Registration Successful!';
            header("location: welcome.php");
          }
          else
          {
            $_SESSION['message'] = "User not added!!! Registration Failed!";

          }
      
        }

        else{
          $_SESSION['message'] = 'Image Not Uploaded!';
        }
    }
    else{
          $_SESSION['message'] = 'Not in format jpg or png!';
        }
    

 }
 else{
 $_SESSION['message'] = 'Two passwords not matches! ';
}

}


?>






<head>

<link href="//db.onlinewebfonts.com/c/a4e256ed67403c6ad5d43937ed48a77b?family=Core+Sans+N+W01+35+Light" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="registration.css" type="text/css">

<head>
<body>

<div class="body-content">
  <div class="module">
    <h1>Create an account</h1>
    <form class="form" action="registration.php" method="POST" enctype="multipart/form-data" autocomplete="off">
      <div class="alert alert-error"> <?= $_SESSION['message']  ?>      </div>
      <input type="text" placeholder="User Name" name="username" required />
      <input type="email" placeholder="Email" name="email" required />
      <input type="text" placeholder="Contact Number" name="contactno" required />
      <input type="password" placeholder="Password" name="password" autocomplete="new-password" required />
      <input type="password" placeholder="Confirm Password" name="confirmpassword" autocomplete="new-password" required />
      <div class="avatar"><label>Select your avatar: </label><input type="file" name="avatar" accept="image/*" required /></div>
      <input type="submit" value="Register" name="register" class="btn btn-block btn-primary" />
    </form>
  </div>
</div>


</body>>