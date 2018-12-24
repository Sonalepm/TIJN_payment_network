<?php
require_once "config.php";
session_start();

//echo $_SESSION["phone"];

$otp = $response ="";
$otp_err = "";
$phone = $_SESSION["phone"];


$otp_list  = array(671203,782549,651307,455103,271098);


if($_SERVER["REQUEST_METHOD"] == "POST"){
 
 // Validate amount entered
 
 if((empty(trim($_POST["otp"])))){
	 
	    $otp_err = "Please enter your OTP";     
    }  else{    
        $otp = trim($_POST["otp"]);
    }
	
	if(empty($otp_err))
	 
 {
	 //validate otp
	 
	 
		if( strlen(trim($_POST["otp"])) > 6 )
		{
			$otp_err = "The OTP you entered is wrong.";
		}
		elseif(!in_array($otp,$otp_list))
		{
			$otp_err = "The OTP you entered is wrong. Phone number not verified";
		}
		else
		{
			$otp_err = "Phone number verified";
			
			$sql = "UPDATE electronic_address1 set verified = 1 where identifier = ? ";
			
			if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $phone);	  
						   
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
            
                 /* store result */
               mysqli_stmt_store_result($stmt);
			   
			   mysqli_stmt_close($stmt);
			    				
					
			   }
			}
 
 
 
	}
		}
			
		
 
	
	
	
	
	
	
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add to Wallet</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
		.wrapper{ margin-right: auto; 
  margin-left:  auto;

  max-width: 300px; 

  padding-right: 10px; 
  padding-left:  10px; 
  }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>TIJN Payment Network</h1>
    </div>
	
	<div class="page-header">
        <h2>Phone Verification</h2>
    </div>
	
	<div class="wrapper">
	<p>Enter your OTP</p>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
	
	<div class="form-group <?php echo (!empty($otp_err)) ? 'has-error' : ''; ?>">
                <input type="text" name="otp" class="form-control" value="<?php echo $otp; ?>">
                <span class="help-block"><?php echo $otp_err; ?></span>
            </div> 
	<div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="submit" class="btn btn-default" value="Cancel" formaction="welcome.php">
            </div>
	</form>
	</div>
	
	
</body>
</html>