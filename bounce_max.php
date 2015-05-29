<?php
include "config.php";
######### COPYRIGHT 2015 SABRINA MARKON PHPSITESCRIPTS.COM. ALL RIGHTS RESERVED. RESALE IS ABSOLUTELY NOT PERMITTED! ##########################
$key = "bouncenetwork";
if ($key != $bounces)
{
echo "The script you are trying to run isn't licensed. Please contact <a href=\"mailto:sabrina@phpsitescripts.com\">Sabrina Markon, PHPSiteScripts.com</a> to purchase a licensed copy.</a>";
exit;
}
if($_REQUEST['bouncesallowed'])
{
$bouncescriptenabled = $_REQUEST["bouncescriptenabled"];
$bounceconsequence = $_REQUEST["bounceconsequence"];
$bounceconsequenceinallsites = $_REQUEST["bounceconsequenceinallsites"];
$bouncesmax= $_REQUEST['bouncesmax'];
$q = "update settings set setting=\"$bouncesmax\" where name=\"bouncesmax\"";
$r = mysql_query($q);
$q = "update settings set setting=\"$bounceconsequence\" where name=\"bounceconsequence\"";
$r = mysql_query($q);
$q = "update settings set setting=\"$bounceconsequenceinallsites\" where name=\"bounceconsequenceinallsites\"";
$r = mysql_query($q);
$q = "update settings set setting=\"$bouncescriptenabled\" where name=\"bouncescriptenabled\"";
$r = mysql_query($q);
}
mysql_close();
?> 