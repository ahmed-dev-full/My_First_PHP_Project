<?php

declare(strict_types = 1);

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
        while (($transaction 
                = fgetcsv($file, 0, ',', '"', '\\')) !== false){
            $transactions[]= gettransactionamount($transaction);
        }
        return $transactions;
}

    function gettransactionamount($transactionrow) {
        [$date,$transaction,$description,$amount]= $transactionrow;
        $amount = (float)str_replace(['$',','], '' , $amount);
        $amount = gettransactiontotal($amount);
        return  [
            'date' => $date,
            'transaction' => $transaction,
            'description' => $description,
            'amountColor' => $amount['amountColor'],
            'net_total' => $amount['net_total'],
            'total_positive' => $amount['total_positive'],
            'total_negative' => $amount['total_negative'],
        ];
}

$globaltotal = [
    'total_positive' => 0,
    'total_negative' => 0,
];

    function gettransactiontotal($total) {
        global $globaltotal;
        if ($total > 0){
            $globaltotal['total_positive']+= $total;
            }else{
            $globaltotal['total_negative'] += $total;
            }
        $globaltotal['net_total'] =
        $globaltotal['total_positive']
        +
        $globaltotal['total_negative'];
        return [
        'amountColor'=> gettransactioncolor($total),
        'total_positive' => $globaltotal['total_positive'],
        'total_negative' => $globaltotal['total_negative'],
        'net_total' => $globaltotal['net_total'],
        ];
}

    function gettransactioncolor(float $amount){
        if ($amount > 0) {
            $amount = "<span style='color:green';'>$" 
            . number_format($amount, 2) . "</span>";
        } else {
            $amount = "<span style='color:red;'>-$"
            . number_format(abs($amount), 2) . "</span>";
        }
        return $amount;
}
?>


















