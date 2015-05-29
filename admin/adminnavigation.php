<style>
input.ssw {
  color:#000000;
  font: bold 100% 'Tahoma',helvetica,sans-serif;
  background-color:#fed;
  border: 1px solid;
  border-color: #000000 #000000 #000000 #000000;
  filter:progid:DXImageTransform.Microsoft.Gradient
  (GradientType=0,StartColorStr='#ff0000',EndColorStr='#ff0000');
}
</style>
<table cellspacing="0" cellpadding="0" border="0" align="center" width="100%">
<tr>
<td align="center" valign="top">
		<input type="button" value="Main Admin Area" style="font-size: 10px; width: 220px;" onclick="window.location='index.php'">
		<input type="button" value="Main Website" style="font-size: 10px; width: 220px;" onclick="window.open('../index.php')">
		<input type="button" value="Approve Ads" style="font-size: 10px; width: 220px;" onclick="window.location='approveadds.php'">
		<input type="button" value="Waiting For Send" style="font-size: 10px; width: 220px;" onclick="window.location='sendstostart.php'">
		<input type="button" value="Support" style="font-size: 10px; width: 220px;" onclick="window.location='support.php'">
		<input type="button" value="Contact All" style="font-size: 10px; width: 220px;" onclick="window.location='email.php'">
		<input type="button" value="Admin Ads" style="font-size: 10px; width: 220px;" onclick="window.location='addadminsolos.php'">
		<input type="button" value="Network Bounce Manager" style="font-size: 10px; width: 220px;" onclick="window.location='bounce_admin.php'">
		<?php
		if ($bouncescriptenabled == "yes")
		{
		?>
		<input type="button" value="*Site* Member Bounces" style="font-size: 10px; width: 220px;" onclick="window.location='bounce_viewer.php'">
		<?php
		}
		?>
</td>

<td align="center" valign="top">
<?php
include "topsoloadminnavcontrol.php";
?>
</td>

<td align="center" valign="top">
		<input type="button" value="Main Settings" style="font-size: 10px; width: 220px;" onclick="window.location='settings.php'">
<?php
#######################
if ($digitalsolothissiteactive == "yes")
{
$ssq = "select * from digitalsolos where approved=0 and added=1";
$ssr = mysql_query($ssq) or die(mysql_error());
$ssrows = mysql_num_rows($ssr);
if ($ssrows == 0) 
{
?>
<input type="button" value="<?php echo $digitalsoloname ?> Settings" style="font-size: 10px; width: 220px;" onclick="window.location='digitalsolosettings.php'">
<?
}
else
{
?>
<input type="button" value="<?php echo $digitalsoloname ?> Waiting" style="font-size: 10px; width: 220px;" class="ssw" onclick="window.location='digitalsolosettings.php'">
<?
}
} # if ($digitalsolothissiteactive == "yes")
?>
<?
if ($blazingsolothisisadminsite == "yes")
{
?>
<input type="button" value="<?php echo $blazingsoloname ?> Admin" style="font-size: 10px; width: 220px;" onclick="window.location='blazingsolomasteradmin.php'">
<?
}
###########################################################################
if ($blazingsolothissiteactive == "yes")
{
if ($blazingmasteradminapproveonly == "yes")
	{
$ssq = "select * from blazingsolos where approved=1 and added=1 and sent=0";
	}
if ($blazingmasteradminapproveonly != "yes")
	{
$ssq = "select * from blazingsolos where approved=0 and added=1";
	}
$ssr = mysql_query($ssq) or die(mysql_error());
$ssrows = mysql_num_rows($ssr);
if ($ssrows == 0) 
{
?>
<input type="button" value="<?php echo $blazingsoloname ?> Settings" style="font-size: 10px; width: 220px;" onclick="window.location='blazingsolosettings.php'">
<?
}
else
{
?>
<input type="button" value="<?php echo $blazingsoloname ?> Waiting" style="font-size: 10px; width: 220px;" class="ssw" onclick="window.location='blazingsolosettings.php'">
<?
}
?>
<?php
} # if ($blazingsolothissiteactive == "yes")
?>
<?
if ($aff2solothisisadminsite == "yes")
{
?>
<input type="button" value="<?php echo $aff2soloname ?> Admin" style="font-size: 10px; width: 220px;" onclick="window.location='aff2solomasteradmin.php'">
<?
}
###########################################################################
if ($aff2solothissiteactive == "yes")
{
if ($aff2masteradminapproveonly == "yes")
	{
$ssq = "select * from aff2solos where approved=1 and added=1 and sent=0";
	}
if ($aff2masteradminapproveonly != "yes")
	{
$ssq = "select * from aff2solos where approved=0 and added=1";
	}
$ssr = mysql_query($ssq) or die(mysql_error());
$ssrows = mysql_num_rows($ssr);
if ($ssrows == 0) 
{
?>
<input type="button" value="<?php echo $aff2soloname ?> Settings" style="font-size: 10px; width: 220px;" onclick="window.location='aff2solosettings.php'">
<?
}
else
{
?>
<input type="button" value="<?php echo $aff2soloname ?> Waiting" style="font-size: 10px; width: 220px;" class="ssw" onclick="window.location='aff2solosettings.php'">
<?
}
} # if ($aff2solothissiteactive == "yes")
?>
<?
if ($ozsolothisisadminsite == "yes")
{
?>
<input type="button" value="<?php echo $ozsoloname ?> Admin" style="font-size: 10px; width: 220px;" onclick="window.location='ozsolomasteradmin.php'">
<?
}
###########################################################################
if ($ozsolothissiteactive == "yes")
{
if ($ozmasteradminapproveonly == "yes")
	{
$ssq = "select * from ozsolos where approved=1 and added=1 and sent=0";
	}
if ($ozmasteradminapproveonly != "yes")
	{
$ssq = "select * from ozsolos where approved=0 and added=1";
	}
$ssr = mysql_query($ssq) or die(mysql_error());
$ssrows = mysql_num_rows($ssr);
if ($ssrows == 0) 
{
?>
<input type="button" value="<?php echo $ozsoloname ?> Settings" style="font-size: 10px; width: 220px;" onclick="window.location='ozsolosettings.php'">
<?
}
else
{
?>
<input type="button" value="<?php echo $ozsoloname ?> Waiting" style="font-size: 10px; width: 220px;" class="ssw" onclick="window.location='ozsolosettings.php'">
<?
}
} # if ($ozsolothissiteactive == "yes")
?>


		<input type="button" value="Admin Mail Config" style="font-size: 10px; width: 220px;" onclick="window.location='settings2.php'">
		<input type="button" value="<?php echo $lowerlevel ?> Settings" style="font-size: 10px; width: 220px;" onclick="window.location='settingslite.php'">
		<input type="button" value="<?php echo $middlelevel ?> Settings" style="font-size: 10px; width: 220px;" onclick="window.location='settingspro.php'">
		<input type="button" value="<?php echo $toplevel ?> Settings" style="font-size: 10px; width: 220px;" onclick="window.location='settingsgold.php'">
		<input type="button" value="Commission Settings" style="font-size: 10px; width: 220px;" onclick="window.location='settingscommission.php'">
		<input type="button" value="Text Ad Design" style="font-size: 10px; width: 220px;" onclick="window.location='textadsettings.php'">
		<input type="button" value="Top Side Ad Design" style="font-size: 10px; width: 220px;" onclick="window.location='topsideadsettings.php'">
		<input type="button" value="Fly-In Ad Design" style="font-size: 10px; width: 220px;" onclick="window.location='flyinadsettings.php'">
