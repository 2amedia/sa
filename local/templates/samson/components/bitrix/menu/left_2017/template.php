<? if (!defined ("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?
$PREV_LVL = 0;
$PARENT_OPEN =false;
$i=0;
?>
<div class="left_menu">
	<? foreach ($arResult as $item)

	{?>
        <?if ($item['DEPTH_LEVEL']==1){
        $parent = $item['IS_PARENT'];?>
         <? if($item['SELECTED']) {$PARENT_OPEN = true;} else {$PARENT_OPEN = false;}?>
            <div class="lev_one <? echo ($PARENT_OPEN && $parent) ? 'uncollapsed' : 'noborder'; ?>">
                <div class="caption"><a href="<?= $item['LINK'] ?>"><?= $item['TEXT'] ?></a></div>
                <?echo (!$parent)?'</div>':''?>
        <?}?>
        <? if ($item['DEPTH_LEVEL'] > 1){?>
            <?if(($item['PR_LEV']==1)&&($parent)) echo '<div class="inner"><ul>'?>

                <li><a href="<?= $item['LINK'] ?>"><?= $item['TEXT'] ?></a></li>

	        <? if (($item['N_LEV'] == 1)&&($parent)) echo '</ul></div></div>' ?>
        <?}?>

	<? $i++;
	}?>

</div>
