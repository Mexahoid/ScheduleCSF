<?php
/**
 * Created by PhpStorm.
 * User: Mexahoid
 * Date: 23.03.2019
 * Time: 14:29
 */

interface Storage
{
    function saveData($query, $data);
    function getData($query, $data);
}
