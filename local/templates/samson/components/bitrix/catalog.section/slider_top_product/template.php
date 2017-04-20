<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? if (count($arResult['ITEMS']) > 0) { ?>
	<h3 style=" text-align:center" class="caption blue">Популярные товары</h3>
	<div id="owl-carousel-small">
		<? foreach ($arResult['ITEMS'] as $arItem) {
			$file = CFile::ResizeImageGet($arItem['DETAIL_PICTURE'], array('width' => 200, 'height' => 200), BX_RESIZE_IMAGE_PROPORTIONAL, true);
			?>
			<div class="item">
				<a href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
					<img src="<?= $file['src'] ?>" alt="<?= $arItem['NAME'] ?>" class="adaptive-img">
					<span><?= $arItem['NAME'] ?></span></a>
			</div>
			</a>
		<? } ?>
	</div>
<? } ?>

