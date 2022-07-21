<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<div class="news-detail container py-5">
    <div class="d-flex flex-md-row align-items-center mb-4 border-bottom">
        <? if ($arParams["DISPLAY_DATE"] != "N"): ?>
            <span class="my-0"><?= strtolower(FormatDate("d F Y", MakeTimeStamp($arResult["DISPLAY_ACTIVE_FROM"] ?: $arResult["TIMESTAMP_X"]))) ?></span>
        <? endif; ?>
        <nav class="nav px-5 my-2">
            <? $tags = explode(", ", $arResult["TAGS"]);
            foreach ($tags as $tag): ?>
                <a href="/articles?tag=<?= $tag ?>" class="link-warning px-2"><?= $tag ?></a>
            <? endforeach; ?>
        </nav>
    </div>
    <? if ($arParams["DISPLAY_NAME"] != "N" && $arResult["NAME"]): ?>
        <h1 class="content-title pb-3"><?= $arResult["NAME"] ?></h1>
    <? endif; ?>
    <? if ($arParams["DISPLAY_PREVIEW_TEXT"] != "N" && $arResult["FIELDS"]["PREVIEW_TEXT"]): ?>
        <p><?= $arResult["FIELDS"]["PREVIEW_TEXT"];
            unset($arResult["FIELDS"]["PREVIEW_TEXT"]); ?></p>
    <? endif; ?>
    <? if ($arResult["NAV_RESULT"]): ?>
        <? if ($arParams["DISPLAY_TOP_PAGER"]): ?><?= $arResult["NAV_STRING"] ?><br/><? endif; ?>
        <? echo $arResult["NAV_TEXT"]; ?>
        <? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?><br/><?= $arResult["NAV_STRING"] ?><? endif; ?>
    <? elseif ($arResult["DETAIL_TEXT"] <> ''): ?>
        <p><? echo $arResult["DETAIL_TEXT"]; ?></p>
    <? else: ?>
        <? echo $arResult["PREVIEW_TEXT"]; ?>
    <? endif ?>
    <div style="clear:both"></div>
    <br/>
    <? foreach ($arResult["DISPLAY_PROPERTIES"] as $pid => $arProperty): ?>

        <?= $arProperty["NAME"] ?>:&nbsp;
        <? if (is_array($arProperty["DISPLAY_VALUE"])): ?>
            <?= implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]); ?>
        <? else: ?>
            <?= $arProperty["DISPLAY_VALUE"]; ?>
        <? endif ?>
        <br/>
    <?endforeach;
    if (array_key_exists("USE_SHARE", $arParams) && $arParams["USE_SHARE"] == "Y") {
        ?>
        <div class="news-detail-share">
            <noindex>
                <?
                $APPLICATION->IncludeComponent("bitrix:main.share", "", array(
                    "HANDLERS" => $arParams["SHARE_HANDLERS"],
                    "PAGE_URL" => $arResult["~DETAIL_PAGE_URL"],
                    "PAGE_TITLE" => $arResult["~NAME"],
                    "SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
                    "SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
                    "HIDE" => $arParams["SHARE_HIDE"],
                ),
                    $component,
                    array("HIDE_ICONS" => "Y")
                );
                ?>
            </noindex>
        </div>
        <?
    }
    ?>
</div>

<div style="background-color: #f3efea">
    <div class="container">
        <div class="row">
            <div class="d-flex flex-md-row align-items-center my-4">
                <h1 class="content-title">читайте так же:</h1>
                <a class="link-warning px-5 link-arrow" href="/articles">Все статьи<span>&rsaquo;</span></a>
            </div>
            <?
            $arFilter = array(
                'IBLOCK_ID' => $arParams["IBLOCK_ID"],
                "ACTIVE_DATE" => "Y",
            );
            $res = CIBlockElement::GetList(array("active_from" => "DESC"), $arFilter, false, array('nTopCount' => 2));
            while ($arItem = $res->GetNext()) { ?>
                <div class="col-md-6">
                    <div class="card mb-4">
                        <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>"><img
                                    src="<?= CFile::GetPath($arItem['PREVIEW_PICTURE']) ?>" class="card-img-top"
                                    alt="img"></a>
                        <div class="card-body">
                            <span class="news-date-time"><?= strtolower(FormatDate("d F Y", MakeTimeStamp($arItem['ACTIVE_FROM']))) ?></span>
                            <h5 class="card-title"><? echo $arItem["NAME"] ?></h5>
                            <p class="card-text"><? echo $arItem["PREVIEW_TEXT"]; ?></p>
                            <? if ($arItem["TAGS"]): ?>
                                <nav class="nav">
                                    <? $tags = explode(", ", $arItem["TAGS"]);
                                    foreach ($tags as $tag): ?>
                                        <a href="/articles?tag=<?= $tag ?>"
                                           class="nav-link link-warning"><?= $tag ?></a>
                                    <? endforeach; ?>
                                </nav>
                            <? endif; ?>
                        </div>
                    </div>
                </div>
            <? } ?>
        </div>
    </div>
</div>