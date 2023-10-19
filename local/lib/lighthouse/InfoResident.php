<?php

namespace lighthouse;

use Bitrix\Main\Loader;
use Bitrix\Main\UI\PageNavigation;

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

Loader::includeModule('iblock');

class InfoResident
{
    private static $arPropHomeID = [];

    /** result info residents
     * @return array
     */
    public function resultInfo(PageNavigation $navigation, int $cacheTime): array
    {

        $arResident = self::getResidents($navigation, $cacheTime);
        $arHouses = self::getHouses(self::$arPropHomeID,$cacheTime);

        foreach ($arResident as &$resident) {
            foreach ($arHouses as $key => $items) {
                if(strcasecmp($resident["HOME"],$key) == 0) {
                    $resident["HOME"] = implode(", ",$items);
                }
            }
        }

        return $arResident ?? [];
    }

    /** get elements from iblock resident
     * @param $cacheTime - component parameters
     * @return array
     */
    private static function getResidents(PageNavigation $navigation, int $cacheTime): array
    {
        $dateResident = \Bitrix\Iblock\Elements\ElementResidentapiTable::getList([
            'select' => ["NAME", "FIO","HOME"],
            'offset' => $navigation->getOffset(),
            'count_total' => 1,
            'limit' => $navigation->getLimit(),
            'cache' => [
                'ttl' => $cacheTime,
            ],
        ]);

        $navigation->setRecordCount($dateResident->getCount());

        while( $arResidents = $dateResident->fetch()) {

            $arInfoResidents[] = [
                "NAME"  => $arResidents["IBLOCK_ELEMENTS_ELEMENT_RESIDENTAPI_FIO_VALUE"],
                "HOME"  => $arResidents["IBLOCK_ELEMENTS_ELEMENT_RESIDENTAPI_HOME_IBLOCK_GENERIC_VALUE"],
            ];

            self::$arPropHomeID[$arResidents["IBLOCK_ELEMENTS_ELEMENT_RESIDENTAPI_HOME_IBLOCK_GENERIC_VALUE"]] = $arResidents["IBLOCK_ELEMENTS_ELEMENT_RESIDENTAPI_HOME_IBLOCK_GENERIC_VALUE"];
        }


        return $arInfoResidents ?? [];
    }

    /**
     *  get elements from iblock houses
     * @param array $idsHouses - ids Property Houses
     * @param $cacheTime - component parameters
     * @return array
     */
    private static function getHouses(array $idsHouses, int $cacheTime): array
    {

        $dateHouse = \Bitrix\Iblock\Elements\ElementHousesapiTable::getList([
            'select'    => ["ID","NAME", "NUMBER", "CITY", "STREET"],
            'filter'    => [ "ID" => array_values($idsHouses)],
            'cache'     => [
                'ttl' => $cacheTime,
            ],
        ]);

        while($arHouses = $dateHouse->fetch()) {
            $arInfoHouses[$arHouses["ID"]] = [
                "CITY"      => $arHouses["IBLOCK_ELEMENTS_ELEMENT_HOUSESAPI_CITY_VALUE"],
                "STREET"    => $arHouses["IBLOCK_ELEMENTS_ELEMENT_HOUSESAPI_STREET_VALUE"],
                "NUMBER"    => $arHouses["IBLOCK_ELEMENTS_ELEMENT_HOUSESAPI_NUMBER_VALUE"],
            ];
        }

        return $arInfoHouses ?? [];
    }
}