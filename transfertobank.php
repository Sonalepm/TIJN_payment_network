<?php
// Include config file
require_once "config.php";

// Initialize the session
session_start();

//money will be sent to primary bank account.
//initialize variables.

$amount = $balance = $PA_Balance = $Everified = "";
$amount_err = $bverification_err = $Everification_err = $Pverification_err = "";

//echo $_SESSION["id"];
//echo $_SESSION["username"];
//echo $_SESSION["ssn"];
$signupweek=date("Y-m-d");
//echo "current day is ".$signupweek."<br>";
/*start day*/
    for($i = 0; $i <7 ; $i++)
    {
     $date = date('Y-m-d', strtotime("-".$i."days", strtotime($signupweek)));
     $dayName = date('D', strtotime($date));
     if($dayName == "Sun")
     {
       //echo "start day is ". $date."<br>";
     }
    }
/*end day*/
 for($i = 0; $i <7 ; $i++)
    {
     $date = date('Y-m-d', strtotime("+".$i."days", strtotime($signupweek)));
     $dayName = date('D', strtotime($date));
     if($dayName == "Sat")
     {
      // echo "end day is ". $date."<br>";
     }
 }
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
	
	$sql1 = "SELECT verified from electronic_Address1 where ea_ssn = ? and type = ?"; //email
	$sql2 = "SELECT verified from electronic_Address1 where ea_ssn = ? and type = ?"; //phone
	$sql3 = "UPDATE user_account set balance = balance - ? , PA_balance = PA_Balance + ? where ssn = ? and ? < 9999.99";
	$sql4 = "UPDATE user_account set balance = balance - ? , PA_balance = PA_Balance + ? where ssn = ? and ? < 499.99";
	$sql5 = "INSERT INTO SEND_TRANSACTION(AMOUNT,MEMO,CANCELLED,S_SSN,Identifier) values (?,?,?,?,?)";
	
					
	if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_ssn);
                           
						   $param_ssn = $_SESSION["ssn"];
						   $param_balance = $balance;
						   $param_pabalance = $PA_Balance;
						   $param_type1 = "email";
						   $param_type2 = "phone";
						   $param_memo = "Transfer to Bank";
						   $param_cancel = False;
						   $_SESSION["amount"] =$amount;
						   
						   
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
            
                 /* store result */
               mysqli_stmt_store_result($stmt);
			   
			   if(mysqli_stmt_num_rows($stmt) == 1){
               mysqli_stmt_bind_result($stmt,$balance,$PA_Balance,$PBAverified); 
			   if(mysqli_stmt_fetch($stmt)){
				   
				   if($PBAverified == 0)
				   {
                      $amount_err = "Please verify your bank account before making any transaction !!";
						
				   }
					else {
						//bank verified.
						if($stmt1 = mysqli_prepare($link,$sql1))
						{
							//check if email is verified
							mysqli_stmt_bind_param($stmt1,"ss",$param_ssn,$param_type1);
							if(mysqli_stmt_execute($stmt1)){
								mysqli_stmt_store_result($stmt1);
								if(mysqli_stmt_num_rows($stmt1) == 1){
								mysqli_stmt_bind_result($stmt1,$Everified);
								if(mysqli_stmt_fetch($stmt1));
								if($Everified == 0)
								{
									 //bank is verified. but email is not verified.
									// 999.99  per week . 499.99  one time 
								
								if($amount > 499.99)
								{
									$amount_err = "You have exceeded one time transfer limit";
									
								}
								elseif ( $amount <= $balance ) {
									
									if($stmt5 = mysqli_prepare($link,$sql5))
								{
									mysqli_stmt_bind_param($stmt5, "sssss",$amount,$param_memo,$param_cancel,$param_ssn,$_SESSION["username"]);
									if(mysqli_stmt_execute($stmt5)){
									if($stmt4 = mysqli_prepare($link,$sql4))
								{
									mysqli_stmt_bind_param($stmt4,"ssss",$amount,$amount,$param_ssn,$amount);
									if(mysqli_stmt_execute($stmt4)){
										//echo "Reached here " ;
										header("location: transferunderprocess.php");
										
										
								}
								}
								}					
								}	
								}
								else { 
								$amount_err = "Insufficient Balance";
								}
				
				
								}
								
								else 
								{
									
								if($stmt2 = mysqli_prepare($link,$sql2))
								{
							//check if phone is verified
							mysqli_stmt_bind_param($stmt2, "ss", $param_ssn,$param_type2);
							if(mysqli_stmt_execute($stmt2)){
								mysqli_stmt_store_result($stmt2);
								if(mysqli_stmt_num_rows($stmt2) == 1){
								mysqli_stmt_bind_result($stmt2,$Pverified);
								if(mysqli_stmt_fetch($stmt2));
								if($Pverified == 0)
								{
									 //bank is verified. but phone is not verified.
									// 999.99  per week . 499.99  one time 
								
								if($amount > 499.99)
								{
									$amount_err = "You have exceeded one time transfer limit";
									
								}
								elseif ( $amount <= $balance ) {
									
									if($stmt5 = mysqli_prepare($link,$sql5))
								{
									
									mysqli_stmt_bind_param($stmt5, "sssss",$amount,$param_memo,$param_cancel,$param_ssn,$_SESSION["username"]);
										
									if(mysqli_stmt_execute($stmt5)){
									
										
									if($stmt4 = mysqli_prepare($link,$sql4))
								{
									
									mysqli_stmt_bind_param($stmt4,"ssss",$amount,$amount,$param_ssn,$amount);
									if(mysqli_stmt_execute($stmt4)){
										
										header("location: transferunderprocess.php");
										
										
								}
								}
								}	
							
								}	
								}
								else { 
								$amount_err = "Insufficient Balance";
								}
				
								}
								else { 
								//Both email and phone verified.
								// 19,999.99  per week . 9999.99  one time 
								
								if($amount > 9999.99)
								{
									$amount_err = "You have exceeded one time transfer limit";
									
								}
								elseif ( $amount <= $balance) {
									
									if($stmt5 = mysqli_prepare($link,$sql5))
								{
									mysqli_stmt_bind_param($stmt5, "sssss",$amount,$param_memo,$param_cancel,$param_ssn,$_SESSION["username"]);
									if(mysqli_stmt_execute($stmt5)){
									if($stmt3 = mysqli_prepare($link,$sql3))
								{
									mysqli_stmt_bind_param($stmt3,"ssss",$amount,$amount,$param_ssn,$amount);
									if(mysqli_stmt_execute($stmt3)){
										echo "Reached here " ;
										header("location: transferunderprocess.php");
										
										
								}
								}
								}					
								}	
								}
								else { 
								$amount_err = "Insufficient Balance";
								}
								}
								}
							}
							}
						}
						}
			}
			}
			
 	}
 }
}
}
}
 }
 
 mysqli_close($link);
 }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Send Money</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 1500px; padding: 20px; text-align: center;}
		form { 
	margin: 0 auto; 
	width:300px;
	}
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Send Money to Bank Account</h2>
        <p>Please fill the details to send money.</p>
		
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			
            <div class="form-group <?php echo (!empty($amount_err)) ? 'has-error' : ''; ?>">
                <label>Amount</label>
                <input type="text" name="amount" class="form-control" value="<?php echo $amount; ?>">
                <span class="help-block"><?php echo $amount_err;  ?><?php echo $Everification_err;  ?></span>
            </div> 
                       
            
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
				.
                <input type="submit" class="btn btn-primary" value="Cancel" formaction="welcome.php">
            </div>
            
            
            <p></p>
        </form>
    </div>    
</body>
</html>