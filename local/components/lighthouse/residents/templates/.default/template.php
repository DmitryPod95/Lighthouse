<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>

<?php

if(!$arResult["ITEMS"]) {
    return;
}
$this->setFrameMode(false);

?>


<div class="container">
    <?foreach ($arResult["ITEMS"] as $item):?>
        <div class="items">
            <?=implode(" - ",$item);?>
        </div>
    <?endforeach;?>
</div>

<?
$APPLICATION->IncludeComponent(
    'bitrix:main.pagenavigation',
    "",
    array(
        'NAV_OBJECT' => $arResult['NAVIGATION'],
        'SEF_MODE' => 'N',
    ),
    false
);
