<?php
if (!defined('IN_WEBADMIN'))
	exit();

if (hmailGetAdminLevel() != 2)
	hmailHackingAttemp(); // The user is not server administrator

$securityrangeid = hmailGetVar("securityrangeid",0);
$action = hmailGetVar("action","");

$securityrangename = "";
$securityrangepriority = 100;
$securityrangelowerip = "0.0.0.0";
$securityrangeupperip = "255.255.255.255";

$allowsmtpconnections = 1;
$allowpop3connections = 1;
$allowimapconnections = 1;

$allowlocaltolocal = 1;
$allowlocaltoremote = 1;
$allowremotetolocal = 1;
$allowremotetoremote = 0;

$enablespamprotection = 0;
$IsForwardingRelay = 0;
$EnableAntiVirus = 0;
$RequireSSLTLSForAuth = 0;

$RequireSMTPAuthLocalToLocal = true;
$RequireSMTPAuthLocalToExternal = true;
$RequireSMTPAuthExternalToLocal = false;
$RequireSMTPAuthExternalToExternal = true;

$Expires = false;
$ExpiresTime = "";

if ($action == "edit") {
	$obSecurityRange = $obBaseApp->Settings->SecurityRanges->ItemByDBID($securityrangeid);

	$securityrangename = $obSecurityRange->Name;
	$securityrangepriority = $obSecurityRange->Priority;
	$securityrangelowerip = $obSecurityRange->LowerIP;
	$securityrangeupperip = $obSecurityRange->UpperIP;

	$allowsmtpconnections = $obSecurityRange->AllowSMTPConnections;
	$allowpop3connections = $obSecurityRange->AllowPOP3Connections;
	$allowimapconnections = $obSecurityRange->AllowIMAPConnections;

	$allowlocaltolocal = $obSecurityRange->AllowDeliveryFromLocalToLocal;
	$allowlocaltoremote = $obSecurityRange->AllowDeliveryFromLocalToRemote;
	$allowremotetolocal = $obSecurityRange->AllowDeliveryFromRemoteToLocal;
	$allowremotetoremote = $obSecurityRange->AllowDeliveryFromRemoteToRemote;

	$enablespamprotection = $obSecurityRange->EnableSpamProtection;
	$EnableAntiVirus = $obSecurityRange->EnableAntiVirus;
	$IsForwardingRelay = $obSecurityRange->IsForwardingRelay;
	$RequireSSLTLSForAuth = $obSecurityRange->RequireSSLTLSForAuth;

	$RequireSMTPAuthLocalToLocal = $obSecurityRange->RequireSMTPAuthLocalToLocal;
	$RequireSMTPAuthLocalToExternal = $obSecurityRange->RequireSMTPAuthLocalToExternal;
	$RequireSMTPAuthExternalToLocal = $obSecurityRange->RequireSMTPAuthExternalToLocal;
	$RequireSMTPAuthExternalToExternal = $obSecurityRange->RequireSMTPAuthExternalToExternal;

	$Expires = $obSecurityRange->Expires;
	$ExpiresTime = makeIsoDate($obSecurityRange->ExpiresTime);
}

//$allowsmtpconnectionschecked = hmailCheckedIf1($allowsmtpconnections);
//$allowpop3connectionschecked = hmailCheckedIf1($allowpop3connections);
//$allowimapconnectionschecked = hmailCheckedIf1($allowimapconnections);

//$allowlocaltolocalchecked = hmailCheckedIf1($allowlocaltolocal);
//$allowlocaltoremotechecked = hmailCheckedIf1($allowlocaltoremote);
//$allowremotetolocalchecked = hmailCheckedIf1($allowremotetolocal);
//$allowremotetoremotechecked = hmailCheckedIf1($allowremotetoremote);

$IsForwardingRelayChecked = hmailCheckedIf1($IsForwardingRelay);
?>
    <div class="box medium">
      <h2><?php EchoTranslation("IP range") ?></h2>
      <form action="index.php" method="post" class="form">
