<?
	IncludeModuleLangFile(__FILE__);
	$arAlerts = Array(
		"TCS_NO_COURIER"=>GetMessage("TCS_NO_COURIER"),
		"TCS_NO_APPLY_CODE"=>GetMessage("TCS_NO_APPLY_CODE"),
		"TCS_NO_APPLY_PERSON"=>GetMessage("TCS_NO_APPLY_PERSON"),
		"TCS_NO_APPLY_CODE_NOT_4"=>GetMessage("TCS_NO_APPLY_CODE_NOT_4")
	);

	echo "<script>var TCSAlerts=".$obModule->PHPArrayToJS($arAlerts)."</script>";
?>