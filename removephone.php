<?php

require_once "config.php";
session_start();

$phone = $phone_err = "";
echo $_SESSION["phone"];
//enter phone you want to delete and then delete.

if($_SERVER["REQUEST_METHOD"] == "POST"){
	
if(empty(trim($_POST["phone"]))){
        $phone_err = "Please enter phone number .";     
    } else{
        $phone = trim($_POST["phone"]);
    }
	
	echo $phone;
if($phone <> $_SESSION["phone"])
	{
	$sql = "DELETE from electronic_address1 where ea_ssn = ? and identifier = ?";

	if($stmt = mysqli_prepare($link, $sql)){
	
	mysqli_stmt_bind_param($stmt, "ss",$param_ssn,$phone);
	
	$param_ssn = $_SESSION["ssn"];
	
	
	
	if(mysqli_stmt_execute($stmt)){
            
               echo "Success";
			 header("location: welcome.php");  		
			  }
			  else { echo "Some error occured";
			   }
			   }
}
else{$phone_err = "Cannot removed primary phone number";}
}

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

  max-width: 400px; 

  padding-right: 10px; 
  padding-left:  10px; 
  }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>TIJN Payment Network</h1>
    </div>
	
	
	<div class="wrapper">
	<p>Enter the phone to be removed</p>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
	
	<div class="form-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
                <input type="text" name="phone" class="form-control" value="<?php echo $phone; ?>">
                <span class="help-block"><?php echo $phone_err; ?></span>
            </div> 
	<div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="submit" class="btn btn-default" value="Cancel" formaction="welcome.php">
            </div>
	</form>
	</div>
	
</body>
</html>