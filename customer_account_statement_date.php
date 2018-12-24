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

        </style>
    </head>
	<body>
        <?php include 'header.php' ?>
<div class='content_customer'>

         
    <p><b>Welcome <?php echo $_SESSION['username'] ;  ?></b></p>
    


    
    <h3 style="text-align:center;color:#2E4372;"><u>Account summary by Date</u></h3>
  
    
            
    <table align="center">
                        
                        <th>Id</th>
                        <th>Transaction Date</th>
                        <th>Narration</th>
                        <th>Amount</th>
                        <th>Receiver</th>
                        
                        
                        <?php if(isset($_REQUEST['summary_date'])) {
                         $date1=$_REQUEST['date1'];
                         $date2=$_REQUEST['date2'];
                         
                         include 'config.php';
                         $username=$_SESSION["username"];
                         $sql="SELECT * FROM send_transaction WHERE transactiondate BETWEEN '$date1' AND '$date2' and identifier =".$_SESSION['account'];
                         $result=  mysql_query($sql) or die(mysql_error());
                        while($rws=  mysql_fetch_array($result)){
                            
                            echo "<tr>";
                            echo "<td>".$rws[0]."</td>";
                            echo "<td>".$rws[2]."</td>";
                            echo "<td>".$rws[3]."</td>";
                            echo "<td>".$rws[1]."</td>";
                            echo "<td>".$rws[6]."</td>";
                           
                           
                            echo "</tr>";
                        }
                        } ?>
</table>
    </div>
       
	</div>
	</body>
		</html>