<?
use Bitrix\Main\Localization\Loc;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

Loc::loadLanguageFile(__FILE__);



$arComponentParameters = array(
    'PARAMETERS' => array(
        "RESIDENTS_PAGE_NAVIGATION_ELEMENTS_COUNT" => [
            "PARENT" => "BASE",
            "NAME" => Loc::getMessage("RESIDENTS_PAGE_NAVIGATION_ELEMENTS_COUNT"),
            "TYPE" => "INTEGER",
            "DEFAULT" => 10
        ],
        'CACHE_TIME' => ['DEFAULT' => 36000],
    ),
);
