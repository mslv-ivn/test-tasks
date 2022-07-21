<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->IncludeComponent(
    "bitrix:news.detail",
    "template", // шаблон
    Array(
        "IBLOCK_ID" => "2",  // ID информационного блока
        "ELEMENT_ID" => $_GET["ID"],
        "FIELD_CODE" => array("TAGS"),
    ),
    false
);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");?>