<?php
PrintHiddenCsrfToken();
PrintHidden("page", "background_securityrange_save");
PrintHidden("action", $action);
PrintHidden("securityrangeid", $securityrangeid);

PrintPropertyEditRow("securityrangename", "Name", $securityrangename, 100);

$str_yes = Translate("Yes");
$str_no = Translate("No");
$str_delete = Translate("Remove");
$str_confirm = Translate("Confirm delete");

if ($securityrangeid>0) echo '<div class="buttons bottom"><a href="#" onclick="return Confirm(\'' . $str_confirm . ' <b>' . $securityrangename . '</b>:\',\'' . $str_yes . '\',\'' . $str_no . '\',\'?page=background_securityrange_save&csrftoken=' . $csrftoken . '&action=delete&securityrangeid=' . $securityrangeid . '\');" class="button">' . $str_delete . '</a></div>';

PrintPropertyEditRow("securityrangepriority", "Priority", $securityrangepriority, 5, "number", "small");
PrintPropertyEditRow("securityrangelowerip", "Lower IP", $securityrangelowerip, 30, "ip");
PrintPropertyEditRow("securityrangeupperip", "Upper IP", $securityrangeupperip, 30, "ip");

if ($securityrangeid>0) {
?>
         <p><?php EchoTranslation("Country") ?></p>
         <b><?php echo GeoIp($securityrangelowerip) ?></b>
 <?php
}

PrintCheckboxRow("Expires", "Expires", $Expires);
PrintPropertyEditRow("ExpiresTime", "Use ISO date format (YYYY-MM-DD HH:MM:SS)", $ExpiresTime);
?>
        <h3><a href="#"><?php EchoTranslation("Allow connections")?></a></h3>
        <div class="hidden">
<?php
PrintCheckboxRow("allowsmtpconnections", "SMTP", $allowsmtpconnections);
PrintCheckboxRow("allowpop3connections", "POP3", $allowpop3connections);
PrintCheckboxRow("allowimapconnections", "IMAP", $allowimapconnections);
?>
        </div>
        <h3><a href="#"><?php EchoTranslation("Allow deliveries from")?></a></h3>
        <div class="hidden">
<?php
PrintCheckboxRow("allowlocaltolocal", "Local to local e-mail addresses", $allowlocaltolocal);
PrintCheckboxRow("allowlocaltoremote", "Local to external e-mail addresses", $allowlocaltoremote);
PrintCheckboxRow("allowremotetolocal", "External to local e-mail addresses", $allowremotetolocal);
PrintCheckboxRow("allowremotetoremote", "External to external e-mail addresses", $allowremotetoremote);
?>
        </div>
        <h3><a href="#"><?php EchoTranslation("Require SMTP authentication")?></a></h3>
        <div class="hidden">
<?php
PrintCheckboxRow("RequireSMTPAuthLocalToLocal", "Local to local e-mail addresses", $RequireSMTPAuthLocalToLocal);
PrintCheckboxRow("RequireSMTPAuthLocalToExternal", "Local to external e-mail addresses", $RequireSMTPAuthLocalToExternal);
PrintCheckboxRow("RequireSMTPAuthExternalToLocal", "External to local e-mail addresses", $RequireSMTPAuthExternalToLocal);
PrintCheckboxRow("RequireSMTPAuthExternalToExternal", "External to external e-mail addresses", $RequireSMTPAuthExternalToExternal);
?>
        </div>
        <h3><a href="#"><?php EchoTranslation("Other")?></a></h3>
        <div class="hidden">
<?php
PrintCheckboxRow("enablespamprotection", "Anti-spam", $enablespamprotection);
PrintCheckboxRow("EnableAntiVirus", "Anti-virus", $EnableAntiVirus);
PrintCheckboxRow("RequireSSLTLSForAuth", "Require SSL/TLS for authentication", $RequireSSLTLSForAuth);
?>
        </div>
<?php
PrintSaveButton(null, null, '?page=securityranges');
?>
      </form>
    </div>