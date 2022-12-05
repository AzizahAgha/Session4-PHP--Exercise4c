<?php

require_once "config.php";
session_start();
$email = $password =$first="";

if(isset($_POST["email"])){
   

    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter your email.";
    } else{
        $email = trim($_POST["email"]);
    }

   
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = md5($_POST["password"]);
    }

    // Include config file
   
    
    // Prepare a select statement
    $sql = "SELECT id FROM users WHERE Email='".$_POST['email']."'AND Password='".$password."'";
    $result = mysqli_query($link,$sql);
    $row=mysqli_num_rows($result);
    
            if($row == 1){
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $id;
                $_SESSION["email"] = $email;                           
                
                header("location: welcome.php");
                exit();
            } else{
                //$password_err = "Incorrect password.Please enter correct email or password.";
                header("location: error.html");
                exit();
            }
            
} 


?>

 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles.css">
   

</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5 heading">Login</h2>
                    
                   <div class="box"> 
                    
                   <p class="para">Please enter your email and password to SignIn to your account.</p>
                      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                       
                        <div class=" form-group">
                            <label>Email</label>
                            <i class="fa fa-user icon"></i>
                            <input type="email" name="email" class=" form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                            <span class="invalid-feedback"><?php echo $email_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <i class="fa fa-lock icon"> </i>
                            <i class="fa-solid fa-key-skeleton"></i>
                            <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                            <span class="invalid-feedback"><?php echo $password_err;?></span>
                        </div>
                        <p>Don't have an account? <a href="registration.php">Sign up now</a>.</p>
                       
                        <input type="submit" id="" class="D btn btn-link" value="SignIn">
                        <a href="login.php" class="D btn btn-link ml-2">Cancel</a>
                      </form>
                   </div>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
