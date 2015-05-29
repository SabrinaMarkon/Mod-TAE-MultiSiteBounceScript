<?php
session_start();
include "../header.php";
include "../config.php";
include "../style.php";
$useridp = $_POST['userid'];
if(session_is_registered("alogin"))
{
include "adminnavigation.php";
    $query = "SELECT * FROM members where userid='".$useridp."'";

    $result = mysql_query ($query)
	         or die ("Query failed");
	while ($line = mysql_fetch_array($result)) {
		$namep = $line["name"];
	    $contact_emailp = $line["contact_email"];
        $subscribed_emailp = $line["subscribed_email"];
	    $passwordp = $line["pword"];
	    $paypal_emailp = $line["paypal_email"];
        $statusp = $line["status"];
        $referidp= $line["referid"];
        $pointsp= $line["points"];
		$commissionRp= $line["commissionR"];
        $commissionp= $line["commission"];
		$lastpaidp = $line["lastpaid"];
        $solosp= $line["solos"];
        $memtypep = $line["memtype"];
		if ($memtypep == "GOLD")
		{
		$prettymemtypep = $toplevel;
		}
		if ($memtypep == "PRO")
		{
		$prettymemtypep = $middlelevel;
		}
		if (($memtypep != "GOLD") and ($memtypep != "PRO"))
		{
		$prettymemtypep = $lowerlevel;
		}
        $alertpay_emailp = $line["alertpay_email"];
	 $vacationp = $line["vacation"];
    	?>
<table align="center">
      	<tr>
        <td  valign="top" align="center"><br><br> <?
        echo "<font size=2 face='$fonttype' color='$fontcolour'><p><b><center>";
        ?>

            <center>
	        <form method="POST" action="editnow.php">
            Userid:<b> <? echo $userid; ?></b><br><br>
            <input type="hidden" name="userid" value="<? echo $useridp; ?>">
	        Name:<br><input type="text" name="name" value="<? echo $namep; ?>"><br>
	        Password:<br><input type="text" name="password" value="<? echo $passwordp; ?>"><br>
	        Email:<br><input type="text" name="contact_email" value="<? echo $contact_emailp; ?>"><br>
            Referid:<br><input type="text" name="referid" value="<? echo $referidp; ?>"><br>
            <input type="hidden" name="status" value="<? echo $statusp; ?>">
	        Paypal Email:<br><input type="text" name="paypal_email" value="<?echo $paypal_emailp; ?>"><br>
	        AlertPay Email:<br><input type="text" name="alertpay_email" value="<?echo $alertpay_emailp; ?>"><br>
            Commission Currently Owed:<br>$<input type="text" name="commission" value="<? echo $commissionp; ?>"><br>
			Recurring Commission:<br>$<input type="text" name="commissionR" value="<? echo $commissionRp; ?>"><br>
			Last Paid:<br><input type="text" name="lastpaid" value="<? echo $lastpaidp; ?>"><br>
            Points:<br><input type="text" name="points" value="<? echo $pointsp; ?>"><br>
<br>
Vacation: <select name="vacation"><option value="1" <?php if ($vacationp == "1") { echo "selected"; } ?>>ON</option>
<option value="0" <?php if ($vacationp != "1") { echo "selected"; } ?>>OFF</option></select>
<input type="hidden" name="vacationold" value="<?php echo $vacationp ?>"><br><br>

<?php
if ($bouncescriptenabled == "yes")
{
?>
Update Vacation Setting on All Bounce Network Sites? (if vacation is changed): <select name="vacationallsites"><option value="no">NO</option><option value="yes">YES</option></select>
<br><br>
<?php
}
?>
            Membership Type:<b> <? echo $prettymemtypep; ?>
            <br></b>
                         <br>
	        <br><input type="submit" value="Save">
	        </form>
            <? 
				if ($memtypep=="FREE") 
				{			
				?>
	            <form method="POST" action="upgradenow.php">
	            <input type="hidden" name="userid" value="<? echo $userid; ?>">
				<input type="hidden" name="oldmemtype" value="<?php echo $memtypep ?>">
                <input type="hidden" name="memtype" value="PRO">
                <input type="submit" value="Upgrade to Pro">
	            <br>
	            </form>
	            <form method="POST" action="upgradenow.php">
	            <input type="hidden" name="userid" value="<? echo $userid; ?>">
				<input type="hidden" name="oldmemtype" value="<?php echo $memtypep ?>">
                <input type="hidden" name="memtype" value="GOLD">
                <input type="submit" value="Upgrade to Gold">
	            <br>
	            </form>
				<?
				}
				if ($memtypep=="PRO") 
				{			
				?>
	            <form method="POST" action="upgradenow.php">
	            <input type="hidden" name="userid" value="<? echo $userid; ?>">
				<input type="hidden" name="oldmemtype" value="<?php echo $memtypep ?>">
                <input type="hidden" name="memtype" value="GOLD">
                <input type="submit" value="Upgrade to Gold">
	            <br>
	            </form>
	            <form method="POST" action="upgradenow.php">
	            <input type="hidden" name="userid" value="<? echo $userid; ?>">
				<input type="hidden" name="oldmemtype" value="<?php echo $memtypep ?>">
                <input type="hidden" name="memtype" value="FREE">
                <input type="submit" value="Set to Lite">
	            <br>
	            </form>
				<?
				}
				if (($memtypep!="FREE") and ($memtypep!="PRO")) 
				{			
				?>
	            <form method="POST" action="upgradenow.php">
	            <input type="hidden" name="userid" value="<? echo $userid; ?>">
				<input type="hidden" name="oldmemtype" value="<?php echo $memtypep ?>">
                <input type="hidden" name="memtype" value="PRO">
                <input type="submit" value="Set to Pro">
	            <br>
	            </form>
	            <form method="POST" action="upgradenow.php">
	            <input type="hidden" name="userid" value="<? echo $userid; ?>">
				<input type="hidden" name="oldmemtype" value="<?php echo $memtypep ?>">
                <input type="hidden" name="memtype" value="FREE">
                <input type="submit" value="Set to Lite">
	            <br>
	            </form>
				<?
				}
              ?>

<br><br>
<form method=POST action=deletethismember.php>
<input type="hidden" name="userid" value="<? echo $userid; ?>">
<input type="hidden" name="email" value="<? echo $contact_emailp; ?>">
<?php
if ($bouncescriptenabled == "yes")
{
?>
Delete Member From All Bounce Network Sites?: <select name="deleteallsites"><option value="no">NO</option><option value="yes">YES</option></select>
<br><br>
<?php
}
?>
<input type="submit" value="Delete">
</form>
</center>

	    <?
    }
     echo "</td></tr></table>";
    }
else  {
	echo "Unauthorised Access!";
    }

include "../footer.php";
mysql_close($dblink);
?>
 