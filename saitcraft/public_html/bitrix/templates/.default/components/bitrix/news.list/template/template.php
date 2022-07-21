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

<?php
$arFilter = array(
    'IBLOCK_ID' => $arParams["IBLOCK_ID"],
    "ACTIVE_DATE" => "Y",
);
$res = CIBlockElement::GetList(array(), $arFilter, false, false, array("TAGS"));
$tagList = [];
$allTags = 0;
while ($item = $res->GetNext()) {
    $allTags++;
    $tags = explode(", ", $item["TAGS"]);
    if ($tags) {
        foreach ($tags as $tag)
            $tagList[$tag]++;
    }
}
$primTagList = array_slice($tagList, 0, 4);
$secTagList = array_slice($tagList, 4);
?>

<div class="container pt-5">
    <div class="row my-4">
        <div class="col">
            <h1 class="content-title"><?= $arResult["NAME"] ?></h1>
        </div>

        <div class="col-auto">
            <a href="/articles" type="button" class="btn btn-outline-secondary">Все <span
                        class="btn btn-warning btn-circle"><?= $allTags ?></span></a>

            <? foreach ($primTagList as $tagName => $tagAmount): ?>
                <a href="?tag=<?= $tagName ?>" type="button" class="btn btn-outline-secondary"><?= $tagName ?> <span
                            class="btn btn-warning btn-circle"><?= $tagAmount ?></span></a>
            <? endforeach; ?>

            <? if ($secTagList): ?>
                <div class="btn-group" role="group">
                    <button id="btnGroupDrop1" type="button" class="btn btn-outline-warning dropdown-toggle"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        Еще
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                        <? foreach ($secTagList as $tagName => $tagAmount): ?>
                            <li><a href="?tag=<?= $tagName ?>" class="dropdown-item" href="#"><?= $tagName ?> <span
                                            class="btn btn-warning btn-circle"><?= $tagAmount ?></span></a></li>
                        <? endforeach; ?>
                    </ul>
                </div>
            <? endif; ?>
        </div>
    </div>

    <div class="news-list row">
        <? if ($arParams["DISPLAY_TOP_PAGER"]): ?>
            <?= $arResult["NAV_STRING"] ?><br/>
        <? endif; ?>
        <? foreach ($arResult["ITEMS"] as $arItem): ?>
            <div class="col-md-6">
                <?
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>
                <div class="news-item card mb-4" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                    <? if ($arParams["DISPLAY_PICTURE"] != "N" && is_array($arItem["PREVIEW_PICTURE"])): ?>
                        <? if (!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])): ?>
                            <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>"><img
                                        class="preview_picture card-img-top"
                                        border="0"
                                        src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>"
                                        alt="<?= $arItem["PREVIEW_PICTURE"]["ALT"] ?>"
                                        title="<?= $arItem["PREVIEW_PICTURE"]["TITLE"] ?>"
                                        style="float:left"
                                /></a>
                        <? else: ?>
                            <img
                                    class="preview_picture card-img-top"
                                    border="0"
                                    src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>"
                                    alt="<?= $arItem["PREVIEW_PICTURE"]["ALT"] ?>"
                                    title="<?= $arItem["PREVIEW_PICTURE"]["TITLE"] ?>"
                                    style="float:left"
                            />
                        <? endif; ?>
                    <? endif ?>
                    <div class="card-body">
                        <? if ($arParams["DISPLAY_DATE"] != "N" && $arItem["DISPLAY_ACTIVE_FROM"]): ?>
                            <span class="news-date-time"><?= strtolower(FormatDate("d F Y", MakeTimeStamp($arItem['ACTIVE_FROM']))) ?></span>
                            <br/>
                        <? endif ?>
                        <? if ($arParams["DISPLAY_NAME"] != "N" && $arItem["NAME"]): ?>
                            <? if (!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])): ?>
                                <h5 class="card-title"><? echo $arItem["NAME"] ?></h5>
                            <? else: ?>
                                <b><? echo $arItem["NAME"] ?></b><br/>
                            <? endif; ?>
                        <? endif; ?>
                        <? if ($arParams["DISPLAY_PREVIEW_TEXT"] != "N" && $arItem["PREVIEW_TEXT"]): ?>
                            <p class="card-text"><? echo $arItem["PREVIEW_TEXT"]; ?></p>
                        <? endif; ?>
                        <? if ($arParams["DISPLAY_PICTURE"] != "N" && is_array($arItem["PREVIEW_PICTURE"])): ?>
                            <div style="clear:both"></div>
                        <? endif ?>
                        <? if ($arItem["TAGS"]): ?>
                            <nav class="nav">
                                <? $tags = explode(", ", $arItem["TAGS"]);
                                foreach ($tags as $tag): ?>
                                    <a href="?tag=<?= $tag ?>" class="nav-link link-warning"><?= $tag ?></a>
                                <? endforeach; ?>
                            </nav>
                        <? endif; ?>
                        <? foreach ($arItem["DISPLAY_PROPERTIES"] as $pid => $arProperty): ?>
                            <small>
                                <?= $arProperty["NAME"] ?>:&nbsp;
                                <? if (is_array($arProperty["DISPLAY_VALUE"])): ?>
                                    <?= implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]); ?>
                                <? else: ?>
                                    <?= $arProperty["DISPLAY_VALUE"]; ?>
                                <? endif ?>
                            </small><br/>
                        <? endforeach; ?>
                    </div>
                </div>
            </div>
        <? endforeach; ?>
        <? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
            <?= $arResult["NAV_STRING"] ?>
        <? endif; ?>
    </div>
</div>