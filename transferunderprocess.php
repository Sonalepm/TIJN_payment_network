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
	 h3 {
	 font: 10px;
   color:red;
   margin-top:150px;
  margin-bottom:150px;
}
p{
  margin-top:10px;
  margin-bottom:10px;
}

    </style>
</head>
<body>
    <div class="page-header">
        <h1>TIJN Payment Network</h1>
		
        <h3>Transaction Under Process...</h3>
		
		
    
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
		<h5>Click here to cancel transaction                            ......... <input type="submit" class="btn" value="Cancel" formaction="canceltransaction.php"></h5>
	</form>
	
	</div>
	
	
	<p><a href="welcome.php">Back to Dashboard</a></p>	
	<p></p>	
</body>
</html>