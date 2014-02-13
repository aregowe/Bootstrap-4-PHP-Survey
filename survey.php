<?php
//connection file
include 'dbcon.php';

//start session
session_start();

//tables
$tableH="ZSURVEY";  	//Main survey table
$tableQ="ZSURVEYQ"; 	//Survey questions table
$tableA="ZSURVEYA"; 	//Survey answers table
$tableE="ZSURVEYE"; 	//Survey extras / options table
$maxquestions=13;
//connection to the database
$dbhandle = mssql_connect($myServer, $myUser, $myPass)
  or die("Couldn't connect to SQL Server"); 

//select a database to work with
$selected = mssql_select_db($myDB, $dbhandle)
  or die("Couldn't open database"); 

//pull variables from URL
$survid=$_GET["id"];		//Survey ID Variable
$email=$_GET["email"];		//Email variable
$site=$_GET["site"];		//Site name variable
unset($_SESSION['surnum']);
unset($_SESSION['email']);
unset($_SESSION['site']);
$_SESSION['surnum']=$survid;
$_SESSION['email']=$email;
$_SESSION['site']=$site;
//declare the SQL statement that will query the database
$queryH = "SELECT SURNUM_0,SURNAM_0,ACTIVE_0 FROM $tableH WHERE SURNUM_0 =$survid";
$resultH = mssql_query($queryH);
$RowH = mssql_fetch_assoc($resultH);

