
<?php
session_start();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    
</head>
<body>

<?php
require_once "config.php";

$email = $password =$new_password=$confirm_password="";
if(isset($_POST['submit'])){

    if(empty(trim($_POST["email"]))){
         $email_err = "Please enter your email.";
    } else{
        $email = trim($_POST["email"]);
    }

    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter the OLD password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
   

    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
         
    // $email = $_POST["email"];
    // $password = $_POST["password"];
    // $new_password = $_POST["new_password"];
    // $confirm_password_err = $_POST["confirm_password"];

    if( empty($email_err) && empty($password_err) && empty($new_password_err)&& empty($confirm_password_err)){

    $query=mysqli_query($link,"SELECT Email,Password FROM users where Email='$email' AND Password='$password'");

    $num =mysqli_fetch_array($query);

    if($num>0){

        $sql=mysqli_query($link,"UPDATE users SET Password='$new_password' where email='$email'");
       // $_SESSION['msg1']="password changed";
       header("location: reset.html");
       exit();
       
    }else{
       // $_SESSION['msg2']="password not match";
      $password_err = "Incorrect password.Please enter the correct email or password.";
    }
   }
}



?>
  

    <div class="wrapper">
<!--  <p style="color:red;"><?php echo  $_SESSION['msg1'];?><?php $_SESSION['msg1']="";?></p> -->
        <h2 class="heading">Reset Password</h2>
        <div class="box">
        <p class="para">Please fill out this form to reset your password.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
           <div class=" form-group">
                <label>Email</label>
                <i class="fa fa-user icon"></i>
                <input type="email" name="email" class=" form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                <span class="invalid-feedback"><?php echo $email_err;?></span>
            </div>
            <div class="form-group">
                <label>Old Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="new_password" class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_password; ?>">
                <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
            </div>
            <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                            <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                        </div>
            <div class="form-group">
                <input type="submit"  name="submit" class="D btn btn-link" value="Submit">
                <a class=" D btn btn-link ml-2" href=" welcome.php">Cancel</a>
            </div>
        </form>
      </div>
    </div> 
   
</body>
</html>
