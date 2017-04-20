<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if(array_key_exists("SELECTED_CATEGORY", $arParams) && strlen($arParams["SELECTED_CATEGORY"])>0)
{
    $arSelected = $arResult["CATEGORY"][$arParams["SELECTED_CATEGORY"]];
    if($arSelected)
    {
        foreach($arResult["ITEMS"] as $key=>$Item)
        {
            if($arSelected["ID"] == $Item["ID"])
            {
                $arResult["ITEMS"][$key]["SELECTED"] = true;
                break;
            }
        }
    }
}
?>