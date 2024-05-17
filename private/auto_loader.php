<?php

function auto_loader($folder, $file)
{

    $folder = dirname(__DIR__) . '/private/app/' . $folder;
    $files = glob($folder . "*.php");
    $file_name = $folder . $file . '.php';

    if (in_array($file_name, $files))
    {
        return $file_name;
    }else
    {
        echo "Error include";
    }
}
