<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter email address/phone.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id,ea_ssn,identifier,password FROM electronic_address1 WHERE identifier = ?";
		$sql1 = "SELECT identifier FROM electronic_address1 WHERE ea_ssn = ? and identifier <> ? order by id  limit 1";
		$sql2 = "SELECT Name,SSN,BankId,BANumber FROM user_account WHERE ssn = ?";
		$sql3 = "SELECT BankId,BANumber,Verified from has_additional where ssn = ?"; 
		
        // Set parameters
            $param_username = $username;
            
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt,$id,$ea_ssn,$identifier,$password1);
                    if(mysqli_stmt_fetch($stmt)){
                        //echo $password;
                        //echo $password1;
                        if($password == $password1)
                        {
							if($stmt1 = mysqli_prepare($link, $sql1)){
							mysqli_stmt_bind_param($stmt1, "ss",$ea_ssn,$param_username);
							if(mysqli_stmt_execute($stmt1)){
							mysqli_stmt_store_result($stmt1);
							mysqli_stmt_bind_result($stmt1,$phone);
							mysqli_stmt_fetch($stmt1);
							}
							}
							if($stmt2 = mysqli_prepare($link, $sql2)){
							mysqli_stmt_bind_param($stmt2, "s",$ea_ssn);
							if(mysqli_stmt_execute($stmt2)){
							mysqli_stmt_store_result($stmt2);
							mysqli_stmt_bind_result($stmt2,$name1,$ssn,$bankid,$banumber);
							mysqli_stmt_fetch($stmt2);
							}
							}
							
							if($stmt3 = mysqli_prepare($link, $sql3)){
							mysqli_stmt_bind_param($stmt3, "s",$ea_ssn);
							if(mysqli_stmt_execute($stmt3)){
							mysqli_stmt_store_result($stmt3);
							mysqli_stmt_bind_result($stmt3,$bankid2,$banumber2,$ba2verified);
							mysqli_stmt_fetch($stmt3);
							}
							}
							
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $identifier; 
							$_SESSION["ssn"] = $ssn;
							$_SESSION["phone"] = $phone;
							$_SESSION["bankid"] = $bankid;
							$_SESSION["banumber"] = $banumber;
							$_SESSION["name"] = $name1;
							$_SESSION["password"] = $password1;
							$_SESSION["bankid2"] = $bankid2;
							$_SESSION["banumber2"] = $banumber2;
							
                            // Redirect user to welcome page
                            header("location: welcome.php");
                        } 
                        else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        //mysqli_stmt_close($stmt1);		
                            
        // Close statement
       // mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>    
</body>
</html>