<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/learning/prolog.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/learning/include.php");
IncludeModuleLangFile(__FILE__);

ClearVars();

$strWarning = "";
$message = null;
$bVarsFromForm = false;
$ID = intval($ID);
$COURSE_ID = intval($COURSE_ID);
$CHAPTER_ID = intval($CHAPTER_ID);

$course = CCourse::GetByID($COURSE_ID);

if($arCourse = $course->Fetch())
	$bBadCourse=(CCourse::GetPermission($COURSE_ID)<"W");
else
	$bBadCourse = true;

$aTabs = array(
	array(
		"DIV" => "edit1",
		"ICON"=>"main_user_edit",
		"TAB" => GetMessage("LEARNING_ADMIN_TAB1"),
		"TITLE"=>GetMessage("LEARNING_ADMIN_TAB1_EX")
	),

	array(
		"DIV" => "edit2",
		"ICON"=>"main_user_edit",
		"TAB" => GetMessage("LEARNING_ADMIN_TAB2"),
		"TITLE"=>GetMessage("LEARNING_ADMIN_TAB2_EX")
	),

	array(
		"DIV" => "edit3",
		"ICON"=>"main_user_edit",
		"TAB" => GetMessage("LEARNING_ADMIN_TAB3"),
		"TITLE"=>GetMessage("LEARNING_ADMIN_TAB3_EX")
	),
);

$tabControl = new CAdminForm("chapterTabControl", $aTabs);

if (!$bBadCourse && $_SERVER["REQUEST_METHOD"] == "POST" && strlen($Update)>0 && check_bitrix_sessid())
{
	$arPREVIEW_PICTURE = $_FILES["PREVIEW_PICTURE"];
	$arPREVIEW_PICTURE["del"] = ${"PREVIEW_PICTURE_del"};
	$arPREVIEW_PICTURE["MODULE_ID"] = "learning";
	$arPREVIEW_PICTURE["description"] = ${"PREVIEW_PICTURE_descr"};

	$arDETAIL_PICTURE = $_FILES["DETAIL_PICTURE"];
	$arDETAIL_PICTURE["del"] = ${"DETAIL_PICTURE_del"};
	$arDETAIL_PICTURE["MODULE_ID"] = "learning";
	$arDETAIL_PICTURE["description"] = ${"DETAIL_PICTURE_descr"};

	$ch = new CChapter;

	$arFields = Array(
		"ACTIVE" => $ACTIVE,
		"CHAPTER_ID" => $CHAPTER_ID,
		"COURSE_ID" => $COURSE_ID,
		"NAME" => $NAME,
		"SORT" => $SORT,
		"CODE" => $CODE,

		"DETAIL_PICTURE" => $arDETAIL_PICTURE,
		"DETAIL_TEXT" => $DETAIL_TEXT,
		"DETAIL_TEXT_TYPE" => $DETAIL_TEXT_TYPE,

		"PREVIEW_PICTURE" => $arPREVIEW_PICTURE,
		"PREVIEW_TEXT" => $PREVIEW_TEXT,
		"PREVIEW_TEXT_TYPE" => $PREVIEW_TEXT_TYPE
	);



	if($ID>0)
	{
		$res = $ch->Update($ID, $arFields);
	}
	else
	{
		$ID = $ch->Add($arFields);
		$res = ($ID>0);
	}



	if(!$res)
	{
		//$strWarning .= $ch->LAST_ERROR."<br>";
		if($e = $APPLICATION->GetException())
			$message = new CAdminMessage(GetMessage("LEARNING_ERROR"), $e);
		$bVarsFromForm = true;
	}
	else
	{
		if(strlen($apply)<=0)
		{
			if($from == "learn_admin")
				LocalRedirect("/bitrix/admin/learn_course_admin.php?lang=".LANG."&".GetFilterParams("filter_", false));
			elseif (strlen($return_url)>0)
			{
				if(strpos($return_url, "#CHAPTER_ID#")!==false)
				{
					$return_url = str_replace("#CHAPTER_ID#", $ID, $return_url);
				}
				LocalRedirect($return_url);
			}
			else
				LocalRedirect("/bitrix/admin/learn_chapter_admin.php?lang=". LANG."&COURSE_ID=".$COURSE_ID.GetFilterParams("filter_", false));
		}

		LocalRedirect("/bitrix/admin/learn_chapter_edit.php?ID=".$ID."&CHAPTER_ID=".$CHAPTER_ID."&lang=". LANG."&COURSE_ID=".$COURSE_ID."&tabControl_active_tab=".urlencode($tabControl_active_tab).GetFilterParams("filter_", false));
	}
}

