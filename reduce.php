<?php

require 'vendor/autoload.php';

use Illuminate\Support\Collection;

$angka = collect([1, 2, 3, 4, 5]);
$total = $angka->reduce(function ($nilaiSementara, $item) {
    return $nilaiSementara + $item;
}, 0);

echo $total;
