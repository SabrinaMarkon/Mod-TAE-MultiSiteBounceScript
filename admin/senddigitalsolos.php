<?php
include "../config.php";
if ($digitalsolothissiteactive != "yes")
{
echo "<p><b><font color=\"#ff0000\">" . $digitalsoloname . " ads have been disabled for this website.</font></b></p>";
echo "<p>Click <a href=\"index.php\">here</a> to go back<p>";
include "../footer.php";
exit;
} # if ($digitalsolothissiteactive != "yes")
$query3 = "select * from digitalsolos where approved=1 and sent=0 limit 1";
$result3 = mysql_query ($query3) or die (mysql_error());
$numrows2 = @ mysql_num_rows($result3);
if ($numrows2 < 1) 
{
exit;
}
$line3 = mysql_fetch_array($result3);
$subject = $line3["subject"];
$adbody = $line3["adbody"];
$id = $line3["id"];
$adsender = $line3["userid"];

$query5 = "update digitalsolos set sent=1 where id=".$id;
$result5 = mysql_query ($query5) or die (mysql_error());   
$query6 = "update digitalsolos set datesent='".time()."' where id=".$id;
$result6 = mysql_query ($query6) or die (mysql_error());

## footer
$fq1 = "select * from footerads where approved=1 order by rand()";
$fr1 = mysql_query($fq1);
$frows1 = mysql_num_rows($fr1);
if ($frows1 < 1)
{
$footeradavailable = "no";
}
if ($frows1 > 0)
{
 while ($frowz1 = mysql_fetch_array($fr1))
	{
	$fid = $frowz1["id"];
	$fuserid = $frowz1["userid"];
	$fheading = $frowz1["heading"];
	$fheading = stripslashes($fheading);
	$furl = $frowz1["url"];
	$fdescription = $frowz1["description"];
	$fdescription = stripslashes($fdescription);
	$fmax = $frowz1["max"];
	$fclicks = 0;
	$query4 = "select * from footeradclicks where adid=\"$fid\"";
	$result4 = mysql_query($query4) or die ("Query 4 failed");
	while ($line4 = mysql_fetch_array($result4))
	{
	$fclicks = $fclicks + 1;
	}
	if ($fclicks < $fmax)
		{
		$footeradavailable = "yes";
		## footer links table.
		$fquery2 = "insert into footeradlinks set number=".$randomf.", adid=".$fid;
		$fresult2 = mysql_query ($fquery2);
		$fquery5 = "update footerads set sent=sent+1 where id=".$fid;
		$fresult5 = mysql_query ($fquery5);  
		//set the 'datesent' 
		$fquery6 = "update footerads set datesent='".time()."' where id=".$fid;
		$fresult6 = mysql_query ($fquery6);
		break;
		}
	} # while ($frowz1 = mysql_fetch_array($fr1))
} # if ($frows1 > 0)	
		
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

    $Subject = "[" . $digitalsoloname . "] ".$subject;
    $Message = $adbody;
    $Message .= "<br><br>--------------------------------------------------------------<br><br>";
   if ($memtypeq == "GOLD") {
        $Message .= "Click the link to receive ".$golddigitalsoloearn." credits<br><br>";
    }
        elseif ($memtypeq == "PRO"){
         $Message .= "Click the link to receive ".$prodigitalsoloearn." credits<br><br>";
    }
    
    else {
         $Message .= "Click the link to receive ".$freesupersoloearn." credits<br><br>";
    }
    $Message .= "<a href=\"".$domain."/digitalsolo.php?userid=".$useridq."&id=".$id."\">".$domain."/digitalsolo.php?userid=".$useridq."&id=".$id."</a>";
	$Message .= "<br><br>This solo submitted by $adsender.";
    $Message .= ".<br><br>";
    $Message .= "--------------------------------------------------------------<br>";

if ($footeradavailable == "yes")
	{
	$footerad = "";
	$footerad = "<div align=\"left\" style=\"width: 254px;\"><span style=\"background: " . $contrastcolour . ";\"><b>Get Bonus Points!<br>Please Visit Our Featured Advertisers!</b></span><br><br>
	* * * * * * * * * * * * * * * * * * * * * * * * * * *
	</div>
	<br>
	<div align=\"left\" style=\"width: 254px;\">
	<table border=\"1\" cellpadding=\"2\" cellspacing=\"2\" style=\"border-collapse: collapse\" bordercolor=\"#111111\" width=\"254\">
	<tr>
	<td width=\"254\" align=\"center\" style=\"background: " . $contrastcolour . ";\">
	<b><font face=\"" . $fonttype . "\" color=\"" . $fontcolour . "\" size=\"2\">" . $sitename . " Footer Ads</font></b>
	</td>
	</tr>
	<tr>
	<td width=\"254\" align=\"center\"><br>
	<font face=\"" . $fonttype . "\" size=\"2\"><a href=\"" . $domain . "/fclicks.php?userid=" . $useridq . "&seed=" . $randomf . "&id=" . $fid . "\" target=\"_blank\"><b>" . $fheading . "</b></a></font>
	<br><p align=\"left\" style=\"padding: 4px;\"><font face=\"Tahoma\" size=\"2\">" . $fdescription . "</font></p>
	</td>
	</tr>
	</table>
	</div>
	<br>
	<div align=\"left\" style=\"width: 254px;\">
	* * * * * * * * * * * * * * * * * * * * * * * * * * *
	<br><br>
	Click the Footer Ad Above for Bonus Points!
	</div>
	";
    $Message .= $footerad . "<br>";
	$Message .= "--------------------------------------------------------------<br><br>";
	} 

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
	
	$nameq = trim($nameq);
	$firstnameq = substr($nameq , 0, strpos($nameq, " "));
	
	$Message = str_replace("~userid~",$useridq,$Message);
	$Message = str_replace("~fname~",$firstnameq,$Message);
	$Subject = str_replace("~userid~",$useridq,$Subject);
	$Subject = str_replace("~fname~",$firstnameq,$Subject);

    @mail($email, $Subject, wordwrap(stripslashes($Message)),$headers, "-f$return_path");

    $counter=$counter+1;

}
mysql_close($dblink);
?>