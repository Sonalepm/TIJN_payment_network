<?php
//working for send to TIJN user.Non user - just need to update the send transaction.
require_once "config.php";
session_start();

// Define variables and initialize with empty values
$touser = $amount = $memo = $balance =$PA_Balance = "";
$touser_err = $amount_err = $memo_err ="";

//echo $_SESSION["id"];

$signupweek=date("Y-m-d");
//echo "current day is ".$signupweek."<br>";
/*start day*/
    for($i = 0; $i <7 ; $i++)
    {
     $startdate = date('Y-m-d', strtotime("-".$i."days", strtotime($signupweek)));
     $dayName = date('D', strtotime($startdate));
     if($dayName == "Sun")
     {
     // echo "start day is ". $startdate."<br>";
	  $param_startdate = $startdate;
     }
    }
/*end day*/
 for($i = 0; $i <7 ; $i++)
    {
     $enddate = date('Y-m-d', strtotime("+".$i."days", strtotime($signupweek)));
     $dayName = date('D', strtotime($enddate));
     if($dayName == "Sat")
     {
     // echo "end day is ". $enddate."<br>";
	  $param_enddate = $enddate;
     }
 }
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
	
	// Validate recipients email 
	if(empty(trim($_POST["touser"]))){
        $touser_err = "Please enter Recipient's email .";     
    } else{
        $touser = trim($_POST["touser"]);
    }
	
	// Validate entered amount
	if(empty(trim($_POST["amount"])) || (trim($_POST["amount"])<= 0)){
        $amount_err = "Please enter a valid amount.";     
    } else{
			$amount = trim($_POST["amount"]);
		}
		
	// Check input errors before inserting in database
    if(empty($touser_err) && empty($amount_err)) {/////edit from here 
		
	}
    
	
	// Set parameters
	
	$param_touser = $touser;
	$param_amount = $amount;
	$param_memo   = $memo;
	
	//sql statements
	
	$sql = "SELECT balance,PA_Balance,PBAVerified FROM user_account WHERE ssn = ? ";
	$sql1 = "SELECT EA_SSN from electronic_address1 where identifier = ?";
	$sql2 = "UPDATE user_account set PA_Balance = PA_Balance - ?  where ssn = ? " ;
	$sql3 = "UPDATE user_account set balance = balance - ?  where ssn = ? " ;
	$sql4 = "UPDATE user_account set balance = balance + ? where ssn = ? ";
	$sql5 = "INSERT INTO SEND_TRANSACTION(AMOUNT,MEMO,CANCELLED,S_SSN,Identifier) values (?,?,?,?,?)";
	$sql6 = "SELECT SUM(Amount) as totalamount from SEND_TRANSACTION where S_SSN = ? and cancelled = ? and DATE_TIME between ? and ?";
	
	
 
 
						   $param_ssn = $_SESSION["ssn"];
						   $param_balance = $balance;
						   $param_pabalance = $PA_Balance;
						   $param_type1 = "email";
						   $param_type2 = "phone";
						   $param_cancel = False;
						   $_SESSION["amount"] =$amount;
 
				if($stmt6 = mysqli_prepare($link,$sql6)){
					mysqli_stmt_bind_param($stmt6, "ssss", $param_ssn,$param_cancel,$param_startdate,$param_enddate);
					
					if(mysqli_stmt_execute($stmt6)){
						mysqli_stmt_store_result($stmt6);
						//echo "Reached here";
			   if(mysqli_stmt_num_rows($stmt6)>0){
               mysqli_stmt_bind_result($stmt6,$totalamount); 
			   mysqli_stmt_fetch($stmt6);	
				//get total of week ;
			   
			   //echo $totalamount;
			   }
					}
						
				}
			   
			//echo $totalamount+$amount;
			
			if($stmt1 = mysqli_prepare($link,$sql1)){
					mysqli_stmt_bind_param($stmt1, "s", $touser);
					
					if(mysqli_stmt_execute($stmt1)){
						mysqli_stmt_store_result($stmt1);
						//echo "Reached here";
			   if(mysqli_stmt_num_rows($stmt1)>0){
               mysqli_stmt_bind_result($stmt1,$touserssn); 
			   mysqli_stmt_fetch($stmt1);	
				//get total of week ;
			   
			   //echo $touserssn;
			   
				
	
	////////////////////////////				
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
						if($amount >= 299.99)
								{
									$amount_err = "You have exceeded one time transfer limit";
									
								}
						else if($amount <= $balance){
							if( $totalamount+$amount <= 299.99){
									if($stmt5 = mysqli_prepare($link,$sql5))
								{
									mysqli_stmt_bind_param($stmt5, "sssss",$amount,$param_memo,$param_cancel,$param_ssn,$touser);
									if(mysqli_stmt_execute($stmt5)){
									if($stmt3 = mysqli_prepare($link,$sql3))
								{
									mysqli_stmt_bind_param($stmt3,"ss",$amount,$param_ssn);
									if(mysqli_stmt_execute($stmt3)){
										//echo "Reached here 3" ;
										header("location: transferunderprocess.php");
										
										
								}
								}
								if($stmt4 = mysqli_prepare($link,$sql4))
								{
									mysqli_stmt_bind_param($stmt4,"ss",$amount,$touserssn);
									if(mysqli_stmt_execute($stmt4)){
									//	echo "Reached here 4" ;
										header("location: transferunderprocess.php");
										
										
								}
								}
								}					
								}	
								} else {$amount_err = "You have exceeded weekly transfer limit";}
							}
							else {
								//reduce from primary bank.
								if( $totalamount+$amount <= 299.99){
									if($stmt5 = mysqli_prepare($link,$sql5))
								{
									mysqli_stmt_bind_param($stmt5, "sssss",$amount,$param_memo,$param_cancel,$param_ssn,$touser);
									if(mysqli_stmt_execute($stmt5)){
										if($stmt2 = mysqli_prepare($link,$sql2))
								{     echo "Reached here";
							
									mysqli_stmt_bind_param($stmt2,"ss",$amount,$param_ssn);
									if(mysqli_stmt_execute($stmt2)){
										echo "Reached here 2" ;
										header("location: transferunderprocess.php");
										
										
								}
								}
									if($stmt4 = mysqli_prepare($link,$sql4))
								{
									mysqli_stmt_bind_param($stmt4,"ss",$amount,$touserssn);
									if(mysqli_stmt_execute($stmt4)){
										echo "Reached here 4_1" ;
										header("location: transferunderprocess.php");
										
										
								}
								}	
									}
									
								}
								
							}else { $amount_err = "You have exceeded weekly transfer limit";}
								
						}
						
						
			
 	}
 }
}
}

 

 }
}else { echo "User not registered in TIJN";
//only insert to send transacion and set cal true if 15 days limit is over;
if( $totalamount+$amount <= 299.99){
									if($stmt5 = mysqli_prepare($link,$sql5))
								{
									mysqli_stmt_bind_param($stmt5, "sssss",$amount,$param_memo,$param_cancel,$param_ssn,$touser);
									if(mysqli_stmt_execute($stmt5)){ echo "Done";}
								}
}
else {$amount_err = "You have exceeded weekly transfer limit";}
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
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Send Money</h2>
        <p>Please fill the details to send money.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
		
            <div class="form-group <?php echo (!empty($touser_err)) ? 'has-error' : ''; ?>">
                <label>Recipient's Email</label>
                <input type="text" name="touser" class="form-control" value="<?php echo $touser; ?>">
                <span class="help-block"><?php echo $touser_err; ?></span>
            </div>    
			
			
            <div class="form-group <?php echo (!empty($amount_err)) ? 'has-error' : ''; ?>">
                <label>Amount</label>
                <input type="text" name="amount" class="form-control" value="<?php echo $amount; ?>">
                <span class="help-block"><?php echo $amount_err; ?></span>
            </div> 
            
            <div class="form-group ">
                <label>Memo</label>
                <input type="text" name="memo" class="form-control" value="<?php echo $memo; ?>">
               
            </div> 
            
                       
            
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit" >
                <input type="submit" class="btn btn-default" value="Cancel" formaction = "welcome.php">
            </div>
            
            
            <p></p>
        </form>
    </div>    
</body>
</html>