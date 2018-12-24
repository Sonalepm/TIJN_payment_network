<?php
// Initialize the session
session_start();
require_once "config.php";
//amount is split equally.


$amount = $email1 = $email2 = $email3 = $email4 = $percent1 = $memo = $percent2 = $percent3 = $percent4 ="";
$amount_err = $email1_err = $email2_err= $email3_err = $email4_err = $percent1_err = $percent2_err = $percent3_err = $percent4_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
 
 // Validate amount entered
 
 if((empty(trim($_POST["amount"])))|| ($_POST["amount"] < 0)){
	 
	    $amount_err = "Please enter a valid amount .";     
    }  else{
			
        $amount = trim($_POST["amount"]);
    }
 
 if(empty(trim($_POST["email1"]))){
	 
	    $email1_err = "Please enter email id to request money";     
    }  else{
			
        $email1 = trim($_POST["email1"]);
    }
 
 if(empty(trim($_POST["percent1"]))|| (trim($_POST["percent1"])>100)){
	 
	    $percent1_err = "Please enter share in percentage";     
    }  else{
			
        $percent1 = trim($_POST["percent1"]);
    }
	
 $email2 = trim($_POST["email2"]);
 $email3 = trim($_POST["email3"]);
 $email4 = trim($_POST["email4"]);
 $memo = trim($_POST["memo"]);
 $percent2 = trim($_POST["percent2"]);
 $percent3 = trim($_POST["percent3"]);
 $percent4 = trim($_POST["percent4"]);
 
 
 
	
	 
	 $param_ssn = $_SESSION["ssn"];
	 $_SESSION["amount"] =$amount;
	 
 if(empty($amount_err) && empty($email1_err) && empty($percent1_err))
 {
	 $sql = "INSERT INTO REQUEST_TRANSACTION(AMOUNT,MEMO,R_SSN,Identifier) values (?,?,?,?)";
	 $sql1 = "INSERT INTO FROM_USER(RT_id,E_IDENTIFIER,PERCENTAGE) values (?,?,?)";
	 $sql2 = "SELECT RTID from REQUEST_TRANSACTION where R_SSN = ? order by RTID desc limit 1";
	 $sql3 = "SELECT identifier from electronic_Address1 where identifier = ? ";
	 
	 
	 
 $param_cancel = False;
 $param_ssn = $_SESSION["ssn"];
 $param_email = $_SESSION["username"];
 $param_id = $_SESSION["id"];
	//echo $_SESSION["id"];
	
	
	if($stmt = mysqli_prepare($link,$sql)){
		//echo "Reached here2";
					mysqli_stmt_bind_param($stmt, "ssss",$amount,$memo,$param_ssn,$param_email);
					
					if(mysqli_stmt_execute($stmt)){
						
						//echo "Reached here3";
						
						
						if($stmt2 = mysqli_prepare($link,$sql2)){
							//echo "Reached here4";
							mysqli_stmt_bind_param($stmt2, "s",$param_ssn);
							if(mysqli_stmt_execute($stmt2)){
						
						//echo "Reached here3";
						mysqli_stmt_store_result($stmt2);
								if(mysqli_stmt_num_rows($stmt2) == 1){
								//	echo "Reached here4";
								mysqli_stmt_bind_result($stmt2,$rtid);
								mysqli_stmt_fetch($stmt2);
							}}
						
							
						}
						
			   		}
						
				}
	
	 
	 //enter the values in from_user
	 if($stmt3 = mysqli_prepare($link,$sql3)){
		
					mysqli_stmt_bind_param($stmt3, "s",$email1);
					
					if(mysqli_stmt_execute($stmt3)){
						mysqli_stmt_store_result($stmt3);
						if(mysqli_stmt_num_rows($stmt3) == 1){
							
							if($stmt1 = mysqli_prepare($link,$sql1)){
		//echo "Reached here2";
					mysqli_stmt_bind_param($stmt1, "sss",$rtid,$email1,$percent1);
					//echo "email present";
					if(mysqli_stmt_execute($stmt1)){
						//	echo "Done";
	 }}}}}
						
						
	 
	 
 }
 //echo $rtid;
	if(empty($amount_err) && !empty($email2) && !empty($percent2))
 {
	 if($stmt3 = mysqli_prepare($link,$sql3)){
		
					mysqli_stmt_bind_param($stmt3, "s",$email2);
					
					if(mysqli_stmt_execute($stmt3)){
						mysqli_stmt_store_result($stmt3);
						if(mysqli_stmt_num_rows($stmt3) == 1){
							
							if($stmt1 = mysqli_prepare($link,$sql1)){
		//echo "\n\nReached here2";
					mysqli_stmt_bind_param($stmt1, "sss",$rtid,$email2,$percent2);
				//	echo "email present";
					if(mysqli_stmt_execute($stmt1)){
				//			echo "Done";
	 }}}else {echo "Not present";}
	 }}
 }
 if(empty($amount_err) && !empty($email3) && !empty($percent3))
 {
	 if($stmt3 = mysqli_prepare($link,$sql3)){
		
					mysqli_stmt_bind_param($stmt3, "s",$email3);
					
					if(mysqli_stmt_execute($stmt3)){
						mysqli_stmt_store_result($stmt3);
						if(mysqli_stmt_num_rows($stmt3) == 1){
							
							if($stmt1 = mysqli_prepare($link,$sql1)){
	//	echo "\n\nReached here2";
					mysqli_stmt_bind_param($stmt1, "sss",$rtid,$email3,$percent3);
					//echo "email present";
					if(mysqli_stmt_execute($stmt1)){
						//	echo "Done";
	 }}}else {echo "Not present";}
	 }}
 }
 if(empty($amount_err) && !empty($email4) && !empty($percent4))
 {
	 if($stmt3 = mysqli_prepare($link,$sql3)){
		
					mysqli_stmt_bind_param($stmt3, "s",$email4);
					
					if(mysqli_stmt_execute($stmt3)){
						mysqli_stmt_store_result($stmt3);
						if(mysqli_stmt_num_rows($stmt3) == 1){
							
							if($stmt1 = mysqli_prepare($link,$sql1)){
		//echo "\n\nReached here2";
					mysqli_stmt_bind_param($stmt1, "sss",$rtid,$email4,$percent4);
					//echo "email present";
					if(mysqli_stmt_execute($stmt1)){
				//			echo "Done";
	 }}}else {echo "Not present";}
	 }}
 }
 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Send Money</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 2500px; padding: 20px; text-align: center;}
		
		form { 
	margin-left: 400px; 
	width:1000px;
	
	}
	

