<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$file = trim(preg_replace("'[\\\\/]+'", "/", (dirname(__FILE__)."/../lang/".LANGUAGE_ID."/include/webdav_forum.php")));
__IncludeLang($file);

$obDavForumEventHandler = new CSocNetWebDavForumEvent;
$obDavForumEventHandler->SetVars($arParams, $arResult);

AddEventHandler("forum", "onAfterMessageAdd", array($obDavForumEventHandler, "onAfterMessageAdd"));

class CSocNetWebDavForumEvent
{
    var $arPath;
	var $ForumID = null;

    function SetVars($arParams, $arResult)
    {
		$this->arPath["PATH_TO_SMILE"] = $arParams["PATH_TO_SMILE"];
		$this->arPath["PATH_TO_USER"] = $arResult["~PATH_TO_USER"];
		$this->arPath["PATH_TO_GROUP_FILES_ELEMENT"] = $arResult["~PATH_TO_GROUP_FILES_ELEMENT"];
		$this->arPath["PATH_TO_USER_FILES_ELEMENT"] = $arResult["~PATH_TO_USER_FILES_ELEMENT"];
		$this->ForumID = $arParams["FILES_FORUM_ID"];
		$this->bIsGroup = array_key_exists("GROUP", $arResult);
		$this->entity_id = ($this->bIsGroup ? $arParams["OBJECT"]->attributes["group_id"] : $arParams["OBJECT"]->attributes["user_id"]);
	}

