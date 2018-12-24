<?php 
session_start();

if(!isset($_SESSION["loggedin"])) 
    header('location:login.php'); 
//echo $_SESSION['account'];
$date1 = $date2 = "";

if(isset($_REQUEST['summary_date'])) {
                         $date1=$_REQUEST['date1'];
                         $date2=$_REQUEST['date2'];					 
						 }


?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Display Beneficiary</title>
        
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
   
<div class='content_customer'>
            
        
    <div class="customer_top_nav">
             <div class="text">Welcome <?php echo $_SESSION['username']?></div>
    </div>
	
	 <h3 style="text-align:center;color:#2E4372;"><u>Transaction Summary</u></h3>
      <table align="center">
	  
	  <tr>
						<th>Id</th>
                        <th>Amount</th>
                        <th>Memo</th>
                        <th>Recipient</th>
                        <th>Date of Transaction</th>
                        </tr>	
						
	  <?php if(isset($_REQUEST['summary_date'])) {
                         $date1=$_REQUEST['date1'];
                         $date2=$_REQUEST['date2'];
                         
                         require 'config.php';
                         $username=$_SESSION["username"];
						 $ssn = $_SESSION["ssn"];
						 $recipient = "";
						 $cancel = False;
						 		//echo $date1;
								//	echo $date2;
						if(isset($_POST['customer_id']))
							{
								
								$recipient = $_POST['customer_id'];
							}	

//echo $recipient;	
//echo $ssn;						
						  $sql = "SELECT STid,memo,AMOUNT,IDENTIFIER,DATE_TIME  from SEND_TRANSACTION where S_SSN =? and cancelled =? and identifier = ?  and DATE_TIME between ? and ?";
						    
							if($stmt = mysqli_prepare($link,$sql)){
								
					mysqli_stmt_bind_param($stmt, "sssss", $ssn,$cancel,$recipient,$date1,$date2);
					//echo "Reached here";
					if(mysqli_stmt_execute($stmt)){
						
						mysqli_stmt_store_result($stmt);
									   
			   if(mysqli_stmt_num_rows($stmt)>0){
             
			   mysqli_stmt_bind_result($stmt, $stid,$memo,$amount,$touser,$datetime);
			  while (mysqli_stmt_fetch($stmt)) {
			//echo "Here";
							echo "<tr>";
                            echo "<td>".$stid."</td>";
                            echo "<td>".$memo."</td>";
                            echo "<td>".$amount."</td>";
                            echo "<td>".$touser."</td>";
                            echo "<td>".$datetime."</td>";
                            echo "</tr>";
    }
				                              
			   
			   }
					
						} }          

		mysqli_stmt_close($stmt);

  $sql1 = "SELECT r.RTid,r.memo,r.AMOUNT,f.E_IDENTIFIER,r.DATE_TIME  from REQUEST_TRANSACTION r,from_user f where r.R_SSN =? and r.rtid = f.rt_if and f.e_identifier = ?  and r.DATE_TIME between ? and ?";
						    
							if($stmt1 = mysqli_prepare($link,$sql1)){
								
					mysqli_stmt_bind_param($stmt1, "ssss", $ssn,$recipient,$date1,$date2);
					//echo "Reached here";
					if(mysqli_stmt_execute($stmt1)){
						
						mysqli_stmt_store_result($stmt1);
									   
			   if(mysqli_stmt_num_rows($stmt1)>0){
             
			   mysqli_stmt_bind_result($stmt1, $stid,$memo,$amount,$touser,$datetime);
			  while (mysqli_stmt_fetch($stmt1)) {
			//echo "Here";
							echo "<tr>";
                            echo "<td>".$stid."</td>";
                            echo "<td>".$memo."</td>";
                            echo "<td>".$amount."</td>";
                            echo "<td>".$touser."</td>";
                            echo "<td>".$datetime."</td>";
                            echo "</tr>";
							break;
    }
				                              
			   
			   }
					
						} } 

						
	  }		?>	  
	  </table>
          
</div>
<form>
 <div class="form-group"  align="center">
               .
                <input type="submit" class="btn btn-primary" value="Home" formaction="welcome.php">
            </div>
			</form>
</html>