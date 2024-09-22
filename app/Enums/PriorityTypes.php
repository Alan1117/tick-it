<?php

namespace App\Enums;

enum PriorityTypes: string
{
    case PRIORITY_TYPE_CRITICAL = 'CRITICAL';
    case PRIORITY_TYPE_HIGH = 'HIGH';
    case PRIORITY_TYPE_MEDIUM = 'MEDIUM';
    case PRIORITY_TYPE_LOW = 'LOW';
}