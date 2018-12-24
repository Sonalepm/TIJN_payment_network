<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
		.wrapper{ margin-right: auto; 
  margin-left:  auto;

  max-width: 200px; 

  padding-right: 10px; 
  padding-left:  10px; 
  }
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
		
        <h3>Sorry!! You don't have enough balance in your account...</h3>
    </div>
	
	<p><a href="addtowallet.php">Back to Add to wallet</a></p>	
	<p><a href="welcome.php">Back to Dashboard</a></p>	
</body>
</html>