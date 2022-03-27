<?php

function convertArrayToDelimitedString(array $arrayElements, string $delimiter)
{
    $string = '';
    //Loop Through Array Elements
    foreach ($arrayElements as $element){
        // Check If it's the last element so no need the last delimited character.
        if ($element === end($arrayElements))
            $string .= $element;
        else
            $string .= $element . $delimiter;
    }
    return $string;
}
