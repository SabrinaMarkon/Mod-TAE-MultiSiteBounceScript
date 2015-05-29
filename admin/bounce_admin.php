<?php
session_start();
include "../config.php";
$key = "bouncenetwork";
if ($key != $bounces)
{
echo "The script you are trying to run isn't licensed. Please contact <a href=\"mailto:sabrina@phpsitescripts.com\">Sabrina Markon, PHPSiteScripts.com</a> to purchase a licensed copy.</a>";
exit;
}
include "../header.php";
include "../style.php";
function formatDate($val) {
	$arr = explode("-", $val);
	return date("M d Y", mktime(0,0,0, $arr[1], $arr[2], $arr[0]));
}
if( session_is_registered("alogin") ) {
include "adminnavigation.php";
?>
<table align="center">
<tr>
<td valign="top" align="center"><br><br>
<?
echo "<font size=2 face='$fonttype' color='$fontcolour'><p><b><center>";
$action = $_REQUEST["action"];
##############################################################################################
if ($action == "savesettings")
{
$bouncescriptenabled = $_POST["bouncescriptenabled"];
$bounceconsequence = $_POST["bounceconsequence"];
$bounceconsequenceinallsites = $_POST["bounceconsequenceinallsites"];
$bouncesallowed = $_POST["bouncesallowed"];
$q = "update settings set setting=\"$bouncescriptenabled\" where name=\"bouncescriptenabled\"";
$r = mysql_query($q);
$q = "update settings set setting=\"$bounceconsequence\" where name=\"bounceconsequence\"";
$r = mysql_query($q);
$q = "update settings set setting=\"$bounceconsequenceinallsites\" where name=\"bounceconsequenceinallsites\"";
$r = mysql_query($q);
$q = "update settings set setting=\"$bouncesallowed\" where name=\"bouncesmax\"";
$r = mysql_query($q);
						 $maxarray = array (
								"bouncescriptenabled" => $bouncescriptenabled,
								"bounceconsequence" => $bounceconsequence,
								"bounceconsequenceinallsites" => $bounceconsequenceinallsites,
								"bouncesallowed" => $bouncesallowed
						        );
						 $dataels = array();
						 foreach (array_keys($maxarray) as $thiskey) {
						        array_push($dataels,urlencode($thiskey) ."=".
						                        urlencode($maxarray[$thiskey]));
						        }
						 $data = implode("&",$dataels);
$q = "select * from bouncesites order by id";
$r = mysql_query($q) or die(mysql_error());
$posturl = "";
while ($rowz = mysql_fetch_array($r))
{
$siteurl = $rowz["siteurl"];
$posturl = "";
$posturl = $siteurl . "/bounce_max.php";
$useragent="Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1";
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $posturl);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_USERAGENT, $useragent);
$page = curl_exec($curl);
curl_close($curl);
} # while ($rowz = mysql_fetch_array($r))
$spew = "<center><font color=\"#ff0000\"><b>Settings Saved</b></font></center><br><br>";
} # if ($action == "savesettings")
##############################################################################################
if ($action == "deletebounces")
{
$deleteuserid = $_POST["deleteuserid"];
$q = "delete from bounces_admin where userid=\"$deleteuserid\"";
$r = mysql_query($q);
$spew = "<center><font color=\"#ff0000\"><b>Bounce Records Deleted</b></font></center><br><br>";
} # if ($action == "deletebounce")
##############################################################################################
if ($action == "confirmdeleteallbounces")
{
$spew = "<center><form action=\"bounce_admin.php\" method=\"post\"><input type=\"hidden\" name=\"action\" value=\"deleteallbounces\"><input type=\"submit\" value=\"Confirm Mass Deletion Of All Bounces\" style=\"width: 450px; border: 2px #ff0000 solid; border-style: outset;\"></form><form action=\"bounce_admin.php\" method=\"post\"><input type=\"submit\" value=\"Cancel Mass Deletion\" style=\"width: 450px;\"></form></center>";
} # if ($action == "confirmdeleteallbounces")
##############################################################################################
if ($action == "deleteallbounces")
{
$q1 = "delete from bounces_admin";
$r1 = mysql_query($q1);
$spew = "<center><font color=\"#ff0000\"><b>All Bounce Records Were Deleted</b></font></center><br><br>";
} # if ($action == "deleteallbounces")
##############################################################################################
$q3 = "delete from bounces where bouncedate<='".(time()-7*24*60*60)."'";
$r3 = mysql_query($q3);
echo "<center><H2>Member Bounces For All Sites</H2></center><br>Bounce records are kept for 7 days then discarded in order to keep database size in check. Cleaning the database this way does NOT take members off vacation mode who bounced.<br>";