if (!$bBadCourse)
{
	if ($ID > 0)
		$APPLICATION->SetTitle($arCourse["NAME"].": ".GetMessage("LEARNING_CHAPTERS").": ".GetMessage("LEARNING_EDIT_TITLE"));
	else
		$APPLICATION->SetTitle($arCourse["NAME"].": ".GetMessage('LEARNING_CHAPTERS').": ".GetMessage("LEARNING_NEW_TITLE"));
}
else
	$APPLICATION->SetTitle(GetMessage('LEARNING_CHAPTERS').": ".GetMessage("LEARNING_EDIT_TITLE"));


//Defaults
$str_ACTIVE = "Y";
$str_DETAIL_TEXT_TYPE = $str_PREVIEW_TEXT_TYPE = "text";
$str_SORT = "500";
$str_CHAPTER_ID = $CHAPTER_ID;

$result = CChapter::GetByID($ID);
if(!$result->ExtractFields("str_"))
	$ID = 0;

if($bVarsFromForm)
{
	$ACTIVE = ($ACTIVE != "Y"? "N":"Y");
	$DB->InitTableVarsForEdit("b_learn_chapter", "", "str_");
}



//$adminChain->AddItem(array("TEXT"=>htmlspecialcharsex($arCourse["NAME"]), "LINK"=>"learn_chapter_admin.php?lang=".LANG."&COURSE_ID=".$COURSE_ID.GetFilterParams("filter_")."&filter_chapter_id="));


if(intval($CHAPTER_ID)>0)
{
	/*$nav = CChapter::GetNavChain($COURSE_ID, $str_CHAPTER_ID);
	while($nav->ExtractFields("nav_"))
	{
		$adminChain->AddItem(array("TEXT"=>$nav_NAME, "LINK"=>"learn_chapter_admin.php?lang=".LANG."&COURSE_ID=".$COURSE_ID.GetFilterParams("filter_")."&filter_chapter_id=".$nav_ID));
	}*/
}
else
{
	$adminChain->AddItem(array("TEXT"=>"<b>".GetMessage("LEARNING_CONTENT")."</b>", "LINK"=>""));
}


require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");


if (!$bBadCourse):


$aContext = array(
	array(
		"ICON" => "btn_list",
		"TEXT"=>GetMessage("MAIN_ADMIN_MENU_LIST"),
		"LINK"=>"learn_chapter_admin.php?COURSE_ID=".$COURSE_ID."&lang=".LANG.GetFilterParams("filter_"),
		"TITLE"=>GetMessage("MAIN_ADMIN_MENU_LIST")
	),
);


if ($ID > 0)
{
	$aContext[] = 	array(
		"ICON" => "btn_new",
		"TEXT"=>GetMessage("MAIN_ADMIN_MENU_CREATE"),
		"LINK"=>"learn_chapter_edit.php?COURSE_ID=".$COURSE_ID."&CHAPTER_ID=".$CHAPTER_ID."&lang=".LANG.GetFilterParams("filter_"),
		"TITLE"=>GetMessage("LEARNING_ADD")
	);

	$aContext[] = 	array(
		"ICON" => "btn_delete",
		"TEXT"=>GetMessage("MAIN_ADMIN_MENU_DELETE"),
		"LINK"	=> "javascript:if(confirm('".GetMessage("LEARNING_CONFIRM_DEL_MESSAGE")."'))window.location='learn_chapter_admin.php?COURSE_ID=".$COURSE_ID."&action=delete&ID=".$ID."&lang=".LANG."&".bitrix_sessid_get().urlencode(GetFilterParams("filter_", false))."';",
	);

}

