<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$first = $last = $email = $password =$confirm_password="";
 $first_err = $last_err = $email_err = $password_err =$confirm_password_err="";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate name  
    $input_first = trim($_POST["first"]);
    if(empty($input_first)){
        $first_err = "Please enter a name.";
    
   // } elseif(!filter_var($input_first, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
    //    $first_err = "Please enter a valid name.";
    } else{
        $first = $input_first;
    }
    
    // Validate lastname
    $input_last = trim($_POST["last"]);
    if(empty($input_last)){
        $last_err = "Please enter your last name.";     
    } else{
        $last = $input_last;
    }

    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter your Email.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE Email= ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This Email is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }

      // Validate confirm password
      if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
       
    }

      
    
    
    // Check input errors before inserting in database
    if(empty($first_err) && empty($last_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO users (FirstName,LastName,Email,Password) VALUES (?,?,?,?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_first, $param_last, $param_email, $param_password);
            

            // Set parameters
            $param_first = $first;
            $param_last = $last;
            $param_email = $email;
            $param_password = $password;
           
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
               
                header("location: saved.html");
                exit();
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
   
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-4 heading">SignUp</h2>
                   <div class="box"> 
                      <p class="para">Please fill this form and submit to SignUp.</p>
                      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                       
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="first" class="form-control <?php echo (!empty($first_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $first; ?>">
                            <span class="invalid-feedback"><?php echo $first_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input name="last" class="form-control <?php echo (!empty($last_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $last; ?>">
                            <span class="invalid-feedback"><?php echo $last_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                            <span class="invalid-feedback"><?php echo $email_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                            <span class="invalid-feedback"><?php echo $password_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                            <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                        </div>
                       
                        <p>Already have an account? <a href="login.php">LogIn</a>.</p>
                        <input type="submit"  class="D btn btn-link" value="SignUp">
                        <input type="reset" class="C btn btn-link ml-2" value="Cancel">
                      </form>
                   </div>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>