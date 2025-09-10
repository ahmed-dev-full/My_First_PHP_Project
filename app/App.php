<?php

declare(strict_types = 1);

// Your Code
    function gettransactionfile( string $dirpath): array {
        $files = [];
        foreach (scandir($dirpath) as $file){
            if (is_dir($file)){
                continue;
            }
            $files[]= FILES_PATH . $file;
        }
        return $files;
    }





?>


















