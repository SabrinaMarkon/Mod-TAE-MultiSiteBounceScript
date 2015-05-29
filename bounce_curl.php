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
$message = $_REQUEST['message'];
$message = addslashes($message);
$email = $_REQUEST['email'];
$userid = $_REQUEST['userid'];
$q1 = "insert into bounces (userid,email,bouncedate,bounceerror) values ('".$userid."','".$email."',NOW(),'".$message."')";
$r1 = mysql_query($q1);
$q2 = "select * from bounces where userid='".$userid."' or email='".$email."'";
$r2 = mysql_query($q2);
$rows2 = mysql_num_rows($r2);
if ($rows2 >= $bouncesmax)
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

		if ($bounceconsequenceinallsites == "yes")
		{
			# network admin wants to put a bouncing member on vacation or delete them in ALL sites in the network.
			$bq = "select * from bouncesites where sitename!=\"$domain\" order by id";
			$br =  mysql_query($bq);
			$brows = mysql_num_rows($br);
			if ($brows > 0)
			{
				while ($browz = mysql_fetch_array($br))
				{
					$bsiteurl = $browz["siteurl"];

									 $bounceinfo = array (
											"userid" => $userid,
											"email" => $email,
											"action" => "autoconsequence"
											);
									 $dataels = array();
									 foreach (array_keys($bounceinfo) as $thiskey) {
											array_push($dataels,urlencode($thiskey) ."=".
															urlencode($bounceinfo[$thiskey]));
											}
									 $data = implode("&",$dataels);

					$posturl = "";
					$posturl = $bsiteurl . "/bounce_curl_all.php";
					$curl = "";
					$curl = curl_init();
					curl_setopt($curl, CURLOPT_URL, $posturl);
					curl_setopt($curl, CURLOPT_POST, 1);
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
					$page = curl_exec($curl);
					curl_close($curl);
				}
			}
		}

	}
}
$q3 = "delete from bounces where bouncedate<='".(time()-7*24*60*60)."'";
$r3 = mysql_query($q3);
mysql_close();
?>