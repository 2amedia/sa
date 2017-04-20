<?php
//8 - 32 px
$MaxCNT = 0;
foreach($arResult["CATEGORY"] as $key=>$Cat)
{
    if($Cat["CNT"]==0) 
        unset($arResult["CATEGORY"][$key]);
    elseif($Cat["CNT"]>$MaxCNT) 
        $MaxCNT = $Cat["CNT"];
}
    
foreach($arResult["CATEGORY"] as $key=>$Cat)
    $arResult["CATEGORY"][$key]["SIZE"] = round($Cat["CNT"]/$MaxCNT * 24) + 8;
?>