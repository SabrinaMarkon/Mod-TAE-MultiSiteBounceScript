<?php
include "../config.php";
$key = "topsupers";
if ($key != $topnetwork)
{
echo "The script you are trying to run isn't licensed. Please contact <a href=\"mailto:webmaster@pearlsofwealth.com\">Sabrina Markon, PearlsOfWealth.com</a> to purchase a licensed copy.</a>";
exit;
}
if ($topsolothissiteactive != "yes")
{
echo "<p><b><font color=\"#ff0000\">" . $topsoloname . " ads have been disabled for this website.</font></b></p>";
echo "<p>Click <a href=\"index.php\">here</a> to go back<p>";
include "../footer.php";
exit;
} # if ($topsolothissiteactive != "yes")
################################################### resend ones that failed to be sent to the admin queue for whatever reason (site too slow and timed out, etc.)
if ($topmasteradminapproveonly == "yes")
{
$sq1 = "select * from topsolos where approved=0 and added=1 and orderedfrom='$domain' and lastsenttoadmin<= date_sub(now(), interval 24 hour)";
$sr1 = mysql_query($sq1);
$srrows1 = mysql_num_rows($sr1);
if ($srrows1 > 0)
{
while ($srrowz1 = mysql_fetch_array($sr1))
{
$topsoloid = $srrowz1["id"];
$topsolosubject = $srrowz1["subject"];
$topsoloadbody = $srrowz1["adbody"];
$topsolourl = $srrowz1["url"];
$topsolouserid = $srrowz1["userid"];

								 $wannasay = array (
						        "subject" => $topsolosubject,
						        "adbody" => $topsoloadbody,
								"userid" => $topsolouserid,
								"orderedfrom" => $domain,
								"orderid" => $topsoloid,
								"url" => $topsolourl
						        );
						 $dataels = array();
						 foreach (array_keys($wannasay) as $thiskey) {
						        array_push($dataels,urlencode($thiskey) ."=".
						                        urlencode($wannasay[$thiskey]));
						        }
						 $data = implode("&",$dataels);
			
			$posturl = $topmasteradminsiteurl . "/admin/topsoloadminapprovalqueuereceive.php";
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $posturl);
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			$page = curl_exec($curl);
			curl_close($curl);

		$senttoadminq = "update topsolos set lastsenttoadmin=NOW() where id=\"$topsoloid\"";
		$senttoadminr = mysql_query($senttoadminq);

} # while ($srrowz1 = mysql_fetch_array($sr1))
@sleep(10);
} # if ($srrows1 > 0)
} # if ($topmasteradminapproveonly == "yes")
########################################################################################
# fix - solos that have clicks and were already approved by admin and sent, but did not update approved=1 or sent=1 at the orderedfrom site.
$fq = "update topsolos set sent=1,approved=1 where approved=0 and added=1 and clicks>0";
$fr = mysql_query($fq);
########################################################################################
if ($topdontmailbeforeintervalminutes != 0)
{
$query3 = "select * from topsolos where approved=1 and sent=0 and dontmailbefore<NOW() limit 1";
$result3 = mysql_query ($query3) or die (mysql_error());
$numrows2 = @ mysql_num_rows($result3);
}
if ($topdontmailbeforeintervalminutes == 0)
{
$query3 = "select * from topsolos where approved=1 and sent=0 limit 1";
$result3 = mysql_query ($query3) or die (mysql_error());
$numrows2 = @ mysql_num_rows($result3);
}
if ($numrows2 < 1) 
{
exit;
}
if ($numrows2 > 0)
{
$line3 = mysql_fetch_array($result3);
$subject = $line3["subject"];
$subject = stripslashes($subject);
$adbody = $line3["adbody"];
$id = $line3["id"];
$adsender = $line3["userid"];

$query5 = "update topsolos set sent=1 where id=".$id;
$result5 = mysql_query ($query5) or die (mysql_error());   
$query6 = "update topsolos set datesent='".time()."' where id=".$id;
$result6 = mysql_query ($query6) or die (mysql_error());

$query1 = "SELECT * FROM pages WHERE name='Solo footer ad'";
$result1 = mysql_query ($query1);

$line1 = mysql_fetch_array($result1);
$htmlcode = $line1["htmlcode"];
if($htmlcode) $htmlcode = "<br>$htmlcode<br><br>";	
		
## recipients
$query4 = "select * from members where status=1 and verified=1 and vacation=0";
$result4 = mysql_query ($query4)
        or die ("Query failed");
while ($line4 = mysql_fetch_array($result4)) {

    $email = $line4["subscribed_email"];
    $memtypeq = $line4["memtype"];
    $useridq = $line4["userid"];
	$nameq = $line4["name"];
    $passwordq = $line4["pword"];

    $Subject = "[" . $topsoloname . "] ".$subject;
    $Message = $adbody;
    $Message .= "<br><br>--------------------------------------------------------------<br><br>";

	if ($memtypeq == "GOLD")
	{
	$topsoloearn = $superjvtopsoloearn;
	}
	elseif($memtypeq == "PRO")
	{
	$topsoloearn = $jvtopsoloearn;
	}
	else 
	{
	$topsoloearn = $protopsoloearn;
	}

	$topsoloclickurl = $domain."/topsolo.php?userid=".$useridq."&id=".$id;

	if ($topsoloearn > 0)
	{
	$Message .= "<a href=\"" . $topsoloclickurl . "\" target=\"_blank\"><b>Click here to receive " . $topsoloearn . " Points!</b></a>";
	}
	if (($topsoloearn <= 0) and ($topsolopay <= 0))
	{
	$Message .= "";
	}
    $Message .= ".<br><br>";
    $Message .= "--------------------------------------------------------------<br>$htmlcode<br>";
    $Message .= "This is a solo ad advertisement from a member of ".$sitename.". You are receiving this because you are a member of '$sitename'.<br>";
    $Message .= "You can opt out of receiving emails only by deleting your account, click here to delete your account.<br><br><a href=\"$domain/delete.php?userid=$useridq&code=".md5($passwordq)."\">$domain/delete.php?userid=$useridq&code=".md5($passwordq)."</a>.<br><br>";
	$Message .= "$adminname, $sitename, $adminaddress<br>";
	
	$return_path = "user-".$useridq."-".$bounceemail;
    $headers = "From: $sitename<$adminemail>\n";
        $headers .= "Reply-To: <$adminemail>\n";
        $headers .= "X-Sender: <$adminemail>\n";
        $headers .= "X-Mailer: PHP4\n";
        $headers .= "X-Priority: 3\n";
        $headers .= "Return-Path: <$return_path>\nContent-type: text/html; charset=iso-8859-1\n";
	
	$Message = str_replace("~userid~",$useridq,$Message);
	$Message = str_replace("~fname~",$nameq,$Message);
	$Subject = str_replace("~userid~",$useridq,$Subject);
	$Subject = str_replace("~fname~",$nameq,$Subject);

    @mail($email, $Subject, wordwrap(stripslashes($Message)),$headers, "-f$return_path");

    $counter=$counter+1;

echo "Mail sent to " . $email . "<br>";
}
} # if ($numrows2 > 0)
exit;
?>