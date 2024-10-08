# Class para validação do padrão EAN usado em ERP de vendas no Brasil

## Validação do EAN

```php
<?php

declare(strict_types=1);

use Lucasnpinheiro\Ean\EanExtractor;

require __DIR__. '/../vendor/autoload.php';

$ean = '2018740009892';

$eanExists = new EanExtractor($ean);

print_r($eanExists->toArray());

print_r($eanExists->toObject());
```

## Retornos esperados

```php
Array
(
    [ean_code] => 2018740009892
    [ean] => 2018740009892
    [value] => 
    [scale_product] => 
    [international_number] => 
    [custom_code_999] => 
    [custom_code_2] => 1
)
```

```php
stdClass Object
(
    [ean_code] => 2018740009892
    [ean] => 01874
    [value] => 000989
    [scale_product] => 
    [international_number] => 
    [custom_code_999] => 
    [custom_code_2] => 1
)
```