</td>
<td align="center" valign="top">
		<input type="button" value="Ad Ads to Member" style="font-size: 10px; width: 220px;" onclick="window.location='addads.php'">
		<input type="button" value="Upgrade Member" style="font-size: 10px; width: 220px;" onclick="window.location='upgrademember.php'">
		<input type="button" value="Add New Members" style="font-size: 10px; width: 220px;" onclick="window.location='addmember.php'">
		<input type="button" value="View Members" style="font-size: 10px; width: 220px;" onclick="window.location='view.php'">
		<input type="button" value="Search Members" style="font-size: 10px; width: 220px;" onclick="window.location='search.php'">
		<input type="button" value="Send All Verify" style="font-size: 10px; width: 220px;" onclick="window.location='sendallverify.php'">
		<input type="button" value="Top Referrers" style="font-size: 10px; width: 220px;" onclick="window.location='referrer.php'">
		<input type="button" value="Commission" style="font-size: 10px; width: 220px;" onclick="window.location='commission.php'">
</td>
<td align="center" valign="top">
		<input type="button" value="Sell Points" style="font-size: 10px; width: 220px;" onclick="window.location='pointstosell.php'">
		<input type="button" value="Sell Login Ads" style="font-size: 10px; width: 220px;" onclick="window.location='loginadstosell.php'">
		<input type="button" value="Sell Fly-In Ads" style="font-size: 10px; width: 220px;" onclick="window.location='flyinadstosell.php'">
		<input type="button" value="Sell CashClick Links" style="font-size: 10px; width: 220px;" onclick="window.location='cashclickstosell.php'">
		<input type="button" value="Sell CashClick Solos" style="font-size: 10px; width: 220px;" onclick="window.location='ptcsolostosell.php'">
		<input type="button" value="Sell TrafficLinks" style="font-size: 10px; width: 220px;" onclick="window.location='trafficlinkstosell.php'">
		<input type="button" value="Sell Top Side Ads" style="font-size: 10px; width: 220px;" onclick="window.location='topsideadstosell.php'">       
</td>
<td align="center" valign="top">
		<input type="button" value="View Admin Solos" style="font-size: 10px; width: 220px;" onclick="window.location='viewalladminsolos.php'">
