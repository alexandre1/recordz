<?php
if (!defined('IN_WEBADMIN'))
	exit();

if (hmailGetAdminLevel() != 2)
	hmailHackingAttemp(); // Users are not allowed to show this page.
?>
    <div class="box large">
      <h2><?php EchoTranslation("Addresses") ?></h2>
      <table>
        <thead>
          <tr>
            <th><?php EchoTranslation("Name") ?></th>
            <th style="width:32px;">&nbsp;</th>
          </tr>
        </thead>
        <tbody>
<?php
$routeid = hmailGetVar("routeid",0);

$obRoutes = $obSettings->Routes();
$obRoute = $obRoutes->ItemByDBID($routeid);
$obAddresses = $obRoute->Addresses();

$Count = $obAddresses->Count();

$str_yes = Translate("Yes");
$str_no = Translate("No");
$str_delete = Translate("Remove");
$str_confirm = Translate("Confirm delete");

if ($Count>0) {
	for ($i=0; $i<$Count; $i++) {
		$obAddress = $obAddresses->Item($i);
		$routeaddress = PreprocessOutput($obAddress->Address);
		$routeaddressid = $obAddress->ID;

		echo '          <tr>
            <td><a href="?page=route_address&action=edit&routeid=' . $routeid . '&routeaddressid=' . $routeaddressid . '">' . $routeaddress . '</a></td>
            <td><a href="#" onclick="return Confirm(\'' . $str_confirm . ' <b>' . $routeaddress . '</b>:\',\'' . $str_yes . '\',\'' . $str_no . '\',\'?page=background_route_address_save&csrftoken=' . $csrftoken . '&action=delete&routeid=' . $routeid . '&routeaddressid=' . $routeaddressid . '\');" class="delete" title="' . $str_delete . '">' . $str_delete . '</a></td>
          </tr>' . PHP_EOL;
	}
} else {
	echo '          <tr class="empty">
            <td colspan="2">' . Translate("You haven't added any routes.") . '</td>
          </tr>' . PHP_EOL;
}
?>
        </tbody>
      </table>
      <div class="buttons center"><a href="?page=route_address&action=add&routeid=<?php echo $routeid?>" class="button"><?php EchoTranslation("Add new address") ?></a></div>
    </div>