<?php
// Include config file
require_once "config.php";
// Initialize the session
session_start();

//initialize variables.
$balance = $PA_Balance = $lastdatetime = "";
$ok = "OK";
//echo $_SESSION["amount"];

if($_SERVER["REQUEST_METHOD"] == "POST"){
	
	
	
$sql = "UPDATE SEND_TRANSACTION set cancelled = ? where s_ssn = ? and Date_Time = ? ";
$sql1 = "UPDATE user_account set balance = balance + ? , PA_balance = PA_Balance - ? where ssn = ?"; 
$sql0 = "SELECT MAX(Date_Time) FROM send_transaction where s_ssn = ?";

 $param_cancel = True;
 $param_ssn = $_SESSION["ssn"];
 $param_balance = $balance;
 $param_pabalance = $PA_Balance;

 //echo $param_ssn;
 
 if($stmt0 = mysqli_prepare($link,$sql0))
 {
	
      	mysqli_stmt_bind_param($stmt0,"s",$param_ssn);
      		
      	if(mysqli_stmt_execute($stmt0)){
			 mysqli_stmt_store_result($stmt0);
			   
			   if(mysqli_stmt_num_rows($stmt0) == 1){
               mysqli_stmt_bind_result($stmt0,$lastdatetime); 
			   
			   if(mysqli_stmt_fetch($stmt0)){
		if($stmt = mysqli_prepare($link,$sql))
      {
	      	
      	mysqli_stmt_bind_param($stmt, "sss",$param_cancel,$param_ssn,$lastdatetime);
      		
      	if(mysqli_stmt_execute($stmt)){
      	
      		echo "Reached here ";
			
      	if($stmt1 = mysqli_prepare($link,$sql1))
      {
      	
      	mysqli_stmt_bind_param($stmt1,"sss",$_SESSION["amount"],$_SESSION["amount"],$param_ssn);
      	if(mysqli_stmt_execute($stmt1)){
      		  
			 header("location: welcome.php");
      }
      }
      }	
			   }}
	  }							}	
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
		
        <h3>Transaction Cancelled !!</h3>
	
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			   
            
            <div class="form-group">
                <input type="submit" class="btn btn-primary" class="form-control" value="<?php echo $ok; ?>">
				
              
            </div>
           
        </form>
	
	</div>
</body>
</html>