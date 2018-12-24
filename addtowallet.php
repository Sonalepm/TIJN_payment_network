<?php
require_once "config.php";
session_start();
// Define variables and initialize with empty values
$amount = $balance = $PA_Balance = $PBAverified = "";
$amount_err = $balance_err = $verification_err = "";
$balance_alert = "You don't have enough balance in your Primary account!!";

//echo $_SESSION["id"];
//echo $_SESSION["username"];
//echo $_SESSION["ssn"];

if($_SERVER["REQUEST_METHOD"] == "POST"){
 
 // Validate amount entered
 
 if((empty(trim($_POST["amount"])))|| ($_POST["amount"] < 0)){
	 
	    $amount_err = "Please enter a valid amount .";     
    }  else{
		
        $amount = trim($_POST["amount"]);
    }
 


 // Check input errors before inserting in database
 if(empty($amount_err))
	 
 {
		 
	$sql = "SELECT balance,PA_Balance,PBAVerified FROM user_account WHERE ssn = ? ";
	$sql1 = "UPDATE user_account set balance = balance + ? , PA_balance = PA_Balance - ? where ssn = ?";
	
	
	
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
			   
			   if(mysqli_stmt_num_rows($stmt) == 1){
               mysqli_stmt_bind_result($stmt,$balance,$PA_Balance,$PBAverified); 
			   if(mysqli_stmt_fetch($stmt)){
				   
				   
                         if($amount > $PA_Balance)
                        {					
								header("location: insufficientbalance.php");
								mysqli_stmt_close($stmt);
								
						}
						else {
							if($stmt1 = mysqli_prepare($link,$sql1))
							{
								mysqli_stmt_bind_param($stmt1, "sss", $amount,$amount,$param_ssn);
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

  max-width: 200px; 

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
        <h2>Add To Wallet</h2>
    </div>
	
	<div class="wrapper">
	<p>Enter the amount to be transferred to TIJN wallet</p>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
	
	<div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                <input type="text" name="amount" class="form-control" value="<?php echo $amount; ?>">
                <span class="help-block"><?php echo $amount_err; ?></span>
            </div> 
	<div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="submit" class="btn btn-default" value="Cancel" formaction="welcome.php">
            </div>
	</form>
	</div>
	
	
</body>
</html>