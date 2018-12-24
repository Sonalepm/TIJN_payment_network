<?php
// Initialize the session
session_start();
//echo $_SESSION["phone"];
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}


?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        
* {box-sizing: border-box;}

body { 
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
  text-align: center;
}

.header {
  overflow: hidden;
  background-color: #f1f1f1;
  padding: 20px 10px;
}

.header a {
  float: left;
  color: Black;
  text-align: center;
  padding: 12px;
  text-decoration: none;
  font-size: 14px; 
  line-height: 25px;
  border-radius: 4px;
}

.header a.logo {
  font-size: 30px;
  font-weight: bold;
  color: Blue;
}

.header a:hover {
  background-color: #ddd;
  color: black;
}

.header-right {
  float: right;
  }

@media screen and (max-width: 1000px) {
  .header a {
    float: none;
    display: block;
    text-align: left;
  }
  .header-right {
    float: none;

  }
}
  h4 {
	 font: 10px	
   color:red;
   margin-top:50px;
  margin-bottom:10px;
}
.mid{
	margin-top:50px;
  margin-bottom:10px;
	padding-top : 50px;
	padding-bottom : 100px;
}
    </style>
</head>


<body>
    <div class="header">
       <a href="#default" class="logo">TIJN Payment Network</a>
	   <div class="header-right">
			<a href="#home">Home</a>
			<a href="account_details.php">Account Details</a>
			<a href="account_statement.php">Account Statement</a>
			<a href="addtowallet.php">TIJN Wallet</a>
			<a href="search.php">Search</a>
			<a href="logout.php">Sign Out</a>
	   </div>
    </div>
	<div class = "mid" >
	<p> <h4>Verify Details
		<a href="phone_verification.php" class="btn btn-warning">Phone</a>
		<a href="email_verification.php" class="btn btn-warning">Email</a>
        <a href="bank_verification.php" class="btn btn-warning">Bank Details</a>
		</h4>
	</p> 	
	</div>
	<div>
    <p>
        <a href="sendmoney.php" class="btn btn-warning">Send Money</a>
		<a href="requestmoney.php" class="btn btn-warning">Request Money</a>
		<a href="transfertobank.php" class="btn btn-warning">Transfer to Bank</a>
	</p>
	</div>
</body>
</html>