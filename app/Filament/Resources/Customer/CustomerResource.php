<?php

namespace App\Filament\Resources\Customer;

use Filament\Forms;
use Filament\Tables;
use App\Enums\Status;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use App\Models\Customer\Customer;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Customer\CustomerResource\Pages;
use App\Filament\Resources\Customer\CustomerResource\RelationManagers;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getModelLabel(): string
    {
        return Str::lower(__('app.customer'));
    }

    public static function getPluralModelLabel(): string
    {
        return __('app.customers');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('app.customers');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('identification')
                    ->label(__('app.identification'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('name')
                    ->label(__('app.name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->label(__('app.phone'))
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Select::make('status')
                    ->label(__('app.status'))
                    ->options(Status::class)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('identification')
                    ->label(__('app.identification'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('app.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label(__('app.phone'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->label(__('app.status')),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions(
                \App\Filament\Tables\Actions::getActions()
            )
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make(
                    \App\Filament\Tables\Actions::bulkActions()
                ),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ContactsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'view' => Pages\ViewCustomer::route('/{record}'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
