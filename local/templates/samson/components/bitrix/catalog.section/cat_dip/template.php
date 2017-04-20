<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? if (count($arResult['ITEMS']) > 0) { ?>
	<div class="section row">
		<? foreach ($arResult['ITEMS'] as $arItem) {
			$file = CFile::ResizeImageGet($arItem['DETAIL_PICTURE'], array('width' => 150, 'height' => 150), BX_RESIZE_IMAGE_PROPORTIONAL, true);
			?>
			<div class="col-xs-3">
				<a href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
					<img src="<?= $file['src'] ?>" alt="<?= $arItem['NAME'] ?>" class="adaptive-img"><br>
					<span><?= $arItem['NAME'] ?></span></a>
			</div>
			</a>
		<? } ?>
	</div>
<? } ?>