h2{
	text-align:center;
	margin-bottom : 150px;
}
    </style>
	

</head>
<body>
<div class="container">
  <h2>Request Money </h2>
 
  <form role="form" class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
  
    <div class="form-group">
      <label class="col-sm-1" for="amount">Amount</label>
      <div class="col-sm-2"><input type="text" class="form-control" name="amount" ><span class="help-block"><?php echo $amount_err;?></span></div>
    </div>
	
    <div class="form-group">
      <label class="col-sm-12" for="TextArea">Memo</label>
      <div class="col-sm-5"><textarea class="form-control" name="memo"></textarea></div>
    </div>
	
    <div class="form-group">
		
      <div class="col-sm-3"><label>Email ID<input type="text" name="email1" class="form-control" value="<?php echo $email1; ?>"></label><span class="help-block"><?php echo $email1_err;?></span></div>
	  
      <div class="col-sm-2"><label>Percent</label><input type="text" name="percent1" class="form-control" value="<?php echo $percent1; ?>"><span class="help-block"><?php echo $percent1_err;?></span></div>
	  
    </div>
	
    <div class="form-group">
     	
      <div class="col-sm-3"><label>Email ID<input type="text" name="email2" class="form-control" value="<?php echo $email2; ?>"></label><span class="help-block"><?php echo $email2_err;?></span></div>
	  
      <div class="col-sm-2"><label>Percent</label><input type="text" name="percent2" class="form-control" value="<?php echo $percent2; ?>"><span class="help-block"><?php echo $percent2_err;?></span></div>
	  
    </div>
    <div class="form-group">
     	
      <div class="col-sm-3"><label>Email ID<input type="text" name="email3" class="form-control" value="<?php echo $email3; ?>"></label><span class="help-block"><?php echo $email3_err;?></span></div>
	  
      <div class="col-sm-2"><label>Percent</label><input type="text" name="percent3" class="form-control" value="<?php echo $percent3; ?>"><span class="help-block"><?php echo $percent3_err;?></span></div>
	  
    </div>
   <div class="form-group">
     	
      <div class="col-sm-3"><label>Email ID<input type="text" name="email4" class="form-control" value="<?php echo $email4; ?>"></label><span class="help-block"><?php echo $email4_err;?></span></div>
	  
      <div class="col-sm-2"><label>Percent</label><input type="text" name="percent4" class="form-control" value="<?php echo $percent4; ?>"><span class="help-block"><?php echo $percent4_err;?></span></div>
	  
    </div>
    <div class="form-group">
      <div class="col-sm-2">
        <button type="submit" class="btn btn-info pull-right">Submit</button>
      </div>
      <div class="col-sm-2">
        <button type="submit" class="btn btn-info pull-left" formaction="welcome.php">Go Home</button>
      </div>
    </div>
  </form>
  <hr>
</div>
</body>
</html>