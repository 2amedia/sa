<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?/*
<table class="top_order"> 
<tbody><tr> 
	<td><a href="#" onclick="histiry(0);return false" id="l0" style="color:#FF0000">Формирование заказа</a></td> 
	<td style="padding-left:8px;padding-right:8px">></td> 
	<td><a href="#" onclick="histiry(1);return false" id="l1">Выбор доставки</a></td> 
	<td style="padding-left:8px;padding-right:8px">></td> 
	<td><a href="#" onclick="histiry(2);return false" id="l2">Выбор оплаты</a></td> 
	<td style="padding-left:8px;padding-right:8px">></td> 
	<td><a href="#" onclick="histiry(3);return false" id="l3">Посмотреть заказ</a></td> 
</tr> 
</tbody></table>
*/?>

<?
if (StrLen($arResult["ERROR_MESSAGE"])<=0)
{
	if(is_array($arResult["WARNING_MESSAGE"]) && !empty($arResult["WARNING_MESSAGE"]))
	{
		foreach($arResult["WARNING_MESSAGE"] as $v)
		{
			echo ShowError($v);
		}
	}
	
	?>
	<form method="post" action="<?=POST_FORM_ACTION_URI?>" name="basket_form" class="cart_contents">
		<?
		if ($arResult["ShowReady"]=="Y")
		{
			include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items.php");
		}
		?>
	</form>
	<?
}
else
	ShowError($arResult["ERROR_MESSAGE"]);
?>