<?php
if ($digitalsolothissiteactive == "yes")
{
?>
<input type="button" value="View <?php echo $digitalsoloname ?>" style="font-size: 10px; width: 220px;" onclick="window.location='viewalldigitalsolos.php'">
<?php
}
?>
<?php
if ($blazingsolothissiteactive == "yes")
{
?>
<input type="button" value="View <?php echo $blazingsoloname ?> Ads" style="font-size: 10px; width: 220px;" onclick="window.location='viewallblazingsolos.php'">
<?php
}
?>
<?php
if ($aff2solothissiteactive == "yes")
{
?>
<input type="button" value="View <?php echo $aff2soloname ?> Ads" style="font-size: 10px; width: 220px;" onclick="window.location='viewallaff2solos.php'">
<?php
}
?>
<?
if ($ozsolothissiteactive == "yes")
{
?>
<input type="button" value="View <?php echo $ozsoloname ?> Ads" style="font-size: 10px; width: 220px;" onclick="window.location='viewallozsolos.php'">
<?
}
?>

		<input type="button" value="View Solos" style="font-size: 10px; width: 220px;" onclick="window.location='viewallsolos.php'">
		<input type="button" value="View Banners" style="font-size: 10px; width: 220px;" onclick="window.location='viewallbanners.php'">
		<input type="button" value="View Buttons" style="font-size: 10px; width: 220px;" onclick="window.location='viewallbuttons.php'">
		<input type="button" value="View Text Post" style="font-size: 10px; width: 220px;" onclick="window.location='viewallads.php'">
		<input type="button" value="View Html Post" style="font-size: 10px; width: 220px;" onclick="window.location='viewallhtmlads.php'">
		<input type="button" value="View Text Ads" style="font-size: 10px; width: 220px;" onclick="window.location='viewalltextads.php'">
		<input type="button" value="View Login Ads" style="font-size: 10px; width: 220px;" onclick="window.location='viewallloginads.php'">	
</td>
<td align="center" valign="top">
		<input type="button" value="View Footer Ads" style="font-size: 10px; width: 220px;" onclick="window.location='viewallfooterads.php'">
		<input type="button" value="View CashClick Link Ads" style="font-size: 10px; width: 220px;" onclick="window.location='viewallcashclickads.php'">
		<input type="button" value="View CashClick Solo Ads" style="font-size: 10px; width: 220px;" onclick="window.location='viewallptcsoloads.php'">
		<input type="button" value="View Fly-In Ads" style="font-size: 10px; width: 220px;" onclick="window.location='viewallflyinads.php'">
		<input type="button" value="View TrafficLink Ads" style="font-size: 10px; width: 220px;" onclick="window.location='viewalltrafficlinkads.php'">
		<input type="button" value="View Top Side Ads" style="font-size: 10px; width: 220px;" onclick="window.location='viewalltopsideads.php'">
		<input type="button" value="View HotLinks" style="font-size: 10px; width: 220px;" onclick="window.location='viewallhotlink.php'">
		<input type="button" value="View HeadlineAds" style="font-size: 10px; width: 220px;" onclick="window.location='viewallheadlines.php'">
		<input type="button" value="View Tracking URLs" style="font-size: 10px; width: 220px;" onclick="window.location='viewalltrackingurls.php'">	
</td>
<td align="center" valign="top">
		<input type="button" value="Edit Pages" style="font-size: 10px; width: 220px;" onclick="window.location='editpages.php'">
		<input type="button" value="Edit Coupon Codes" style="font-size: 10px; width: 220px;" onclick="window.location='editcoupon.php'">
		<input type="button" value="Edit OTO" style="font-size: 10px; width: 220px;" onclick="window.location='editoto.php'">
		<input type="button" value="Special Offer" style="font-size: 10px; width: 220px;" onclick="window.location='editspecialoffer.php'">
		<input type="button" value="Extra Special Special!" style="font-size: 10px; width: 220px;" onclick="window.location='editextraspecialspecial.php'">
		<input type="button" value="Monthly Bonuses" style="font-size: 10px; width: 220px;" onclick="window.location='editmonthlybonuses.php'">
</td>
<td align="center" valign="top">
		<input type="button" value="Auto Transactions" style="font-size: 10px; width: 220px;" onclick="window.location='customertransactions.php'">
		<input type="button" value="Ban Domains" style="font-size: 10px; width: 220px;" onclick="window.location='bandomains.php'">
		<input type="button" value="Add Banners" style="font-size: 10px; width: 220px;" onclick="window.location='banners.php'">
		<input type="button" value="Edit Navigation" style="font-size: 10px; width: 220px;" onclick="window.location='navigation.php'">
		<input type="button" value="Logout" style="font-size: 10px; width: 220px;" onclick="window.location='logout.php'">		
</td>
</tr>
</table>
<br><br>