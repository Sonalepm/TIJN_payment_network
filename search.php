<?php 
session_start();
require_once "config.php";  
if(!isset($_SESSION["loggedin"])) 
    header('location:login.php'); 

$date1 = $date2 = "";

if(isset($_REQUEST['summary_date'])) {
                         $date1=$_REQUEST['date1'];
                         $date2=$_REQUEST['date2'];
}
//echo $date1;
//echo $date2;
if(isset($_POST['customer_id']))
							{
								
								echo $_POST['customer_id'];
							}
?>
<!DOCTYPE html>
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
	padding-top:50px;
}

        </style>
        </head>
   
<div class='content_customer'>
            
        
    <div class="customer_top_nav">
             <div class="text">Welcome <?php echo $_SESSION['username']?></div>
            </div>
    
            <?php
require_once "config.php";
$sender_username=$_SESSION["username"];
$sender_id = $identifier = "";

$sql="SELECT * FROM electronic_Address1";
$result=  mysqli_query($link,$sql) or die(mysqli_error($link));
?>
     <br><br><br>
     <h3 style="text-align:center;color:#2E4372;"><u>Account summary by Date</u></h3>
    <form  action = "new_search.php" method="POST">
    <table align="center">
        <tr><td>Start Date [mm/dd/yyyy] </td><td>
        <input type="date" name="date1" required></td></tr>
        
        <tr><td>End Date [mm/dd/yyyy] </td><td>
        <input type="date" name="date2" required></td></tr>
        </table>
                        <table align="center">
                        <h3 style="text-align:center;color:#2E4372;"><u>Search by account</u></h3>
                        <th>Select</th>
						<th>Id</th>
                        <th>Identifier</th>
						<th>Type</th>
                        
                        
                        
                        <?php
						$identifier = $date1 = $date2 = "";
                        while($rws=  mysqli_fetch_array($result)){
                            
                            echo "<tr><td><input type='radio' name='customer_id' value=".$rws[1];
                            echo ' checked';
                            echo " /></td>";
                            echo "<td>".$rws[0]."</td>";
                            echo "<td>".$rws[1]."</td>";
                            echo "<td>".$rws[3]."</td>";
                           
                            echo "</tr>";
							
                        }
						if(isset($_POST['customer_id']))
							{
								
								echo $_POST['customer_id'];
							}
					
					
                         ?>
						
</table>

    <div class = "form-group" align="center"><tr><td><input type="submit" name="summary_date" value="GO" class='addstaff_button'/></td></tr></div>
    </form>
</div>
</html>
      