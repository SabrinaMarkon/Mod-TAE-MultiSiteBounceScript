<?php
include "config.php";
$key = "bouncenetwork";
if ($key != $bounces)
{
echo "The script you are trying to run isn't licensed. Please contact <a href=\"mailto:sabrina@phpsitescripts.com\">Sabrina Markon, PHPSiteScripts.com</a> to purchase a licensed copy.</a>";
exit;
}
if($_REQUEST['userid'])
{
$action = $_REQUEST['action'];
$email = $_REQUEST['email'];
$userid = $_REQUEST['userid'];
	if ($action == "autoconsequence")
	{
		if ($bounceconsequence == "vacation")
			{
			$q2 = "update members set vacation=1, vacation_date = '".time()."' where userid='".$userid."' or subscribed_email='".$email."' or contact_email='".$email."'";
			$r2 = mysql_query($q2);
			}
		if ($bounceconsequence == "deletemember")
			{
			$q2 = "delete from members where userid='".$userid."' or subscribed_email='".$email."' or contact_email='".$email."'";
			$r2 = mysql_query($q2);
			}
	}
	if ($action == "adminvacation")
	{
	$q2 = "update members set vacation=1, vacation_date = '".time()."' where userid='".$userid."' or subscribed_email='".$email."' or contact_email='".$email."'";
	$r2 = mysql_query($q2);
	}
	if ($action == "admindeletemember")
	{
	$q2 = "delete from members where userid='".$userid."' or subscribed_email='".$email."' or contact_email='".$email."'";
	$r2 = mysql_query($q2);
	}
}
exit;
?>