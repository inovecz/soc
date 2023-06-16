<?php

namespace App\Enums;

enum ProblemSeverity: int
{
    case NOT_CLASSIFIED = 0;
    case INFORMATION = 1;
    case WARNING = 2;
    case AVERAGE = 3;
    case HIGH = 4;
    case DISASTER = 5;

    public function toString(): string
    {
        return match ($this) {
            self::NOT_CLASSIFIED => 'Not classified',
            self::INFORMATION => 'Information',
            self::WARNING => 'Warning',
            self::AVERAGE => 'Average',
            self::HIGH => 'High',
            self::DISASTER => 'Disaster',
        };
    }

    public function textColor(): string
    {
        return match ($this) {
            self::NOT_CLASSIFIED => 'text-gray-500 dark:text-gray-400',
            self::INFORMATION => 'text-sky-500 dark:text-sky-400',
            self::WARNING => 'text-yellow-500 dark:text-yellow-400',
            self::AVERAGE => 'text-orange-500 dark:text-orange-400',
            self::HIGH => 'text-rose-500 dark:text-rose-400',
            self::DISASTER => 'text-purple-500 dark:text-purple-400',
        };
    }

    public function bgColor(): string
    {
        return match ($this) {
            self::NOT_CLASSIFIED => 'bg-gray-500 dark:bg-gray-400',
            self::INFORMATION => 'bg-sky-500 dark:bg-sky-400',
            self::WARNING => 'bg-yellow-500 dark:bg-yellow-400',
            self::AVERAGE => 'bg-orange-500 dark:bg-orange-400',
            self::HIGH => 'bg-rose-500 dark:bg-rose-400',
            self::DISASTER => 'bg-purple-500 dark:bg-purple-400',
        };
    }
}
