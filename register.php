<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $phone = $password = $confirm_password = $name1 =  $ssn  = $BankAccNum = $BankId= $PA_Balance = "";
$username_err = $phone_err = $password_err = $confirm_password_err = $name_err= $ssn_err = $BankAcc_err = $BankId_err = $PA_Balance_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username (username is email) 
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a email address.";
    } else{
        // Prepare a select statement
        $sql = "SELECT identifier FROM electronic_address1 WHERE identifier = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This email is already registered.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
	// Validate phone 
    if(empty(trim($_POST["phone"]))){
        $phone_err = "Please enter a phone number.";
    } elseif(strlen(trim($_POST["phone"])) < 10){
        $phone_err = "Invalid phone number";
    }else{
		
        // Prepare a select statement
        $sql4 = "SELECT identifier FROM electronic_address1 WHERE identifier = ?";
        
        if($stmt4 = mysqli_prepare($link, $sql4)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt4, "s", $param_phone);
            
            // Set parameters
            $param_phone = trim($_POST["phone"]);
            
			
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt4)){
                /* store result */
                mysqli_stmt_store_result($stmt4);
                
                if(mysqli_stmt_num_rows($stmt4) > 0 ){
                    $phone_err = "This Phone is already registered.";
                } else{
                    $phone = trim($_POST["phone"]);
                }
            } else{
                echo "Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt4);
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
    
    if(empty(trim($_POST["name1"]))){
        $name_err = "Please enter Name .";     
    } else{
        $name1 = trim($_POST["name1"]);
    }
    
    if(empty(trim($_POST["ssn"]))){
        $ssn_err = "Please enter SSN .";     
    } elseif(strlen(trim($_POST["ssn"])) < 9){
        $ssn_err = "Password must be 9 digits.";
    } else{
        $ssn = trim($_POST["ssn"]);
    }
    
    if(empty(trim($_POST["BankAccNum"]))){
        $BankAcc_err = "Please enter Acc num .";     
    } else{
        $BankAccNum = trim($_POST["BankAccNum"]);
    }
     
    
    if(empty(trim($_POST["BankId"]))){
        $BankId_err = "Please enter Bank id .";     
    }  else{
        $BankId = trim($_POST["BankId"]);
    }
    
	if(empty(trim($_POST["PA_Balance"]))){
        $PA_Balance_err = "Please enter Primary Bank Balance .";     
    }  else{
        $PA_Balance = trim($_POST["PA_Balance"]);
    }
	
	
	
    // Check input errors before inserting in database
    if(empty($username_err) && empty($phone_err) && empty($password_err) && empty($confirm_password_err) && empty($name_err) && empty($ssn_err) && empty($BankAcc_err) && empty($BankId_err) && empty($PABalance_err)) {
        
        // Prepare an insert statement
        
        // Set parameters
            $param_username = $username;
			$param_phone = $phone;
            $param_password = $password; 
            $param_name = $name1;
            $param_ssn = $ssn;
            $param_bankaccnum = $BankAccNum;
            $param_bankid = $BankId;
			$param_pabalance = $PA_Balance;
			
			
			
			
			
        $sql  = "INSERT INTO BANK_ACCOUNT(BankID,BANumber) VALUES (?,?)";
        $sql1 = "INSERT INTO USER_ACCOUNT(SSN,NAME,BANKID,BANUMBER,PA_BALANCE) VALUES (?,?,?,?,?)";  
        $sql2 = "INSERT INTO electronic_address1(Identifier,EA_SSN,type,Password) values (?,?,?,?)";
        $sql3 = "INSERT INTO electronic_address1(Identifier,EA_SSN,type,Password) values (?,?,?,?)";
        
		$param_type1 = "email";
		$param_type2 = "phone";
		
		
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $BankId, $BankAccNum);
                           
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
            
                // Redirect to login page
                //header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
         // Close statement
        mysqli_stmt_close($stmt);
        if($stmt1 = mysqli_prepare($link, $sql1)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt1, "sssss", $ssn,$name1,$BankId,$BankAccNum,$PA_Balance);
                           
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt1)){
                // Redirect to login page
                //header("location: login.php");
                mysqli_stmt_close($stmt1);
                }
        
        }
         // Close statement
        //mysqli_stmt_close($stmt1);
		
        if($stmt2 = mysqli_prepare($link, $sql2)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt2, "ssss", $username,$ssn,$param_type1,$param_password);
                           
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt2)){
                // Redirect to login page
                //header("location: login.php");
                mysqli_stmt_close($stmt2);
                }
        
        }
		//mysqli_stmt_close($stmt2);
		
		
		//echo $phone;
		if($stmt3 = mysqli_prepare($link, $sql3)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt3, "ssss", $param_phone,$param_ssn,$param_type2,$param_password);
                 echo "reached here";
				 
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt3)){
                // Redirect to login page
                header("location: login.php");
                mysqli_stmt_close($stmt3);
                }
				
			else {
                echo "Something went wrong.";
            }
                }
		
    }
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; align: center; }
        .wrapper{ width: 1500px; padding: 10px; }
		
		h2{
			
			text-align: center;
		}
		p{
			font: 10px;
			color:green;
			text-align: center;
			padding: 30px;
		}
		form { 
	margin: 0 auto; 
	width:550px;
	}
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
		
			<div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                <label>FirstName</label>
                <input type="text" name="name1" class="form-control" value="<?php echo $name1; ?>">
                <span class="help-block"><?php echo $name_err; ?></span>
            </div> 
			
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Email</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            
            <div class="form-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
                <label>Phone Number</label>
                <input type="text" name="phone" class="form-control" value="<?php echo $phone; ?>">
                <span class="help-block"><?php echo $phone_err; ?></span>
            </div>
			
            <div class="form-group <?php echo (!empty($ssn_err)) ? 'has-error' : ''; ?>">
                <label>SSN</label>
                <input type="text" name="ssn" class="form-control" value="<?php echo $ssn; ?>">
                <span class="help-block"><?php echo $ssn_err; ?></span>
            </div> 
            
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            
            <div class="form-group <?php echo (!empty($BankAcc_err)) ? 'has-error' : ''; ?>">
                <label>Bank Account Number</label>
                <input type="text" name="BankAccNum" class="form-control" value="<?php echo $BankAccNum; ?>">
                <span class="help-block"><?php echo $BankAcc_err; ?></span>
            </div> 
            <div class="form-group <?php echo (!empty($BankId_err)) ? 'has-error' : ''; ?>">
                <label>Bank ID </label>
                <input type="text" name="BankId" class="form-control" value="<?php echo $BankId; ?>">
                <span class="help-block"><?php echo $BankId_err; ?></span>
            </div> 
            
			<div class="form-group <?php echo (!empty($PA_Balance_err)) ? 'has-error' : ''; ?>">
                <label>Primary Account Balance</label>
                <input type="text" name="PA_Balance" class="form-control" value="<?php echo $PA_Balance; ?>" >
				<span class="help-block"><?php echo $PA_Balance_err; ?></span>
            </div> 
			
					
            
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            
            
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>    
</body>
</html>