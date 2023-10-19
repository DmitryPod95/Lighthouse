<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\SystemException;
use Bitrix\Main\Loader;
use lighthouse\InfoResident;
use Bitrix\Main\UI\PageNavigation;



class Residents extends CBitrixComponent
{

    // выполняет основной код компонента, аналог конструктора (метод подключается автоматически)
    public function executeComponent()
    {
        $this->checkModules();

        $navigation = new PageNavigation("nav-more-residents");
        $navigation->allowAllRecords(false)
            ->setPageSize($this->arParams['RESIDENTS_PAGE_NAVIGATION_ELEMENTS_COUNT'])
            ->initFromUri();

        $residents = new InfoResident();

        try {
            $this->arResult['ITEMS'] = $residents->resultInfo(
                $navigation,
                $this->arParams["CACHE_TIME"],
            );

        } catch (SystemException $e) {
            ShowError($e->getMessage());
        }

        $this->arResult['NAVIGATION'] = $navigation;

        $this->includeComponentTemplate();
    }

    public function onIncludeComponentLang()
    {
        Loc::loadMessages(__FILE__);
    }

    protected function checkModules(): bool
    {
        if (!Loader::includeModule('iblock'))
        {
            throw new SystemException(Loc::getMessage('IBLOCK_MODULE_NOT_INSTALLED'));
        }

        return true;
    }

    public function onPrepareComponentParams($arParams): array
    {

        if (!isset($arParams['CACHE_TIME'])) {
            $arParams['CACHE_TIME'] = 36000;
        } else {
            $arParams['CACHE_TIME'] = intval($arParams['CACHE_TIME']);
        }
        return $arParams;
    }
}
