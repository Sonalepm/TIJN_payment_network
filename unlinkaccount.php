<?php

require_once "config.php";
session_start();

//echo $_SESSION["bankid2"];
//echo $_SESSION["banumber2"];

$ssn = $bankid = $banumber = "";

$sql = "DELETE from bank_Account where BankID = ? and BANumber = ?";

if($stmt = mysqli_prepare($link, $sql)){
	
	mysqli_stmt_bind_param($stmt, "ss", $param_bankid2,$param_banumber2 );
	
	$param_ssn = $_SESSION["ssn"];
	$param_bankid2 = $_SESSION["bankid2"];
	$param_banumber2 = $_SESSION["banumber2"];
	
	
	if(mysqli_stmt_execute($stmt)){
            
                 /* store result */
               		
			   }
			   else { echo "Some error occured";
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
	 h3 {
	 font: 10px;
   color:red;
   margin-top:150px;
  margin-bottom:90px;
}
    </style>
</head>
<body>
    <div class="page-header">
        <h1>TIJN Payment Network</h1>
		
        <h3>Unlink Successful...</h3>
    </div>
	
	<p><a href="addtowallet.php">Back to Add to wallet</a></p>	
	<p><a href="welcome.php">Back to Dashboard</a></p>	
</body>
</html>