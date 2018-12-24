<?php
require_once "config.php";
session_start();

//echo $_SESSION["bankid"];
//echo $_SESSION["banumber"];

//bank account can be verified by sending $10 from TIJN wallet to bank account.



// Define variables and initialize with empty values
$amount = $verify = $balance = $PA_Balance = $PBAverified = "";
$amount_err = $balance_err = $verification_err = "";
$balance_alert = "You don't have enough balance in your TIJN wallet!!";
if(array_key_exists('Verify',$_POST)){
	
	$sql = "SELECT balance,PA_Balance,PBAVerified FROM user_account WHERE ssn = ? ";
	$sql1 = "UPDATE user_account set balance = balance - 10 , PA_balance = PA_Balance + 10 ,PBAVerified = 1 where ssn = ?";
	
	if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_ssn);
                           
						   $param_ssn = $_SESSION["ssn"];
						   $param_balance = $balance;
						   $param_pabalance = $PA_Balance;
						  
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
            
                 /* store result */
               mysqli_stmt_store_result($stmt);
			   echo "Entered  here "; 
			   if(mysqli_stmt_num_rows($stmt) == 1){
               mysqli_stmt_bind_result($stmt,$balance,$PA_Balance,$PBAverified); 
			   
			   
			   if(mysqli_stmt_fetch($stmt)){
				   
				      if( $balance < 10)
                        {		
						
								echo $balance_alert;		
								header("location: insufficientbalance.php");
								mysqli_stmt_close($stmt);
								
						}
						else {
							if($stmt1 = mysqli_prepare($link,$sql1))
							{
								echo "You have sufficient balance";
								mysqli_stmt_bind_param($stmt1, "s",$param_ssn);
								mysqli_stmt_execute($stmt1);
								mysqli_stmt_close($stmt1);
								header("location: transfersuccess.php");
							}
						}
				   
					
						
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
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
		.vbutton{
			margin-right: auto; 
  margin-left:  auto;

  max-width: 200px; 

  padding-right: 50px; 
  padding-left:  50px;
  padding-top:  50px;
  padding-bottom:  50px;
		}
		
    </style>
</head>
<body>
    <div class="page-header">
        <h1>TIJN Payment Network</h1>
    </div>
	
	<form  method="post">
	<div class = "vbutton">
	<input type="submit" name="Verify"  value="Verify">
	</div>
	</form>
	
	<p><a href="addtowallet.php">Back to Add to wallet</a></p>	
	<p><a href="welcome.php">Back to Dashboard</a></p>	
</body>
</html>