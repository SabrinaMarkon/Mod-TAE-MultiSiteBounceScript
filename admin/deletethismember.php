<?php
session_start();
include "../header.php";
include "../config.php";
include "../style.php";
$userid = $_POST['userid'];
$email = $_POST['email'];
$deleteallsites = $_POST['deleteallsites'];
if( session_is_registered("alogin"))
{
include "adminnavigation.php";
?>
<table align="center">
      	<tr>
        <td valign="top" align="center"><br><br> <?
    echo "<font size=2 face='$fonttype' color='$fontcolour'><p><b><center>";

    $query1 = "delete from members where userid='".$userid."'";
	$result1 = mysql_query ($query1);

    $query2 = "delete from post where userid='".$userid."'";
	$result2 = mysql_query ($query2);

    $query3 = "delete from viewed where userid='".$userid."'";
	$result3 = mysql_query ($query3);

	if (($deleteallsites == "yes") and ($bounceconsequenceinallsites == "yes"))
		{
		# delete the member in all sites.

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
											"action" => "admindeletemember"
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

    echo $userid." has been permanently deleted!";

    echo "</table></td></tr></table>";
}
else
{
echo "Unauthorised Access!";
}
include "../footer.php";
mysql_close($dblink);
?>