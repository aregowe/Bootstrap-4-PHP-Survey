<?php
include'dbcon.php';

//connection to the database

$dbhandle=mssql_connect($myServer,$myUser,$myPass)

or die("Couldn't connect to SQL Server");

//select a data base to work with

$selected=mssql_select_db($myDB,$dbhandle)

or die("Couldn't open database");

session_start();

$surnum=$_SESSION['surnum'];

$email=$_SESSION['email'];

$site=$_SESSION['site'];

//Query to insert survey data into table. 
$query="INSERT INTO ZSURVEYA(SURNUM_0,EMAIL_0,A_0,A_1,A_2,A_3,A_4,A_5,A_6,A_7,A_8,A_9,A_10,A_11,A_12,A_13) VALUES ('$surnum','$email',convert(varchar(max),'$_POST[Q_0]'),convert(varchar(max),'$_POST[Q_1]'),convert(varchar(max),'$_POST[Q_2]'),convert(varchar(max),'$_POST[Q_3]'),convert(varchar(max),'$_POST[Q_4]'),convert(varchar(max),'$_POST[Q_5]'),convert(varchar(max),'$_POST[Q_6]'),convert(varchar(max),'$_POST[Q_7]'),convert(varchar(max),'$_POST[Q_8]'),convert(varchar(max),'$_POST[Q_9]'),convert(varchar(max),'$_POST[Q_10]'),convert(varchar(max),'$_POST[Q_11]'),convert(varchar(max),'$_POST[Q_12]'),convert(varchar(max),'$_POST[Q_13]'))";

mssql_query($query);

//email
$mail_From = "From: example@example.com <example@example.com>";		//From field in e-mail

$mail_To = "example@example.com";									//Who is receiving e-mail

$mail_Subject = "Survey Submitted:".$surnum;						//Subject of e-mail

$mail_Body = "Survey submitted by ".$email;							//Who submitted the survey

mail($mail_To, $mail_Subject, $mail_Body, $mail_From); 

//If you have multiple websites, this is where to plug the URL of the website to redirect to after survey is filled out

if ($site==""){
	header('Refresh: 5; URL=');	
}else{
	header('Refresh: 5; URL=');
}

?>

<style>
	img.displayed {
		display:block;
		margin-left:auto;
		margin-right:auto;
	}
	p {text-align:center;}
</style>

<img src="ok.png" class="displayed"><br>
<h1 style="color:#333"><p>Thank you!</p></h1>
<h3 style="color:#333"><p>Survey completed Successfully.</p></h3>

<script language="javascript">
	var time_left = 5;
	var cinterval;
	function time_dec(){
	  time_left--;
	  document.getElementById('countdown').innerHTML = time_left;
	  if(time_left == 0){
	    clearInterval(cinterval);
	  }
	}
	cinterval = setInterval('time_dec()', 1000);
</script>

<p>You will be redirected in <span id="countdown">5</span> seconds.</p>

