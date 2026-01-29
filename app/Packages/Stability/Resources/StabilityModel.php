<?php

namespace App\Packages\Stability\Resources;

enum StabilityModel: string
{
    case CORE = 'core';
    case ULTRA = 'ultra';
    case SD3 = 'sd3';

    case SD3_LARGE = 'sd3.5-large';
    case SD3_LARGE_TURBO = 'sd3.5-large-turbo';
    case SD3_MEDIUM = 'sd3.5-medium';
    case SD3_FLASH = 'sd3.5-flash';
}