$link = DeleteParam(array("mode"));
$link = $GLOBALS["APPLICATION"]->GetCurPage()."?mode=settings".($link <> ""? "&".$link:"");
$aContext[] = array(
	"TEXT"=>GetMessage("LEARNING_FORM_SETTINGS"),
	"TITLE"=>GetMessage("LEARNING_FORM_SETTINGS_EX"),
	"LINK"=>"javascript:".$tabControl->GetName().".ShowSettings('".urlencode($link)."')",
	"ICON"=>"btn_settings",
);

$context = new CAdminContextMenu($aContext);
$context->Show();

if(COption::GetOptionString("learning", "use_htmledit", "Y")=="Y" && CModule::IncludeModule("fileman"))
{
	//TODO:This dirty hack will be replaced by special method like calendar do
	echo '<div style="display:none">';
	CFileMan::AddHTMLEditorFrame(
		"SOME_TEXT",
		"",
		"SOME_TEXT_TYPE",
		"text",
		array(
			'height' => 450,
			'width' => '100%'
		),
		"N",
		0,
		"",
		"",
		false
	);
	echo '</div>';
}

if($message)
	echo $message->Show();

$tabControl->arParams["FORM_ACTION"] = $APPLICATION->GetCurPage()."?lang=".LANG."&COURSE_ID=".$COURSE_ID;

?>
<?php $tabControl->BeginEpilogContent();?>
	<?=bitrix_sessid_post()?>
	<?echo GetFilterHiddens("filter_");?>
	<input type="hidden" name="Update" value="Y">
	<input type="hidden" name="ID" value="<?echo $ID?>">
	<input type="hidden" name="from" value="<?echo htmlspecialchars($from)?>">
	<?if(strlen($return_url)>0):?><input type="hidden" name="return_url" value="<?=htmlspecialchars($return_url)?>"><?endif?>
<?php
$tabControl->EndEpilogContent();
$tabControl->Begin();
$tabControl->BeginNextFormTab();
?>
<!-- ID -->
<?php $tabControl->BeginCustomField("ID", "ID", false);?>
	<?if($ID>0):?>
		<tr>
			<td><?echo $tabControl->GetCustomLabelHTML()?>:</td>
			<td><?=$str_ID?></td>
		</tr>
	<? endif; ?>
<?php $tabControl->EndCustomField("ID");?>
<!-- Timestamp_X -->
<?php $tabControl->BeginCustomField("TIMESTAMP_X", GetMessage("LEARNING_LAST_UPDATE"), false);?>
	<?if($ID>0):?>
		<tr>
			<td><?echo $tabControl->GetCustomLabelHTML()?>:</td>
			<td><?=$str_TIMESTAMP_X?></td>
		</tr>
	<? endif; ?>
<?php $tabControl->EndCustomField("TIMESTAMP_X");?>
<?php $tabControl->BeginCustomField("ACTIVE", GetMessage("LEARNING_ACTIVE"), false);?>
<!-- Active -->
	<tr>
		<td><?echo $tabControl->GetCustomLabelHTML()?>:</td>
		<td><input type="checkbox" name="ACTIVE" value="Y"<?if($str_ACTIVE=="Y")echo " checked"?>></td>
	</tr>
<?php $tabControl->EndCustomField("ACTIVE");?>
<?php $tabControl->BeginCustomField("CHAPTER_ID", GetMessage("LEARNING_PARENT_CHAPTER_ID"), false);?>
	<tr>
		<td><?echo $tabControl->GetCustomLabelHTML()?>:</td>
		<td>
		<?$l = CChapter::GetTreeList($COURSE_ID);?>
		<select name="CHAPTER_ID" style="width:60%;">
			<option value="0"><?echo GetMessage("LEARNING_CONTENT")?></option>
		<?
			while($l->ExtractFields("l_")):
				?><option value="<?echo $l_ID?>"<?if($str_CHAPTER_ID == $l_ID)echo " selected"?>><?echo str_repeat("&nbsp;.&nbsp;", $l_DEPTH_LEVEL)?><?echo $l_NAME?></option><?
			endwhile;
		?>
		</select>
		</td>
	</tr>
