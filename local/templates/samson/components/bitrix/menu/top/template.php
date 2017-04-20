<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? if (!empty($arResult)): ?>
    <div id="top-menu">
        <div class="navbar">
            <div class="navbar-inner">
                <ul class="nav">
                    <?
                    foreach ($arResult as $arItem):
                        if ($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1)
                            continue;
                        ?>
                        <li>
                            <a href="<?= $arItem["LINK"] ?>" class="
                                    <?if ($arItem["SELECTED"]):?>active<?endif;?>
                                    <?if ($arItem["PARAMS"]['bold'] == 'Y'):?> bold<?endif;?>
                                    ">
                            <?= $arItem["TEXT"] ?>
                            </a>
                        </li>
                    <? endforeach ?>
                </ul>
            </div>
        </div>
    </div>
<? endif ?>
