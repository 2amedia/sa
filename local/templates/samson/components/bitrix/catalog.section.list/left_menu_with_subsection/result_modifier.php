<?foreach ($arResult['SECTIONS'] as $item){

$id = $item['ID'];
$arFilter = array(
	"IBLOCK_ID"=>3,
	"SECTION_ID"=> $id,
	"ACTIVE"=>'Y'
);

	$arSelect = Array(
		"NAME",
		"DETAIL_PAGE_URL"
	);

$res = CIBlockElement::GetList(Array("SORT" => "ASC"),$arFilter,false,false,$arSelect);
	while ($ar_fields = $res->GetNext())
	{
		$child[] = array(
			'NAME'=>$ar_fields['NAME'],
	        "LINK"=>$ar_fields['DETAIL_PAGE_URL']
		);
	}

$itemNew[] = array(
	'NAME' => $item['NAME'],
	'CHILD' => $child
);
	unset($child);
}

$cp = $this->__component; // объект компонента
$cp->arResult['ITEM'] = $itemNew;
//dump($arResult['ITEM']);
