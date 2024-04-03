<?php

namespace App\Enums;

use App\Enums\shared\EnumsTrait;
use App\Enums\shared\FilamentEnumsTrait;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum StatusEnum: int implements HasColor, HasLabel
{
    use EnumsTrait, FilamentEnumsTrait;

    case active = 1;

    case inactive = 2;

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::active => 'success',
            self::inactive => 'danger',
        };
    }
}
