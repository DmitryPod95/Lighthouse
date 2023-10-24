<?php

namespace Lighthouse;

use Bitrix\Main\Loader;
use Bitrix\Main\UI\PageNavigation;
use Bitrix\Iblock\Elements\ElementResidentapiTable;
use Bitrix\Iblock\Elements\ElementHousesapiTable;

class InfoResident
{

    /** get elements from iblock resident
     * @param $cacheTime - component parameters
     * @return array
     */
    public function residentsInfo(PageNavigation $navigation, int $cacheTime): array
    {

        $dateResident = ElementResidentapiTable::getList([
            'select' => [
            	"NAME", 
            	"USER_FIO" 	=> "FIO.VALUE",
            	"USER_HOME" => "HOME.IBLOCK_GENERIC_VALUE",
            ],
            'offset' => $navigation->getOffset(),
            'count_total' => 1,
            'limit' => $navigation->getLimit(),
            'cache' => [
                'ttl' => $cacheTime,
            ],
        ]);

        $navigation->setRecordCount($dateResident->getCount());

        $arPropHomeID = [];
        while( $arResidents = $dateResident->fetch()) {

            $arInfoResidents[] = [
                "NAME"  => $arResidents["USER_FIO"],
                "HOME"  => $arResidents["USER_HOME"],
            ];

            $arPropHomeID[$arResidents["USER_HOME"]] = $arResidents["USER_HOME"];
        }

        $arHouses = self::getHouses($arPropHomeID,$cacheTime);

        foreach ($arInfoResidents as &$resident) {
            foreach ($arHouses as $key => $items) {
                if(strcasecmp($resident["HOME"],$key) == 0) {
                    $resident["HOME"] = implode(", ",$items);
                }
            }
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

        $dateHouse = ElementHousesapiTable::getList([
            'select'    => [
            	"ID", 
            	"HOME_NUMBER" 	=> "NUMBER.VALUE", 
            	"HOME_CITY" 	=> "CITY.VALUE", 
            	"HOME_STREET" 	=> "STREET.VALUE",
            ],
            'filter'    => [ "ID" => array_values($idsHouses)],
            'cache'     => [
                'ttl' => $cacheTime,
            ],
        ]);

        while($arHouses = $dateHouse->fetch()) {
            $arInfoHouses[$arHouses["ID"]] = [
                "CITY"      => $arHouses["HOME_CITY"],
                "STREET"    => $arHouses["HOME_STREET"],
                "NUMBER"    => $arHouses["HOME_NUMBER"],
            ];
        }

        return $arInfoHouses ?? [];
    }
}