<?php

namespace App\Filament\Imports\Customer;

use App\Enums\Status;
use App\Models\Customer\Customer;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Models\Import;
use App\Filament\Imports\shared\FilamentImportTrait;

class CustomerImporter extends Importer
{
    use FilamentImportTrait;

    protected static ?string $model = Customer::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('identification')
                ->label(__('app.identification'))
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('name')
                ->label(__('app.name'))
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('phone')
                ->label('Detalles')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
        ];
    }

    public function resolveRecord(): ?Customer
    {
        return match (!empty($this->options['update_existing'])) {
            true => Customer::firstOrNew([
                'identification' => $this->data['identification'],
            ]),
            default => new Customer(),
        };
    }
}
