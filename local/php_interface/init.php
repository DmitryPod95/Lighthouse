<?php

use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use Lighthouse\InfoResident;

try {

    Loader::registerAutoLoadClasses(null, [
        InfoResident::class => "/local/lib/Lighthouse/InfoResident.php",
    ]);
    
} catch (LoaderException $e) {

}