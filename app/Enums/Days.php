<?php

namespace App\Enums;

enum Days: string
{
    case MONDAY = 'Monday';
    case TUESDAY = 'Tuesday';
    case WEDNESDAY = 'Wednesday';
    case THURSDAY = 'Thursday';
    case FRIDAY = 'Friday';
    case SATURDAY = 'Saturday';
    case SUNDAY = 'Sunday';

    // وظيفة مساعدة لتطابق القيمة المدخلة
    public static function fromInput(string $input): ?self
    {
        return match (strtolower($input)) {
            'monday' => self::MONDAY,
            'tuesday' => self::TUESDAY,
            'wednesday' => self::WEDNESDAY,
            'thursday' => self::THURSDAY,
            'friday' => self::FRIDAY,
            'saturday' => self::SATURDAY,
            'sunday' => self::SUNDAY,
            default => null,
        };
    }
}
