<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Feedback Form");
?>
 <?$APPLICATION->IncludeComponent(
	"bitrix:main.feedback",
	"",
	Array(
		"USE_CAPTCHA" => "Y",
		"OK_TEXT" => "Your request has been sent.",
		"EMAIL_TO" => "#SALE_EMAIL#",
		"REQUIRED_FIELDS" => array(),
		"EVENT_MESSAGE_ID" => array()
	),
false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>