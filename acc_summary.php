<?php 
session_start();
        
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Account Statement</title>
        
        <link rel="stylesheet" href="newcss.css">
        <style>
            .content_customer table,th,td {
    padding:6px;
    border: 1px solid #2E4372;
   border-collapse: collapse;
   text-align: center;
}
.form-group{
	padding-top: 50px;
}

        </style>
    </head>
	
	<body>
	<div class='content_customer'>
    <p><b>Welcome <?php echo $_SESSION['username']?></b></p>  
    <h3 style="text-align:center;color:#2E4372;"><u>Account summary by Date</u></h3>
  
    
            
     <table align="center">
	 
						
                       
						
						
						<?php if(isset($_REQUEST['summary_date'])) {
                         $date1=$_REQUEST['date1'];
                         $date2=$_REQUEST['date2'];
                         
                         require 'config.php';
                         $username=$_SESSION["username"];
						 $ssn = $_SESSION["ssn"];
						 $cancel = False;
						$signindate=date("Y-m-d");
						$totalamount = $totalamountcredit = "";
						
						 $sql = "SELECT sum(amount) as total from SEND_TRANSACTION where S_SSN =? and cancelled =? and DATE_TIME between ? and ?";
						 $sql1 = "SELECT sum(amount) as total from REQUEST_TRANSACTION where R_SSN =? and DATE_TIME between ? and ?";
						
						 if($stmt = mysqli_prepare($link,$sql)){
					mysqli_stmt_bind_param($stmt, "ssss", $ssn,$cancel,$date1,$date2);
					
					if(mysqli_stmt_execute($stmt)){
						mysqli_stmt_store_result($stmt);
						
			   if(mysqli_stmt_num_rows($stmt)>0){
               mysqli_stmt_bind_result($stmt,$totalamount); 
			   mysqli_stmt_fetch($stmt)	;
			
				// echo $totalamount;
				//echo $signindate;
			   
			   
			   }
					
						} }
							 if($stmt1 = mysqli_prepare($link,$sql1)){
					mysqli_stmt_bind_param($stmt1, "sss", $ssn,$date1,$date2);
					
					if(mysqli_stmt_execute($stmt1)){
						mysqli_stmt_store_result($stmt1);
						
			   if(mysqli_stmt_num_rows($stmt1)>0){
               mysqli_stmt_bind_result($stmt1,$totalamountcredit); 
			   mysqli_stmt_fetch($stmt1)	;
			
				
			   
			   }
					
						} }	
						
						}
		
				?>
				<tr>
				<th>Statement Date</th>
				 <th>Amount Credit</th>
                 <th>Amount Debit</th>
				</tr>
				 <tr>
				 <td><?php echo $signindate; ?></td>
				  <td><?php echo $totalamountcredit; ?></td>
				   <td><?php echo $totalamount; ?></td>
				 </tr>
		</table>		
	
    </div>
	<form>
 <div class="form-group"  align="center">
               .
                <input type="submit" class="btn btn-primary" value="Home" formaction="welcome.php">
            </div>
			</form>
	</body>
	</html>