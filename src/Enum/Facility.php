<?php

declare(strict_types=1);

namespace App\Enum;

use App\Trait\AllValuesEnumTrait;
use App\Trait\FromNameEnumTrait;

enum Facility: int
{
    use AllValuesEnumTrait;
    use FromNameEnumTrait;

    case kern = 0;
    case user = 1;
    case mail = 2;
    case daemon = 3;
    case auth = 4;
    case syslog = 5;
    case lpr = 6;
    case news = 7;
    case uucp = 8;
    case cron = 9;
    case security = 10;
    case ftp = 11;
    case ntp = 12;
    case logaudit = 13;
    case logalert = 14;
    case clock = 15;
    case local0 = 16;
    case local1 = 17;
    case local2 = 18;
    case local3 = 19;
    case local4 = 20;
    case local5 = 21;
    case local6 = 22;
    case local7 = 23;
}
