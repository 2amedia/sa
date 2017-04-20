<?
define("ADMIN_MODULE_NAME", "cluster");
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
IncludeModuleLangFile(__FILE__);

if(!$USER->IsAdmin())
	$APPLICATION->AuthForm(GetMessage("ACCESS_DENIED"));

if(!CModule::IncludeModule('cluster'))
	$APPLICATION->AuthForm(GetMessage("ACCESS_DENIED"));


$group_id = intval($_GET["group_id"]);
$arGroup = CClusterGroup::GetArrayByID($group_id);
if(!$arGroup)
	$APPLICATION->AuthForm(GetMessage("ACCESS_DENIED"));

$APPLICATION->SetTitle($arGroup["NAME"]);
if($_REQUEST["mode"] == "list")
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_js.php");
else
	require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");

$adminPage->ShowSectionIndex("cluser_group_".$group_id, "cluster", false);

if($_REQUEST["mode"]!='list' && $_REQUEST["mode"]!='frame')
{
	$aContext = array(
		array(
			"TEXT"=>GetMessage("CLU_INDEX_EDIT_GROUP"),
			"TITLE"=>GetMessage("CLU_INDEX_EDIT_GROUP_TITLE"),
			"LINK" => "cluster_group_edit.php?lang=".LANG."&ID=".$group_id,
			"ICON" => "btn_edit",
		),
	);
	$context = new CAdminContextMenu($aContext);
	$context->Show();
}

if($_REQUEST["mode"] == "list")
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin_js.php");
else
	require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");
?>