<?php $tabControl->EndCustomField("CHAPTER_ID");?>
<?php $tabControl->BeginCustomField("NAME", GetMessage("LEARNING_NAME"), true);?>
	<tr>
		<td><?echo $tabControl->GetCustomLabelHTML()?>:</td>
		<td valign="top">
			<input type="text" name="NAME" size="50" maxlength="255" value="<?echo $str_NAME?>">
		</td>
	</tr>
<?php $tabControl->EndCustomField("NAME");?>
<?php $tabControl->BeginCustomField("SORT", GetMessage("LEARNING_SORT"), false);?>
<!-- Sort -->
	<tr>
		<td><? echo $tabControl->GetCustomLabelHTML()?>:</td>
		<td>
			<input type="text" name="SORT" size="10" maxlength="10" value="<?echo $str_SORT?>">
		</td>
	</tr>
<?php $tabControl->EndCustomField("SORT");?>
<?php $tabControl->BeginCustomField("CODE", GetMessage("LEARNING_CODE"), false);?>
<!-- CODE -->
	<tr>
		<td><? echo $tabControl->GetCustomLabelHTML()?>:</td>
		<td>
			<input type="text" name="CODE" size="20" maxlength="40" value="<?=$str_CODE?>">
		</td>
	</tr>
<?php $tabControl->EndCustomField("CODE");?>

<?$tabControl->BeginNextFormTab();?>
<?php $tabControl->BeginCustomField("PREVIEW_TEXT", GetMessage("LEARNING_PREVIEW_TEXT"), false);?>
	<?if(COption::GetOptionString("learning", "use_htmledit", "Y")=="Y" && CModule::IncludeModule("fileman")):?>
	<tr>
		<td colspan="2" align="center">
			<?CFileMan::AddHTMLEditorFrame(
				"PREVIEW_TEXT",
				$str_PREVIEW_TEXT,
				"PREVIEW_TEXT_TYPE",
				$str_PREVIEW_TEXT_TYPE,
				200,
				"N",
				0,
				"",
				"",
				false,
				true,
				false,
				array('toolbarConfig' => CFileman::GetEditorToolbarConfig("learning_".(defined('BX_PUBLIC_MODE') && BX_PUBLIC_MODE == 1 ? 'public' : 'admin')))
			);?>
		</td>
	</tr>
	<?else:?>
	<tr>
		<td align="center"><?echo GetMessage("LEARNING_DESC_TYPE")?>:</td>
		<td>
			<input type="radio" name="PREVIEW_TEXT_TYPE" value="text"<?if($str_PREVIEW_TEXT_TYPE!="html")echo " checked"?>> <?echo GetMessage("LEARNING_DESC_TYPE_TEXT")?> / <input type="radio" name="PREVIEW_TEXT_TYPE" value="html"<?if($str_PREVIEW_TEXT_TYPE=="html")echo " checked"?>> <?echo GetMessage("LEARNING_DESC_TYPE_HTML")?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<textarea style="width:100%; height:200px;" name="PREVIEW_TEXT" wrap="virtual"><?echo $str_PREVIEW_TEXT?></textarea>
		</td>
	</tr>
	<?endif?>
<?php $tabControl->EndCustomField("PREVIEW_TEXT");?>
<?php $tabControl->BeginCustomField("PREVIEW_PICTURE", GetMessage("LEARNING_PICTURE"), false);?>
	<tr>
		<td valign="top"><?echo $tabControl->GetCustomLabelHTML()?></td>
		<td>
			<?echo CFile::InputFile("PREVIEW_PICTURE", 20, $str_PREVIEW_PICTURE, false, 0, "IMAGE", "", 40);?><br>
			<?
				if($str_PREVIEW_PICTURE)
				{
					echo CFile::ShowImage($str_PREVIEW_PICTURE, 200, 200, "border=0", "", true);
				}
			?>
		</td>
	</tr>
