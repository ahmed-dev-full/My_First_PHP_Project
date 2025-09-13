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


    function gettransaction($fileName): array {
        if (! file_exists($fileName)){
            echo "the file $fileName dosn't existe";
        }
        $transactions = [];
        $file = fopen($fileName , 'r');
        fgetcsv( $file, 0,',', '"', '\\');
        while (($transaction = fgetcsv($file, 0, ',', '"', '\\')) !== false){
            $transactions[]= gettransactionamount($transaction);
        }
        return $transactions;
    }


    function gettransactionamount($transactionrow) {
        [$date,$transaction,$description,$amount]= $transactionrow;
        $amount = (float)str_replace(['$',','], '' , $amount);
        if ($amount<0){
            $amount = "<span style='color:red;'> $$amount</span>";
        }else {
            $amount = "<span style='color:green;'> $$amount </span>";
        }
        return  [
            'date' => $date,
            'transaction' => $transaction,
            'description' => $description,
            'amount' => $amount,
        ];
    };





?>


















