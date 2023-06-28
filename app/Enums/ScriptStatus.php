<?php

namespace App\Enums;

enum ScriptStatus: string
{
    case PENDING = 'PENDING';
    case RUNNING = 'RUNNING';
    case FINISHED = 'FINISHED';
    case FAILED = 'FAILED';
}
