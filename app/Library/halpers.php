<?php
if (! function_exists('choiceProperty')) {
    function choiceProperty($arrOptions, $name)
    {
        foreach ($arrOptions as $option) {
            if ($name == $option['name']) {
                return $option['value'];
                break;
            }
            return null;
        }
    }
}