<?php $tabControl->EndCustomField("PREVIEW_PICTURE");?>

<?$tabControl->BeginNextFormTab();?>
<?php $tabControl->BeginCustomField("DESCRIPTION", GetMessage("LEARNING_DESCRIPTION"), false);?>
	<?if(COption::GetOptionString("learning", "use_htmledit", "Y")=="Y" && CModule::IncludeModule("fileman")):?>
	<tr>
		<td colspan="2" align="center">
			<?CFileMan::AddHTMLEditorFrame(
				"DETAIL_TEXT",
				$str_DETAIL_TEXT,
				"DETAIL_TEXT_TYPE",
				$str_DETAIL_TEXT_TYPE,
				250,
				"N",
				0,
				"",
				"",
				false,
				true,
				false,
				array('toolbarConfig' => CFileman::GetEditorToolbarConfig("learning_".(defined('BX_PUBLIC_MODE') && BX_PUBLIC_MODE == 1 ? 'public' : 'admin')))
			);?>
		</td>
	</tr>
	<?else:?>
	<tr>
		<td align="center"><?echo GetMessage("LEARNING_DESC_TYPE")?>:</td>
		<td>
			<input type="radio" name="DETAIL_TEXT_TYPE" value="text"<?if($str_DETAIL_TEXT_TYPE!="html")echo " checked"?>> <?echo GetMessage("LEARNING_DESC_TYPE_TEXT")?>
			<input type="radio" name="DETAIL_TEXT_TYPE" value="html"<?if($str_DETAIL_TEXT_TYPE=="html")echo " checked"?>> <?echo GetMessage("LEARNING_DESC_TYPE_HTML")?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<textarea style="width:100%; height:250px;" name="DESCRIPTION" wrap="off"><?echo $str_DESCRIPTION?></textarea>
		</td>
	</tr>
	<?endif?>
<?php $tabControl->EndCustomField("DESCRIPTION");?>
<?php $tabControl->BeginCustomField("DETAIL_PICTURE", GetMessage("LEARNING_PICTURE"), false);?>
	<tr>
		<td valign="top"><?echo $tabControl->GetCustomLabelHTML()?></td>
		<td>
			<?echo CFile::InputFile("DETAIL_PICTURE", 20, $str_DETAIL_PICTURE, false, 0, "IMAGE", "", 40);?><br>
			<?
				if ($str_DETAIL_PICTURE)
				{
					echo CFile::ShowImage($str_DETAIL_PICTURE, 200, 200, "border=0", "", true);
				}
			?>
		</td>
	</tr>
<?php $tabControl->EndCustomField("DETAIL_PICTURE");?>

<?php $tabControl->Buttons(Array("back_url" =>"learn_chapter_admin.php?lang=". LANG."&COURSE_ID=".$COURSE_ID.GetFilterParams("filter_", false)));?>
<?php $tabControl->arParams["FORM_ACTION"] = $APPLICATION->GetCurPage()."?lang=".LANG."&COURSE_ID=".$COURSE_ID;?>
<?php $tabControl->Show();?>
<?$tabControl->ShowWarnings($tabControl->GetName(), $message);?>

<?echo BeginNote();?>
<span class="required">*</span> - <?echo GetMessage("REQUIRED_FIELDS")?>
<?echo EndNote();?>

<?else: //if (!$bBadCourse)

$aContext = array(
	array(
		"ICON" => "btn_list",
		"TEXT"=>GetMessage("MAIN_ADMIN_MENU_LIST"),
		"LINK"=>"learn_course_admin.php?lang=".LANG.GetFilterParams("filter_"),
		"TITLE"=>GetMessage("LEARNING_BACK_TO_ADMIN")
	),
);

$context = new CAdminContextMenu($aContext);
$context->Show();

CAdminMessage::ShowMessage(GetMessage("LEARNING_BAD_COURSE"));
endif?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");?>