	function onAfterMessageAdd($ID, $arFields)
	{
		// add log comment
		if (
			(
				!array_key_exists("PARAM1", $arFields)
				|| $arFields["PARAM1"] != "IB"
			)
			&& array_key_exists("PARAM2", $arFields)
			&& intval($arFields["PARAM2"]) > 0
		)
		{
			$dbRes = CSocNetLog::GetList(
				array("ID" => "DESC"),
				array(
					"EVENT_ID" => "files",
					"SOURCE_ID" => $arFields["PARAM2"] // file element id
				),
				false,
				false,
				array("ID", "ENTITY_TYPE", "ENTITY_ID", "TMP_ID")
			);

			if ($arRes = $dbRes->Fetch())
			{
				$log_id = $arRes["TMP_ID"];
				$entity_type = $arRes["ENTITY_TYPE"];
				$entity_id = $arRes["ENTITY_ID"];
			}
			else
			{
				$rsElement = CIBlockElement::GetByID($arFields["PARAM2"]);
				if ($arElement = $rsElement->Fetch())
				{
					$url = ($this->bIsGroup ? $this->arPath["PATH_TO_GROUP_FILES_ELEMENT"] : $this->arPath["PATH_TO_USER_FILES_ELEMENT"]);

					$sAuthorName = GetMessage("SONET_LOG_GUEST");
					$sAuthorUrl = "";
					if (intval($arElement["CREATED_BY"]) > 0)
					{
						$rsUser = CUser::GetByID($arElement["CREATED_BY"]);
						if ($arUser = $rsUser->Fetch())
						{
							$sAuthorName = CUser::FormatName("#NAME# #LAST_NAME#", $arUser, true, false);
							$sAuthorUrl = CComponentEngine::MakePathFromTemplate($this->arPath["PATH_TO_USER"], 
								array("USER_ID" => $arElement["CREATED_BY"]));							
						}
					}

					$entity_type = ($this->bIsGroup ? SONET_ENTITY_GROUP : SONET_ENTITY_USER);
					$entity_id =$this->entity_id;

					$arSonetFields = array(
						"ENTITY_TYPE" => $entity_type,
						"ENTITY_ID" => $entity_id,
						"EVENT_ID" => "files",
						"LOG_DATE" => $arElement["TIMESTAMP_X"],
						"TITLE_TEMPLATE" => str_replace("#AUTHOR_NAME#", $sAuthorName, GetMessage("SONET_FILES_LOG")),
						"TITLE" => $arElement["NAME"],
						"URL" => CComponentEngine::MakePathFromTemplate($url, array(
							"ELEMENT_ID" => $arElement["ID"],
							"group_id" => ($this->bIsGroup ? intval($this->entity_id) : 0),
							"user_id" => (!$this->bIsGroup ? intval($this->entity_id) : 0),
							"element_id" => $arElement["ID"]
						)),
						"MODULE_ID" => false,
						"CALLBACK_FUNC" => false,
						"SOURCE_ID" => $arElement["ID"],
						"PARAMS" => "forum_id=".intval($this->ForumID),
						"RATING_TYPE_ID" => "IBLOCK_ELEMENT",
						"RATING_ENTITY_ID" => intval($arElement["ID"])
					);

					if (intval($arElement["CREATED_BY"]) > 0)
						$arSonetFields["USER_ID"] = $arElement["CREATED_BY"];

					$serverName = (defined("SITE_SERVER_NAME") && strLen(SITE_SERVER_NAME) > 0) ? SITE_SERVER_NAME : COption::GetOptionString("main", "server_name");
					$arSonetFields["MESSAGE"] = str_replace(array("#AUTHOR_NAME#", "#AUTHOR_URL#"), array(htmlspecialcharsEx($sAuthorName), $sAuthorUrl), 
					(intval($arElement["CREATED_BY"]) > 0 ? GetMessage("SONET_LOG_TEMPLATE_AUTHOR") : GetMessage("SONET_LOG_TEMPLATE_GUEST")).""); 
					$arSonetFields["TEXT_MESSAGE"] = str_replace(array("#URL#", "#TITLE#"),
						array("http://".$serverName.$arSonetFields["URL"],  $arSonetFields["TITLE"]), 
						GetMessage("SONET_FILES_LOG_TEXT")); 

					$log_id = CSocNetLog::Add($arSonetFields, false);
					if (intval($log_id) > 0)
					{
						CSocNetLog::Update($log_id, array("TMP_ID" => $log_id));
						CSocNetLogRights::SetForSonet($log_id, $arSonetFields["ENTITY_TYPE"], $arSonetFields["ENTITY_ID"], "files", "view", true);
					}
				}
			}

			if (intval($log_id) > 0)
			{
				$arForum = CForumNew::GetByID($this->ForumID);
				$arMessage = CForumMessage::GetByIDEx($ID);

				$parser = new textParser(LANGUAGE_ID, $this->arPath["PATH_TO_SMILE"]);
				$parser->image_params["width"] = false;
				$parser->image_params["height"] = false;

				$arAllow = array(
					"HTML" => "N",
					"ANCHOR" => "N",
					"BIU" => "N",
					"IMG" => "N",
					"LIST" => "N",
					"QUOTE" => "N",
					"CODE" => "N",
					"FONT" => "N",
					"UPLOAD" => $arForum["ALLOW_UPLOAD"],
					"NL2BR" => "N",
					"SMILES" => "N"					
				);

				$url = CComponentEngine::MakePathFromTemplate($arParams["~URL_TEMPLATES_MESSAGE"], 
					array("FID" => $arMessage["FORUM_ID"], "TID" => $arMessage["TOPIC_ID"], "MID"=> $ID));

				$arFieldsForSocnet = array(
					"ENTITY_TYPE" => $entity_type,
					"ENTITY_ID" => $entity_id,
					"EVENT_ID" => "files_comment",
					"=LOG_DATE" => $GLOBALS["DB"]->CurrentTimeFunction(),
					"MESSAGE" => $parser->convert($arFields["POST_MESSAGE"], $arAllow),
					"TEXT_MESSAGE" => $parser->convert4mail($arFields["POST_MESSAGE"]),
					"URL" => $url,
					"MODULE_ID" => false,
					"SOURCE_ID" => $ID,
					"LOG_ID" => $log_id,
					"RATING_TYPE_ID" => "FORUM_POST",
					"RATING_ENTITY_ID" => intval($ID)
				);

				if (intVal($arMessage["AUTHOR_ID"]) > 0)
					$arFieldsForSocnet["USER_ID"] = $arMessage["AUTHOR_ID"];

				CSocNetLogComments::Add($arFieldsForSocnet);
			}
		}
	}
}
?>