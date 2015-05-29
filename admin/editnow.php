<?php
session_start();
include "../header.php";
include "../config.php";
$useridpp = $_POST['userid'];
$passwordp = $_POST['password'];
$namep = $_POST['name'];
$contact_emailp = $_POST['contact_email'];
$subscribed_emailp = $_POST['subscribed_email'];
$paypal_emailp = $_POST['paypal_email'];
$alertpay_emailp = $_POST['alertpay_email'];
$statusp = $_POST['status'];
$referidp = $_POST['referid'];
$solosp = $_POST['solo'];
$commissionRp = $_POST['commissionR'];
$commissionp = $_POST['commission'];
$pointsp = $_POST['points'];
$vacationp = $_POST["vacation"];
$vacationold = $_POST["vacationold"];
$vacationallsites = $_POST["vacationallsites"];
if ($solosp=="on") {
    $solosp=1;
}
else {
	$solosp=0;
}

if(session_is_registered("alogin"))
{
include "adminnavigation.php";
?>
<table align="center">
      	<tr>
        <td  valign="top" align="center"><br><br> <?
    	echo "<font size=2 face='$fonttype' color='$fontcolour'><p><b><center>";
	// errorchecking first:

	if (empty($password)) {
		echo "Error! Password field is empty.";
        ?>
            <center>
	        <form method="POST" action="edit.php">
	        <input type="hidden" name="userid" value="<? echo $userid; ?>">
            <input type="submit" value="Go Back">
	        </form>
	        </center>
	    <?
	    exit;
	    }
    if (empty($name)) {
        echo "Error! Name field is empty.";
        ?>
            <center>
	        <form method="POST" action="edit.php">
	        <input type="hidden" name="userid" value="<? echo $userid; ?>">
            <input type="submit" value="Go Back">
	        </form>
	        </center>
	    <?
        exit;
        }


   	$query = "UPDATE members SET ";
   	$query .= "name='$namep',pword='$passwordp',contact_email='$contact_emailp',alt_email='$contact_emailp',paypal_email='$paypal_emailp',";
   	$query .= "subscribed_email='$contact_emailp',alertpay_email='$alertpay_emailp',";
   	$query .= "solos='$solosp', commission='$commissionp', commissionR='$commissionRp', lastpaid='$lastpaid', points='$pointsp', referid='$referidp' ";
   	$query .= "WHERE userid = '$useridpp'";

    $result = mysql_query ($query)
    	or die ("failed");
if ($vacationold != $vacationp)
	{
	$q = "update members set vacation='$vacationp', vacation_date = '".time()."' where userid='$useridpp'";
	$r = mysql_query($q);

	if (($vacationallsites == "yes") and ($bounceconsequenceinallsites == "yes"))
		{
		# update the vacation mode for the member in all sites.

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
											"action" => "adminvacation"
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

   	echo "<center>User Updated.</center>";
    ?>
    <center>
	<form method="POST" action="view.php">
    <input type="submit" value="Go Back">
	</form>
	</center>
<?
echo "</td></tr></table>";
}
else
{
echo "Unauthorised Access!";
}
include "../footer.php";
mysql_close($dblink);
?>