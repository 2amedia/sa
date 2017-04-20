<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?

if (function_exists("__forum_default_template_show_message"))
	return false;

function __forum_default_template_show_message($arResult, $message, $arRes, $arAddParams, $arParams, $component = false)
{
	$iCount = 0;
	$message = (is_array($message) ? $message : array());
	$arResult = (is_array($arResult) ? $arResult : array($arResult));
	$arRes = (is_array($arRes) ? $arRes : array($arRes));
	static $bShowedMessage = false;
	if ($arParams["SHOW_RATING"] == 'Y')
	{
		$arAuthorId = array();
		$arPostId = array();
		$arTopicId = array();
		foreach ($arResult as $res)
		{
			$arAuthorId[] = $res['AUTHOR_ID'];
			if ($res['NEW_TOPIC'] == "Y")
				$arTopicId[] = $res['TOPIC_ID'];
			else
				$arPostId[] = $res['ID'];
		}
		if (!empty($arAuthorId))
		{
			foreach($arParams["RATING_ID"] as $key => $ratingId)
			{
				$arParams["RATING_ID"][$key] = intval($ratingId);
				$arRatingResult[$arParams["RATING_ID"][$key]] = CRatings::GetRatingResult($arParams["RATING_ID"][$key], array_unique($arAuthorId));
			}
		}

		if (!empty($arPostId))
			$arRatingVote['FORUM_POST'] = CRatings::GetRatingVoteResult('FORUM_POST', $arPostId);

		if (!empty($arTopicId))
			$arRatingVote['FORUM_TOPIC'] = CRatings::GetRatingVoteResult('FORUM_TOPIC', $arTopicId);
	}

foreach ($arResult as $res):
	$iCount++;
	$bNameShowed = false;
	if ($arParams["SHOW_VOTE"] == "Y" && $res["PARAM1"] == "VT" && intVal($res["PARAM2"]) > 0 && IsModuleInstalled("vote")):
?>
<div class="forum-info-box forum-post-vote">
	<div class="forum-info-box-inner">
	<span style='position:absolute;'><a style="display:none;" id="message<?=$res["ID"]?>">&nbsp;</a></span><? /* IE9 */ ?>
	<a name="message<?=$res["ID"]?>"></a>
	<?
	$bNameShowed = true;
	?><?$GLOBALS["APPLICATION"]->IncludeComponent("bitrix:voting.current", $arParams["VOTE_TEMPLATE"],
		array(
			"VOTE_ID" => $res["PARAM2"],
			"VOTE_CHANNEL_ID" => $arParams["VOTE_CHANNEL_ID"],
			"VOTE_RESULT_TEMPLATE" => $arRes["~CURRENT_PAGE"],
			"CACHE_TIME" => 0, /*$arParams["CACHE_TIME"]*/
			"NEED_SORT" => "N"),
		(($component && $component->__component && $component->__component->__parent) ? $component->__component->__parent : null),
		array("HIDE_ICONS" => "Y"));?>
	</div>
</div>
<?
	endif;

if (!$bShowedMessage && $arRes["USER"]["RIGHTS"]["MODERATE"] == "Y" && $arAddParams["single_message"] !== "Y"):
?>
<form class="forum-form" action="<?=POST_FORM_ACTION_URI?>" method="POST" <?
	?>onsubmit="return Validate(this)" name="MESSAGES_<?=$arParams["iIndex"]?>" id="MESSAGES_<?=$arParams["iIndex"]?>">
<?
$bShowedMessage = true;
endif;
	?><?$GLOBALS["APPLICATION"]->IncludeComponent(
		"bitrix:forum.message.template", "",
		Array(
			"MESSAGE" => $res + array("CHECKED" => (in_array($res["ID"], $message) ? "Y" : "N"), "SHOW_TABLE_ID" => !$bNameShowed),
			"ATTACH_MODE" => $arParams["ATTACH_MODE"],
			"ATTACH_SIZE" => $arParams["ATTACH_SIZE"],
			"COUNT" => ($arAddParams["single_message"] !== "Y" ? count($arResult) : 0),
			"NUMBER" => $iCount,
			"SEO_USER" => $arParams["SEO_USER"],
			"SHOW_RATING" => $arParams["SHOW_RATING"],
			"RATING_ID" => $arParams["RATING_ID"],
			"RATING_TYPE" => $arParams["RATING_TYPE"],
			"arRatingVote" => $arRatingVote,
			"arRatingResult" => $arRatingResult,
			"arResult" => $arRes,
			"arParams" => $arParams
		),
		(($component && $component->__component && $component->__component->__parent) ? $component->__component->__parent : null),
		array("HIDE_ICONS" => "Y")
	);?><?
endforeach;
}
?>