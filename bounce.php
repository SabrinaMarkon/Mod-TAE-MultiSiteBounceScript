#!/usr/local/bin/php -q
<?php
include "/home/topsoloz/kangaroopaw/public_html/config.php";
######### COPYRIGHT 2015 SABRINA MARKON PHPSITESCRIPTS.COM. ALL RIGHTS RESERVED. RESALE IS ABSOLUTELY NOT PERMITTED! ##########################
if ($bouncescriptenabled == "yes")
{
// Reading in the email
$fd = fopen("php://stdin", "r");
while (!feof($fd)) {
  $email .= fread($fd, 1024);
}
fclose($fd);

// Parsing the email
$lines = explode("\n", $email);
$stillheaders=true;
for ($i=0; $i < count($lines); $i++) {
  if ($stillheaders) {
    // this is a header
    $headers .= $lines[$i]."\n";

    // look out for special headers
    if (preg_match("/^Subject: (.*)/", $lines[$i], $matches)) {
      $subject = $matches[1];
    }
    if (preg_match("/^From: (.*)/", $lines[$i], $matches)) {
      $from = $matches[1];
    }
    if (preg_match("/^To: (.*)/", $lines[$i], $matches)) {
      $to = $matches[1];
    }
  } else {
    // not a header, but message
    #break;
    #Optionally you can read out the message also, instead of the break:
    $message .= $lines[$i]."\n";
  }

  if (trim($lines[$i])=="") {
    // empty line, header section has ended
    $stillheaders = false;
  }
}

list($part1,$dum1) = explode("-bounce@topsoloz.com", trim($to) );
list($dum2,$part2) = explode("user-", $part1);
//
// user-12345-site-bounce@yoursite.com
// $part2 now contains the user id and sitename "12345-site" in the example

$userandsite_array = explode("-", $part2);
$bounceduserid = $userandsite_array[0];
$bouncedsite = $userandsite_array[1];
$bouncedemail = trim($to);

if (($bounceduserid != "") and ($bouncedsite != ""))
{
$siteq = "select * from bouncesites where sitename=\"$bouncedsite\"";
$siter = mysql_query($siteq);
$siterows = mysql_num_rows($siter);
	if ($siterows > 0)
	{
	$siteurl = mysql_result($siter,0,"siteurl");
	
									 $bounceinfo = array (
											"userid" => $bounceduserid,
											"email" => $bouncedemail,
											"message" => $message
											);
									 $dataels = array();
									 foreach (array_keys($bounceinfo) as $thiskey) {
											array_push($dataels,urlencode($thiskey) ."=".
															urlencode($bounceinfo[$thiskey]));
											}
									 $data = implode("&",$dataels);

			$posturl = "";
			$posturl = $siteurl . "/bounce_curl.php";
			$curl = "";
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $posturl);
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			$page = curl_exec($curl);
			curl_close($curl);

	} # if ($siterows > 0)

$bouncemessage = addslashes($message);
$q = "insert into bounces_admin (userid,email,bouncedate,bounceerror,bouncesite) values (\"$bounceduserid\",\"$bouncedemail\",NOW(),\"$bouncemessage\",\"$siteurl\")";
$r = mysql_query($q);

}

/* TESTING - See if I receive bounce notifications from this script to indicate it is processing. */
$headers = "From: $sitename<$adminemail>\n";
$headers .= "Reply-To: <$adminemail>\n";
$headers .= "X-Sender: <$adminemail>\n";
$headers .= "X-Mailer: PHP5\n";
$headers .= "X-Priority: 3\n";
$headers .= "Return-Path: <$adminemail>\nContent-type: text/html; charset=iso-8859-1\n";
$Message = $bounceduserid . "<br><br>" . $bouncedemail . "<br><br>" . $bouncedsite . "<br><br>" . $siteurl . "<br><br><hr>" . $q . "<br><br>" . $r;
$Subject = "bounce script ran";
@mail("webmaster@pearlsofwealth.com", $Subject, wordwrap(stripslashes($Message)),$headers, "-f$adminemail");


return true;
}
?>