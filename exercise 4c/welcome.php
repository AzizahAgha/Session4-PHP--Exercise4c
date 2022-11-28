<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <h2 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["email"]); ?></b>. Welcome to our site.</h2>
    <p>
        <a href="reset.php" class="W btn btn-warning ">Change Password</a>
        <button id="register" class="btn btn-danger ml-3" >Sign Out</button>
       
    </p>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        $(function(){
           $('#register').on('click',function(){
               Swal.fire({
                  
                  title: 'Are you Sure',
                  text: 'You will be Loged out from your account',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: '<a href="login.php" style="color:white;text-decoration: none;">Yes</a>'
                })
           });
        });
           // setTimeout(function(){
           //     window.location.href="login.php";
           //  },30000);

    </script>   
</body>
</html>