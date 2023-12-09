<?php
if (!defined('IN_WEBADMIN'))
	exit();

if (hmailGetAdminLevel() != 2)
	hmailHackingAttemp();

$obWhiteListAddresses = $obBaseApp->Settings()->AntiSpam()->WhiteListAddresses;
$Count = $obWhiteListAddresses->Count();
?>
    <div class="box large">
      <h2><?php EchoTranslation("White listing") ?> <span>(<?php echo $Count ?>)</span></h2>
      <table class="tablesort">
        <thead>
          <tr>
            <th data-sort="string"><?php EchoTranslation("Description")?></th>
            <th style="width:25%;" data-sort="string"><?php EchoTranslation("Lower IP")?></th>
            <th style="width:25%;" data-sort="string"><?php EchoTranslation("Upper IP")?></th>
            <th style="width:20%;" data-sort="string"><?php EchoTranslation("E-mail address")?></th>
            <th style="width:32px;" class="no-sort">&nbsp;</th>
          </tr>
        </thead>
        <tbody>
<?php
$str_yes = Translate("Yes");
$str_no = Translate("No");
$str_delete = Translate("Remove");
$str_confirm = Translate("Confirm delete");

if ($Count>0) {
	for ($i=0; $i<$Count; $i++) {
		$obAddress = $obWhiteListAddresses->Item($i);
		$ID = $obAddress->ID;
		$LowerIPAddress = $obAddress->LowerIPAddress;
		$UpperIPAddress = $obAddress->UpperIPAddress;
		$EmailAddress = $obAddress->EmailAddress;
		$Description = $obAddress->Description;
		$EmailAddress = PreprocessOutput($EmailAddress);
		$Description = PreprocessOutput($Description);

		echo '          <tr>
            <td><a href="?page=whitelistaddress&action=edit&ID=' . $ID . '">' . $Description . '</a></td>
            <td><a href="?page=whitelistaddress&action=edit&ID=' . $ID . '">' . $LowerIPAddress . '</a></td>
            <td><a href="?page=whitelistaddress&action=edit&ID=' . $ID . '">' . $UpperIPAddress . '</a></td>
            <td><a href="?page=whitelistaddress&action=edit&ID=' . $ID . '">' . $EmailAddress . '</a></td>
            <td><a href="#" onclick="return Confirm(\'' . $str_confirm . ' <b>' . $Description . '</b>:\',\'' . $str_yes . '\',\'' . $str_no . '\',\'?page=background_whitelistaddress_save&csrftoken=' . $csrftoken . '&action=delete&ID=' . $ID . '\');" class="delete" title="' . $str_delete . '">' . $str_delete . '</a></td>
          </tr>' . PHP_EOL;
	}
} else {
	echo '          <tr class="empty">
            <td colspan="5">' . Translate("You haven't added any whitelists.") . '</td>
          </tr>' . PHP_EOL;
}
?>
        </tbody>
      </table>
      <div class="buttons center"><a href="?page=whitelistaddress&action=add" class="button"><?php EchoTranslation("Add new whitelist") ?></a></div>
    </div>