<?php
include "config.php";
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
$bouncesallowed= $_REQUEST['bouncesallowed'];
$q = "update settings set setting=\"$bouncesallowed\" where name=\"bouncesmax\"";
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