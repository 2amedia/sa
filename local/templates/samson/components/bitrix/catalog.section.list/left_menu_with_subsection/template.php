<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<? $page_url = $APPLICATION->GetCurPage ()?>
<div class="inner">
	<?
	foreach ($arResult["ITEM"] as $arSection)
	{
		?>
		<?= $arSection['NAME'] ?>
        <ul>
			<? foreach ($arSection['CHILD'] as $item)
			{
				?>
                <li <? echo ($page_url == $item['LINK']) ? 'class="active_m" ' : '' ?> >
                    <a href="<?= $item['LINK'] ?>"><?= $item['NAME'] ?>
                    </a></li>
			<? } ?>
        </ul>
	<? } ?>
</div>
<!-- /.inner -->


