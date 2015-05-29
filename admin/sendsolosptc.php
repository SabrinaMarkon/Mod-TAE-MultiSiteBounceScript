<?php
include "../config.php";
$today =  getdate();
$theday = $today["mday"];
//pick a random number and make sure it is not already in the database....
do
{
    $random = rand(10000, 1000000);
    $query = "select * from ptcsoloadlinks where number=".$random;
    $result = mysql_query($query) or die (mysql_error());
    $numrows = @ mysql_num_rows($result);
} while ($numrows == 1);

do
{
    $randomf = rand(10000, 1000000);
    $queryf = "select * from footeradlinks where number=".$randomf;
    $resultf = mysql_query($queryf) or die (mysql_error());
    $numrowsf = @ mysql_num_rows($resultf);
} while ($numrowsf == 1);

if ($id != "")
{
$resendq = "update ptcsoloads set sent=\"0\" where id=\"$id\"";
$resendr = mysql_query($resendq);
$query3 = "select * from ptcsoloads where approved=1 and sent=0 and id=\"$id\" limit 1";
}
if ($id == "")
{
$query3 = "select * from ptcsoloads where approved=1 and sent=0 limit 1";
}
$result3 = mysql_query($query3) or die (mysql_error());
$numrows2 = @ mysql_num_rows($result3);
    if ($numrows2 == 0) {
       echo "<p>No PTC CashClick solo ads to send.</p>";
       exit;
    } //end if ($numrows == 0)
	$line3 = mysql_fetch_array($result3);
    $subject = $line3["subject"];
	$subject = stripslashes($subject);
    $adbody = $line3["adbody"];
	$adbody = stripslashes($adbody);
	$url = $line3["url"];
    $id = $line3["id"];
	$freepayperclick = $line3["freepayperclick"];
	$propayperclick = $line3["propayperclick"];
	$goldpayperclick = $line3["goldpayperclick"];

//update the links table with the new random number.
$query2 = "insert into ptcsoloadlinks set number=".$random.", adid=".$id;
$result2 = mysql_query ($query2);

//set the 'sent' in the database to 1
$query5 = "update ptcsoloads set sent=1 where id=".$id;
$result5 = mysql_query ($query5);    

//set the 'datesent' 
$query6 = "update ptcsoloads set datesent='".time()."' where id=".$id;
$result6 = mysql_query ($query6);

// get footer ad
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

//get all members details....
$query4 = "select * from members where status=1 and verified=1 and vacation=0";
$result4 = mysql_query ($query4)
        or die ("Query failed");
while ($line4 = mysql_fetch_array($result4)) {

    $email = $line4["subscribed_email"];
    $memtypeq = $line4["memtype"];
    $useridq = $line4["userid"];
	$nameq = $line4["name"];
    $passwordq = $line4["pword"];

    $Subject = "(CashClick Solo) ".$subject;
    $Message = $adbody;
    $Message .= "<br><br>--------------------------------------------------------------<br><br>";
    if ($memtypeq == "GOLD") {
        $Message .= "Click the link to receive $".$goldpayperclick." cash!<br><br>";
    }
    if ($memtypeq == "PRO") {
         $Message .= "Click the link to receive $".$propayperclick." cash!<br><br>";
    }
    if (($memtypeq != "GOLD") and ($memtypeq != "PRO")) {
         $Message .= "Click the link to receive $".$freepayperclick." cash!<br><br>";
    }
    $Message .= "<a href=\"".$domain."/ptcclicks.php?userid=".$useridq."&seed=".$random."&id=".$id."\" target=\"_blank\">".$domain."/ptcclicks.php?userid=".$useridq."&seed=".$random."&id=".$id."</a>";
    $Message .= ".<br><br>";
    $Message .= "--------------------------------------------------------------<br><br>";

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
	$Message .= "--------------------------------------------------------------<br>";
	} 

    $Message .= "This is a solo ad advertisement from a member of ".$sitename.". You are receiving this because you are a member of '$sitename'.<br>";
    $Message .= "You can opt out of receiving emails only by deleting your account, click here to delete your account.<br><br><a href=\"$domain/delete.php?userid=$useridq&code=".md5($passwordq)."\" target=\"_blank\">$domain/delete.php?userid=$useridq&code=".md5($passwordq)."</a>.<br><br>";
	$Message .= "$adminname<br>$sitename<br>$adminemail<br>";
	
$return_path = "user-".$useridq."-".$bounceemail;
$headers = "From: \"$sitename\" <$adminemail>\n";
$headers .= "Reply-To: <$adminemail>\n";
$headers .= "X-Sender: <$adminemail>\n";
$headers .= "MIME-Version: 1.0\n";
$headers .= "X-Mailer: PHP4\n";
$headers .= "Content-Type: text/html; charset=windows-1252\n";
$headers .= "X-Priority: 3\n";
$headers .= "Return-Path: <$return_path>\n";		

	$nameq = trim($nameq);
	$firstnameq = substr($nameq , 0, strpos($nameq, " "));

	
	$Message = str_replace("~userid~",$useridq,$Message);
	$Message = str_replace("~fname~",$firstnameq,$Message);
	$Subject = str_replace("~userid~",$useridq,$Subject);
	$Subject = str_replace("~fname~",$firstnameq,$Subject);

@mail($email, $Subject, $Message, $headers, "-f$return_path");

    $counter=$counter+1;

} // end while ($line4 = mysql_fetch_array($result))
include "../header.php";
include "../style.php";
include "adminnavigation.php";
?>
<table align="center">
<tr>
<td valign="top" align="center"><br><br>
<?php
echo "<font size=2 face='$fonttype' color='$fontcolour'><p><center>";
echo "<p><b><center>email successfully posted to ".$counter." members.</p></b></center>";
echo "</td></tr></table>";
include "../footer.php";
mysql_close($dblink);
?>