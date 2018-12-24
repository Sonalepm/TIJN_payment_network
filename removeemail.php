<?php

require_once "config.php";
session_start();

$email = $email_err = "";

//enter email you want to delete and then delete.primary email cannot be removed.
$ssn = $bankid = $banumber = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
	
if(empty(trim($_POST["email"]))){
        $email_err = "Please enter email .";     
    } else{
        $email = trim($_POST["email"]);
    }
	
	
if($email <> $_SESSION["username"])
	{
	$sql = "DELETE from electronic_address1 where ea_ssn = ? and identifier = ?";

	if($stmt = mysqli_prepare($link, $sql)){
	
	mysqli_stmt_bind_param($stmt, "ss",$param_ssn,$email);
	
	$param_ssn = $_SESSION["ssn"];
	
	
	
	if(mysqli_stmt_execute($stmt)){
            
               // echo "Success"; 
			   header("location: welcome.php");
				             		
			  }
			  else { echo "Some error occured";
			   }
			   }
}
else{$email_err = "Cannot removed primary email";}
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
	<p>Enter the email to be removed</p>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
	
	<div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div> 
	<div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="submit" class="btn btn-default" value="Cancel" formaction="welcome.php">
            </div>
	</form>
	</div>
	
</body>
</html>