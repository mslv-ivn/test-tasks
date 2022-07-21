<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
if ($_REQUEST["tag"])
    $GLOBALS['filter'] = array("?TAGS" => $_REQUEST["tag"]);
$APPLICATION->IncludeComponent(
    "bitrix:news.list",
    "template",
    Array(
		"IBLOCK_ID" => "2",	// Код информационного блока
		"NEWS_COUNT" => "6",
		"SET_TITLE" => "Y",	// Устанавливать заголовок страницы
        "FIELD_CODE" => array("TAGS"),
        "FILTER_NAME" => "filter",
	),
	false
);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");?>