<?php

use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use lighthouse\InfoResident;

try {

    Loader::registerAutoLoadClasses(null, [
        InfoResident::class => "/local/lib/lighthouse/InfoResident.php",
    ]);
    
} catch (LoaderException $e) {

}