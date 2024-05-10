<?php

namespace App\Enums;

enum TicketPriority: string
{
    case Low = 'low';
    case Medium = 'medium';
    case High = 'high';

    public static function toSelectArray(): array
    {
        return [
            self::Low->value => self::Low->name,
            self::Medium->value => self::Medium->name,
            self::High->value => self::High->name,
        ];
    }
}
