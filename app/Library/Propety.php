<?php


namespace App\Library;


class Propety
{
    public static function choiceProperty($arrOptions, $name)
   {
       foreach ($arrOptions as $option) {
           if ($name == $option['name']) {
               return $option['value'];

           }
           return null;
       }
   }
}
