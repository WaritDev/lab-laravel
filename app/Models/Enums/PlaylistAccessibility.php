<?php

namespace App\Models\Enums;

enum PlaylistAccessibility : string
{
    case PRIVATE = 'PRIVATE';
    case PUBLIC = 'PUBLIC';
}
