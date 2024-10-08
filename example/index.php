<?php

declare(strict_types=1);

use Lucasnpinheiro\Ean\EanExtractor;

require __DIR__. '/../vendor/autoload.php';

$ean = '2018740009892';

$eanExists = new EanExtractor($ean);

print_r($eanExists->toArray());

print_r($eanExists->toObject());