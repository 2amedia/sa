<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if (($componentPage == "user_photo_element_upload" || 
	$componentPage == "group_photo_element_upload") && $_REQUEST["save_upload"] == "Y" && 
	check_bitrix_sessid())
{
	$object = ($componentPage == "group_photo_element_upload" ? "group" : "user");
	if ($object == "group")
		CSocNetGroup::SetLastActivity($arResult["VARIABLES"]["group_id"], false);

	if (!empty($arParams["ANSWER_UPLOAD_PAGE"]) && !empty($_REQUEST["PackageGuid"]))
	{
		$files = $arParams["ANSWER_UPLOAD_PAGE"]["current_files"];
		$error = false;
		foreach ($files as $file)
		{
			if ($file["status"] != "success")
			{
				$error = true;
				continue;
			}
		}

		$result = $arParams["ANSWER_UPLOAD_PAGE"];
		unset($result["current_files"]);
		$error = ($error ? $error : !empty($result["fatal_errors"]));
		if ($_REQUEST["AJAX_CALL"] == "Y")
		{
			if ($_REQUEST["CONVERT"] == "Y")
			{
				//include_once($_SERVER['DOCUMENT_ROOT'].BX_ROOT."/componens/bitrix/photogallery.upload/functions.php"); 
				//array_walk($result, '__Escape');
			}
			$APPLICATION->RestartBuffer();
			?><?=CUtil::PhpToJSObject($result);?><?
			die();
		}
		elseif (!$error)
		{
			LocalRedirect($arParams["ANSWER_UPLOAD_PAGE"]["url"]);
		}
	}
}
?>