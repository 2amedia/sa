<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Title");
?><?$APPLICATION->IncludeComponent("bitrix:sale.order.ajax", "", array(
	"PAY_FROM_ACCOUNT" => "N",
	"COUNT_DELIVERY_TAX" => "N",
	"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
	"ONLY_FULL_PAY_FROM_ACCOUNT" => "N",
	"ALLOW_AUTO_REGISTER" => "Y",
	"SEND_NEW_USER_NOTIFY" => "N",
	"DELIVERY_NO_AJAX" => "N",
	"DELIVERY_NO_SESSION" => "N",
	"TEMPLATE_LOCATION" => "popup",
	"DELIVERY_TO_PAYSYSTEM" => "d2p",
	"USE_PREPAYMENT" => "N",
	"PROP_2" => array(
	),
	"PROP_1" => array(
	),
	"PATH_TO_BASKET" => "/personal/basket/",
	"PATH_TO_PERSONAL" => "index.php",
	"PATH_TO_PAYMENT" => "payment.php",
	"PATH_TO_AUTH" => "/auth/",
	"SET_TITLE" => "Y",
	"DISPLAY_IMG_WIDTH" => "90",
	"DISPLAY_IMG_HEIGHT" => "90"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>