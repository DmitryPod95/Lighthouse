<?

use Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

Loc::loadLanguageFile(__FILE__);

$arComponentDescription = array(
    'NAME' => Loc::getMessage("COMPONENT_NAME"),
    'DESCRIPTION' => Loc::getMessage("COMPONENT_DESCRIPTION"),
    'CACHE_PATH' => 'Y',
    'PATH' => array(
        'ID' => 'lighthouse',
        'NAME' => Loc::getMessage("COMPONENT_SECTION_NAME"),
    )
);
