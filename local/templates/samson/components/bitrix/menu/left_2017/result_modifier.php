<?php
/**
 * Created by PhpStorm.
 * User: paveltupikov
 * Date: 11.03.17
 * Time: 20:17
 */
$i=0;
foreach ($arResult as $arItem)
{
    if ($i>0) $arItem['PR_LEV'] = $arResult[$i-1]['DEPTH_LEVEL']; else $arItem['PR_LEV']=1;
	$arItem['N_LEV'] = $arResult[$i +1]['DEPTH_LEVEL'];
//echo $i;
    $i++;
	$arResultnew[] = $arItem;
}
$arResultnew[$i-1]['N_LEV']=1;
$arResult = $arResultnew;
//dump($arResult);