//Begin HTML using Bootstrap v3
print("<!DOCTYPE html>
	<html lang='en'>
		<head>
			<meta charset='utf-8'>
			<meta name='viewport' content='width=device-width, initial-scale=1.0'>
			<title>A.M. Leonard | ".$RowH['SURNAM_0']."</title>
			<link rel='icon' type='image/x-icon' href='favicon.ico'>
			<link rel='shortcut icon' href='favicon.ico' type='image/x-icon'/>
			<!-- Bootstrap core CSS -->
			<link href='dist/css/bootstrap.css' rel='stylesheet'>
			<!-- Custom styles for this template -->
			<link href='starter-template.css' rel='stylesheet'>
			<!-- Le HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
			<!--[if lt IE 9]>
			  <script src='assets/js/html5shiv.js'></script>
			  <script src='assets/js/respond.min.js'></script>
			<![endif]-->
			<style type='text/css'>
			body {
				background-color: #EEEEEE;
				background-repeat: no-repeat;
			}
			form input[type=submit] {
				background : url('surveysubmit.png') no-repeat center center;
				width : 115px;
				height :52px;
				border : none;
				color : transparent;
				font-size : 0
			}
			.formfield * {
				vertical-align: middle;
			}
			form input[type=reset] {
			  background : url('cancelbutton.png') no-repeat center center;
			  cursor: pointer;
			  width : 115px;
			  height :52px;
			  border : none;
			  color : transparent;
			  font-size : 0
			}
			</style>
		</head>
	<body>
	<form action='submit.php' method=post>
	<div class='navbar navbar-inverse navbar-fixed-top'>
		<div class='container' align='center'>
			<div class='navbar-header' style='margin-right:26px;'>
			  <a class='navbar-brand'>".$RowH['SURNAM_0']."</a>
			</div>
		</div>
	</div>
	<div class='container'>
			<div class='col-md-4'></div>	
");

if ($RowH['ACTIVE_0'] == 1){
	//What happens if survey is not active
print("
	<div class='col-md-4'>The survey is not available at this time. <br> Thank you.</div>
	<div class='col-md-4'></div>
");
}else{
	//What happens if survey is active
	print("<div class='col-md-4'>");
	$queryQ = "SELECT SURNUM_0,cast(Q_0 as varchar(500)) as Q_0,cast(Q_1 as varchar(500)) as Q_1,cast(Q_2 as varchar(500)) as Q_2,cast(Q_3 as varchar(500)) as Q_3,cast(Q_4 as varchar(500)) as Q_4,cast(Q_5 as varchar(500)) as Q_5,cast(Q_6 as varchar(500)) as Q_6,cast(Q_7 as varchar(500)) as Q_7,cast(Q_8 as varchar(500)) as Q_8,cast(Q_9 as varchar(500)) as Q_9,cast(Q_10 as varchar(500)) as Q_10,cast(Q_11 as varchar(500)) as Q_11,cast(Q_12 as varchar(500)) as Q_12,cast(Q_13 as varchar(500)) as Q_13,QTYPE_0,QTYPE_1,QTYPE_2,QTYPE_3,QTYPE_4,QTYPE_5,QTYPE_6,QTYPE_7,QTYPE_8,QTYPE_9,QTYPE_10,QTYPE_11,QTYPE_12,QTYPE_13 FROM $tableQ WHERE SURNUM_0 =$survid";
	$resultQ = mssql_query($queryQ);
	$RowQ = mssql_fetch_assoc($resultQ);
	
	//There are multiple types of questions. Each question has it's own number assigned to it. A smallbox is 1, a large box is 2, a radio button is 3, and a dropdown is 4. Based on what is in the table, we display the question.
	for ($i=0; $i<=$maxquestions; $i++){
		$qstr="Q_".$i;
		if (strlen($RowQ[$qstr])>1){
			print("<div class='starter-template'>");
			$qtypestr="QTYPE_".$i;
			$qoptstr="QOPTION_".$i;
			$qnum=$i+1;
			//small box
			if ($RowQ[$qtypestr]==1){
				print("
					<p><strong>".$qnum.". ".$RowQ[$qstr]."?</strong>
					<textarea name='Q_".$i."' id='Q_".$i."' cols='20' rows='1' style='vertical-align:middle;'/></textarea></p>
					</p>"
				);
			}
			//large box
			if ($RowQ[$qtypestr]==2){
				print("
					<p><strong>".$qnum.". ".$RowQ[$qstr]."?</strong>
					<p class='formfield'><textarea name='Q_".$i."' id='Q_".$i."' cols='50' rows='5' /></textarea></p>
					</p>"
				);
			}
			//radio button
			if ($RowQ[$qtypestr]==3){
				print("
					<p><strong>".$qnum.". ".$RowQ[$qstr]."?</strong>"
				);
				$queryE = "SELECT QOPTION_0 FROM $tableE WHERE SURNUM_0 =$survid and Q_0=$i+1";
				$resultE = mssql_query($queryE);
				while ($opt=mssql_fetch_row($resultE)) {
					print("
						<br><input type='radio' name='Q_".$i."' value='".$opt[0]."'>".$opt[0]
					);
				}
				print("</p>");
			}
			//dropdown
			if ($RowQ[$qtypestr]==4){
				print("
					<p><strong>".$qnum.". ".$RowQ[$qstr]."?</strong><br>
					<select name='Q_".$i."'>"
				);
				$queryE = "SELECT QOPTION_0 FROM $tableE WHERE SURNUM_0 =$survid and Q_0=$i+1";
				$resultE = mssql_query($queryE);
				while ($opt=mssql_fetch_row($resultE)) {
					print("
						<option value='".$opt[0]."'>".$opt[0]."</option>"
					);
				}
				print("</select>
					</p>"
				);
			}
			print("</div>");
		}
	}
	print("<div class='starter-template'>
				<div style='margin:9px 0 0 -7px'><input type='submit' name='sub' id='sub' value='Submit' />
					<input type='reset' name='cancel' id='cancel' value='Cancel' style='margin-left:112px;' />
				</div>
			</div>
			</div> <!--End Middle Row-->
			<div class='col-md-4'></div>
	");
}
print("		  </div> <!--End Container-->
		  </form>
		<!-- Bootstrap core JavaScript
	    ================================================== -->
	    <!-- Placed at the end of the document so the pages load faster -->
	    <script src='assets/js/jquery.js'></script>
	    <script src='dist/js/bootstrap.min.js'></script>
		</body>
");
?>