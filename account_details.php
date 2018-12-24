<?php
// Include config file
require_once "config.php";
session_start();


//echo $_SESSION["phone"];
//echo "Hello";

// Define variables and initialize with empty values
$username = $phone = $password = $confirm_password = $name1 = $bankacnum =  $ssn  = $BankAccNum = $bankid = $bankid2= $BankId = $PA_Balance =$BankAccNum2 =$BankAccNum3 = $BankId2 = $BankId3 = $banumber2 = $phone1 = $email1 = $verified = "";
$username_err = $phone_err = $password_err = $confirm_password_err = $name_err= $ssn_err = $BankAcc_err = $BankId_err  = $BankAcc2_err = $BankAcc3_err = $BankId2_err = $BankId3_err = $phone1_err = $email1_err = "";
 
//no need to verify if any fields are blank. Only details that need to be editted are entered.

  
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
 
    // Validate username (username is email) 
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a email address.";
	
		
    } else{
			
        // Prepare a select statement
        $sql = "SELECT identifier FROM electronic_address1 WHERE identifier = ? and ea_ssn <> ? ";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username,$_SESSION["ssn"]);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "Another user is already registered with this email.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Please try again later.";
            }
        }else{
			$username = trim($_POST["username"]);
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
        $sql5 = "SELECT identifier FROM electronic_address1 WHERE identifier = ? and ea_ssn <> ?";
        
        if($stmt5 = mysqli_prepare($link, $sql5)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt5, "ss", $param_phone,$_SESSION["ssn"]);
            
            // Set parameters
            $param_phone = trim($_POST["phone"]);
            
			
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt5)){
                /* store result */
                mysqli_stmt_store_result($stmt5);
                
                if(mysqli_stmt_num_rows($stmt5) > 0 ){
                    $phone_err = "Another user is already registered with the same phone number";
                } else{
                    $phone = trim($_POST["phone"]);
                }
            } else{
                echo "Please try again later.";
            }
        }
		else{
			$username = trim($_POST["username"]);
		}
         
        // Close statement
        mysqli_stmt_close($stmt5);
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
        $ssn_err = "SSN must be 9 digits.";
    } else{
        $ssn = trim($_POST["ssn"]);
    }
    
    if(empty(trim($_POST["BankAccNum"]))){
       // $BankAcc_err = "Please enter Acc num .";     
    } else{
        $BankAccNum = trim($_POST["BankAccNum"]);
    }
     
    
    if(empty(trim($_POST["BankId"]))&& !empty(trim($_POST["BankAccNum"]))){
        $BankId_err = "Please enter Bank id .";     
    }  else{
        $BankId = trim($_POST["BankId"]);
    }
	
 if(!empty(trim($_POST["phone1"])))
 { $phone1 = trim($_POST["phone1"]);
 }
 
 
	 
 if(!empty(trim($_POST["email1"])))
 { $email1 = trim($_POST["email1"]);
 }
 
 
 
 if(empty(trim($_POST["BankAccNum2"]))){
       // $BankAcc2_err = "Please enter Acc num .";     
    } else{
        $BankAccNum2 = trim($_POST["BankAccNum2"]);
    }
     
    
    if(empty(trim($_POST["BankId2"])) && !empty(trim($_POST["BankAccNum2"]))){
        $BankId2_err = "Please enter Bank id .";     
    }  else{
        $BankId2 = trim($_POST["BankId2"]);
    }
	  
	  $_SESSION["phone1"] =  $phone1;
	  $_SESSION["email1"] = $email1;
	  
	  
    // Check input errors before inserting in database
    if(empty($username_err) && empty($phone_err) && empty($password_err) && empty($confirm_password_err) && empty($name_err) && empty($ssn_err) && empty($BankAcc_err) && empty($BankId_err) && empty($PABalance_err)) {
        
        // Prepare an insert statement
        
        // Set parameters
            $param_username = $username;
			$param_phone = $phone;
            $param_password = $password; // Creates a password hash
            $param_name = $name1;
            $param_ssn = $ssn;
            $param_bankaccnum = $BankAccNum;
            $param_bankid = $BankId;
			$param_pabalance = $PA_Balance;
			$param_type1 = "email";
			$param_type2 = "phone";
		
			
        $sql  = "INSERT INTO BANK_ACCOUNT(BankID,BANumber) VALUES (?,?)";
        $sql1 = "UPDATE USER_ACCOUNT SET  NAME = ? ,BANKID = ? ,BANUMBER = ?,PA_BALANCE = ? where ssn = ?";  
        $sql2 = "UPDATE ELECTRONIC_ADDRESS1 SET Identifier = ?,type= ?,Password = ? where ea_ssn = ? and type = ? ";
        $sql3 = "UPDATE ELECTRONIC_ADDRESS1 SET Identifier = ?,type= ?,Password = ? where ea_ssn = ? and type = ? ";
		$sql4 = "INSERT INTO HAS_ADDITIONAL(SSN,BankID,BANumber) values (?,?,?)";
		$sql5 = "INSERT INTO ELECTRONIC_ADDRESS1(IDENTIFIER,EA_SSN,TYPE,PASSWORD,VERIFIED) values (?,?,?,?,?)";
		
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $BankId, $BankAccNum);
                           
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
				//success
              } 
        }
         
         // Close statement
        mysqli_stmt_close($stmt);
        if($stmt1 = mysqli_prepare($link, $sql1)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt1, "sssss", $name1,$BankId,$BankAccNum,$PA_Balance,$_SESSION["ssn"]);
                           
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt1)){
                // Redirect to login page
                //header("location: login.php");
                mysqli_stmt_close($stmt1);
                }
        
        }
         // Close statement
       // mysqli_stmt_close($stmt1);
		
        if($stmt2 = mysqli_prepare($link, $sql2)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt2, "sssss", $username,$param_type1,$param_password,$_SESSION["ssn"],$param_type1);
                           
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt2)){
                // Redirect to login page
                //header("location: login.php");
                mysqli_stmt_close($stmt2);
                }
        
        }
	//	mysqli_stmt_close($stmt2);
		
		//echo $phone;
		if($stmt3 = mysqli_prepare($link, $sql3)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt3,"sssss", $param_phone,$param_type2,$param_password,$_SESSION["ssn"],$param_type2);
                // echo "reached here";
				 
				
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt3)){
                // Redirect to login page
				
                //header("location: login.php");
                mysqli_stmt_close($stmt3);
                }
				
                }
			//mysqli_stmt_close($stmt3);	
			//echo "REached here";
			
			if($stmt10 = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt10, "ss", $BankId2,$BankAccNum2);
                           
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt10)){
						//added new bank details to bank_Account table.
              } 
			 
        }
		
		
				//insert new bank account to has_additional.
				
			if($stmt4 = mysqli_prepare($link, $sql4)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt4, "sss", $ssn,$BankId2,$BankAccNum2);		 
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt4)){
                // Redirect to login page
                //header("location: login.php");
				//echo "reached here";
                mysqli_stmt_close($stmt4);
                }
			
                }	
		
		$verified = False;
		//insert new phone 
		if(!empty($phone1))
		{
			
			if($stmt5 = mysqli_prepare($link, $sql5)){
								
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt5, "sssss", $phone1,$ssn,$param_type2,$param_password,$verified);		 
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt5)){
                // Redirect to login page
                //header("location: login.php");
				 mysqli_stmt_close($stmt5);
                }
			
                }	
		}
			
		//insert new email
		if(!empty($email1))
		{
			
			if($stmt5 = mysqli_prepare($link, $sql5)){
								
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt5, "sssss", $email1,$ssn,$param_type1,$param_password,$verified);		 
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt5)){
                // Redirect to login page
                //header("location: login.php");
				 mysqli_stmt_close($stmt5);
                }
			
                }	
		}
		//header("location: editaccountsuccess.php");
    }
   // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif;  
		}
        .wrapper{ width: 1500px; padding: 10px;
		align: center;
		}
		
		h4{
			font: 10px;
			color:green;
			text-align: center;
			padding: 30px;
		}
		h2{
			
			text-align: center;
		}
		
		form { 
	margin: 0 auto; 
	width:550px;
	}
		
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Personal Details</h2>
        <h4>Edit your account details .</h4>
		
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
		
			<div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                <label>FirstName</label>
                <input type="text" name="name1" class="form-control" value="<?php echo $_SESSION["name"]; ?>">
                <span class="help-block"><?php echo $name_err; ?></span>
            </div> 
			
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Email</label>
                <input type="text" name="username" class="form-control" value="<?php echo $_SESSION["username"]; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            
			<div class="form-group <?php echo (!empty($email1_err)) ? 'has-error' : ''; ?>">
                <label>Additional Email</label>
                <input type="text" name="email1" class="form-control" value="<?php echo $email1 ; ?>"><a href="removeemail.php">Remove</a>
                <span class="help-block"><?php echo $email1_err; ?></span>
            </div> 
			
            <div class="form-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
                <label>Phone Number</label>
                <input type="text" name="phone" class="form-control" value="<?php echo $_SESSION["phone"]; ?>">
                <span class="help-block"><?php echo $phone_err; ?></span>
            </div>
			
			<div class="form-group <?php echo (!empty($phone1_err)) ? 'has-error' : ''; ?>">
                <label>Additional Phone Number</label>
                <input type="text" name="phone1" class="form-control" value="<?php echo $phone1 ; ?>"><a href="removephone.php">Remove</a>
                <span class="help-block"><?php echo $phone1_err; ?></span>
            </div>
			
            <div class="form-group <?php echo (!empty($ssn_err)) ? 'has-error' : ''; ?>">
                <label>SSN</label>
                <input type="text" name="ssn" class="form-control" value="<?php echo $_SESSION["ssn"]; ?>">
                <span class="help-block"><?php echo $ssn_err; ?></span>
            </div> 
            
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $_SESSION["password"]; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $_SESSION["password"]; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            
            <div class="form-group <?php echo (!empty($BankAcc_err)) ? 'has-error' : ''; ?>">
                <label>Primary Bank Account Number</label>
                <input type="text" name="BankAccNum" class="form-control" value="<?php echo $_SESSION["banumber"]; ?>">
                <span class="help-block"><?php echo $BankAcc_err; ?></span>
            </div> 
            <div class="form-group <?php echo (!empty($BankId_err)) ? 'has-error' : ''; ?>">
                <label>Primary Bank ID </label>
                <input type="text" name="BankId" class="form-control" value="<?php echo $_SESSION["bankid"]; ?>">
                <span class="help-block"><?php echo $BankId_err; ?></span>
            </div> 
            
				
			<h5>Add additional bank account : </h5>
					
			<div class="form-group ">
                <label>Bank Account Number</label> 	
                <input type="text" name="BankAccNum2" class="form-control" value="<?php echo $_SESSION["banumber2"]; ?>">
                <span class="help-block"><?php echo $BankAcc2_err; ?></span>
            </div> 
            <div class="form-group ">
                <label>Bank ID </label>
                <input type="text" name="BankId2" class="form-control" value="<?php echo $_SESSION["bankid2"]; ?>"><a href="unlinkaccount.php">Unlink</a>
                <span class="help-block"><?php echo $BankId2_err; ?></span>
            </div> 
            
						
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="submit" class="btn btn-default" value="Cancel" formaction="welcome.php" >
            </div>
            
            
            
        </form>
    </div>    
</body>
</html>