$countq = "select * from bounces_admin";
$countr = mysql_query($countq);
$countrows = mysql_num_rows($countr);

$query = "SELECT *, count(userid) AS bouncecount FROM bounces_admin GROUP BY userid";
$result = mysql_query ($query) or die(mysql_error());
$totalrows = mysql_num_rows($result);
if ($totalrows < 1)
{
echo "<center><p><b>There have been no new bounced emails in the past 7 days.</b></center></p>";
}
if ($totalrows > 0)
{
echo "<br><b>Total Bounced Emails: " . $countrows . "</b><br><br>";
if ($spew != "")
	{
echo $spew;
	}
if ($spew == "")
	{
    ?>
<center>
<form action="bounce_admin.php" method="post">
<input type="hidden" name="action" value="confirmdeleteallbounces">
<input type="submit" value="Purge All Bounce Records">
</form>
</center>
<?php
	}
?>
<br>
<center>
<form action="bounce_admin.php" method="post">
<input type="hidden" name="action" value="savesettings">
Enabled Automatic Bounce Script:&nbsp;<select name="bouncescriptenabled"><option value="yes" <?php if ($bouncescriptenabled == "yes") { echo "selected"; } ?>>YES</option><option value="no" <?php if ($bouncescriptenabled != "yes") { echo "selected"; } ?>>NO</option></select>
<br>
How to handle Bouncing members (vacation is recommended since most members bounce sometimes!):&nbsp;<select name="bounceconsequence"><option value="vacation" <?php if ($bounceconsequence == "vacation") { echo "selected"; } ?>>Put on Vacation</option><option value="deletemember" <?php if ($bounceconsequence != "vacation") { echo "selected"; } ?>>Delete Member</option></select>
<br>
Bounces allowed (for each site) before member is deleted or placed on vacation in that site:&nbsp;<select name="bouncesallowed">
<?php
for ($i=1;$i<=20;$i++)
{
?>
<option value="<?php echo $i ?>" <?php if ($bouncesmax == $i) { echo "selected"; } ?>><?php echo $i ?></option>
<?php
}
?>
</select>
<br>
Delete or Vacation a Bouncing member in ALL sites (not just the site they bounced in):&nbsp;<select name="bounceconsequenceinallsites"><option value="yes" <?php if ($bounceconsequenceinallsites == "yes") { echo "selected"; } ?>>YES</option><option value="no" <?php if ($bounceconsequenceinallsites != "yes") { echo "selected"; } ?>>NO</option></select>
<br><br>
<input type="submit" value="Save">
</form>
</center>
<br>
<table width="90%" cellpadding="4" cellspacing="2" border="0" align="center" bgcolor="#999999">
<tr bgcolor="#eeeeee">
<td align="center"><font size=2 face="<? echo $fonttype; ?>" color="<? echo $fontcolour; ?>">UserID</font></td>
<td align="center"><font size=2 face="<? echo $fonttype; ?>" color="<? echo $fontcolour; ?>">Total Bounces</font></td>
<td align="center"><font size=2 face="<? echo $fonttype; ?>" color="<? echo $fontcolour; ?>">Bounces Per Site</font></td>
<td align="center"><font size=2 face="<? echo $fonttype; ?>" color="<? echo $fontcolour; ?>">Last Site Bounced</font></td>
<td align="center"><font size=2 face="<? echo $fonttype; ?>" color="<? echo $fontcolour; ?>">Last Bounce Date</font></td>
<td align="center"><font size=2 face="<? echo $fonttype; ?>" color="<? echo $fontcolour; ?>">Last Bounce Error</font></td>
<td align="center"><font size=2 face="<? echo $fonttype; ?>" color="<? echo $fontcolour; ?>">Delete User Bounces</font></td>
</tr>
<?php
while ($line = mysql_fetch_array($result))
{
	$userid = $line["userid"];
	$bouncecount = $line["bouncecount"];
	$lastq = "select * from bounces_admin where userid=\"$userid\" order by id desc limit 1";
	$lastr = mysql_query($lastq) or die(mysql_error());
	$lastrows = mysql_num_rows($lastr);
	if ($lastrows > 0)
	{
		$bouncesite = mysql_result($lastr,0,"bouncesite");
		$bounceerror = mysql_result($lastr,0,"bounceerror");
		$bounceerror = stripslashes($bounceerror);
		$bounceerror = str_replace('\\', '', $bounceerror);
		$bouncedate = mysql_result($lastr,0,"bouncedate");
		if (($bouncedate == "") or ($bouncedate == 0))
		{
			$showbouncedate = "";
		}
		else
		{
			$showbouncedate = formatDate($bouncedate);
		}
		$siteq = "select * from bouncesites where siteurl=\"$bouncesite\"";
		$siter = mysql_query($siteq);
		$siterows = mysql_num_rows($siter);
		if ($siterows > 0)
		{
		$sitename = mysql_result($siter,0,"sitename");
		}
		if ($sitename == "")
		{
		$showsitename = $bouncesite;
		}
		if ($sitename != "")
		{
		$showsitename = $sitename;
		}

$bouncespersite = "";
$psq1 = "select * from bouncesites order by sitename";
$psr1 = mysql_query($psq1);
$psrows1 = mysql_num_rows($psr1);
if ($psrows1 > 0)
{
	while ($psrowz1 = mysql_fetch_array($psr1))
	{
	$sitename = $psrowz1["sitename"];
	$siteurl = $psrowz1["siteurl"];
	$psq2 = "select * from bounces_admin where userid=\"$userid\" and bouncesite=\"$siteurl\"";
	$psr2 = mysql_query($psq2);
	$psrows2 = mysql_num_rows($psr2);
	if ($psrows2 > 0)
		{
		$bouncespersite = $bouncespersite . "<a href=\"" . $siteurl . "\" target=\"_blank\">" . $sitename . "</a> - " . $psrows2 . "<br>";
		}
	} # while ($psrowz1 = mysql_fetch_array($psr1))
} # if ($psrows1 > 0)
?>
<tr bgcolor="#eeeeee">
<td align="center"><font size=2 face="<? echo $fonttype; ?>" color="<? echo $fontcolour; ?>"><?php echo $userid ?></font></td>
<td align="center"><font size=2 face="<? echo $fonttype; ?>" color="<? echo $fontcolour; ?>"><?php echo $bouncecount ?></font></td>
<td align="center"><div style="width: 250px; height: 100px; padding: 4px; overflow:auto; border-style: solid; border-size: 1px; border-color: #000000; background: #ffffff;"><? echo $bouncespersite; ?></div></td>
<td align="center"><font size=2 face="<? echo $fonttype; ?>" color="<? echo $fontcolour; ?>"><a href="<?php echo $bouncesite ?>" target="_blank"><?php echo $showsitename ?></a></font></td>
<td align="center"><font size=2 face="<? echo $fonttype; ?>" color="<? echo $fontcolour; ?>"><?php echo $showbouncedate ?></font></td>
<td align="center"><div style="width: 400px; height: 100px; padding: 4px; overflow:auto; border-style: solid; border-size: 1px; border-color: #000000; background: #ffffff;"><? echo $bounceerror; ?></div></td>
<form method="POST" action="bounce_admin.php">
<td align="center">
<input type="hidden" name="deleteuserid" value="<?php echo $userid ?>">
<input type="hidden" name="action" value="deletebounces">
<input type="submit" value="Delete">
</form>
</td></tr>
<tr><td colspan="7"></td></tr>
<?php
	} # if ($lastrows > 0)
} # while ($line = mysql_fetch_array($result))
echo "</table><br>";
} # if ($totalrows > 0)
echo "</td></tr></table><br><br><br>";
}
else
{
echo "Unauthorised Access!";
echo "</td></tr></table><br><br><br>";
}
include "../footer.php";
?>