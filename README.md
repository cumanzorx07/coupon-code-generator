# coupon-code-generator
Basically, it's a PHP solution that generates unique easy-to-read coupon codes. I took inspiration from https://github.com/mariuswilms/coupon_code, some sections are clearly based on that project.

## Features
- PHP 7.4 and 8.0 support
- 

## Common use cases
- You need to generate a random code to use on promotions.

## License
This software is distributed under the [GPL 3.0](http://www.gnu.org/licenses/gpl-3.0.html) license.

## How to install it

```sh
composer require cumanzorx07/coupon_code_generator
```

## A super simple example

```php
<?php

use CouponGenerator\CouponGenerator;

$code = CouponGenerator::getInstance(5,5,'STORE')->generateCode();
echo $code;
```

You will obtain something like this:

```text
STORE-77P3J-9UK5M-4NRE9-XJ6XB-U6KT1
```

You can take a look at the testcases to get an idea of what you can achieve.