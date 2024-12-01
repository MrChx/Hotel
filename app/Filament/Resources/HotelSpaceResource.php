<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HotelSpaceResource\Pages;
use App\Filament\Resources\HotelSpaceResource\RelationManagers;
use App\Models\HotelSpace;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HotelSpaceResource extends Resource
{
    protected static ?string $model = HotelSpace::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),

                Forms\Components\TextInput::make('address')
                ->required()
                ->maxLength(255),

                Forms\Components\FileUpload::make('thumbnail')
                ->image()
                ->required(),

                Forms\Components\Textarea::make('about')
                ->required()
                ->rows(10)
                ->cols(20),

                Forms\Components\Repeater::make('photos')
                ->relationship('photos')
                ->schema([
                    Forms\Components\FileUpload::make('photo')
                    ->required(),
                ]),

                Forms\Components\Repeater::make('benefits')
                ->relationship('benefits')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required(),
                ]),

                Forms\Components\Select::make('city_id')
                ->relationship('city', 'name')
                ->searchable()
                ->preload()
                ->required(),

                Forms\Components\TextInput::make('price')
                ->required()
                ->numeric()
                ->prefix('IDR'),

                Forms\Components\TextInput::make('duration')
                ->required()
                ->numeric()
                ->prefix('Days'),

                Forms\Components\Select::make('is_open')
                ->options([
                    true => 'open',
                    false => 'not open',
                ])
                ->required(),

                Forms\Components\Select::make('is_full_booked')
                ->options([
                    true => 'not available',
                    false => 'available',
                ])
                ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                ->searchable(),

                Tables\Columns\ImageColumn::make('thumbnail'),

                Tables\Columns\TextColumn::make('city.name'),

                Tables\Columns\IconColumn::make('is_full_booked')
                    ->boolean()
                    ->trueColor('danger')
                    ->falseColor('success')
                    ->trueIcon('heroicon-o-x-circle')
                    ->falseIcon('heroicon-o-check-circle')
                    ->label('Available'),

            ])
            ->filters([
                SelectFilter::make('city_id')
                ->label('city')
                ->relationship('city', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHotelSpaces::route('/'),
            'create' => Pages\CreateHotelSpace::route('/create'),
            'edit' => Pages\EditHotelSpace::route('/{record}/edit'),
        ];
    }
}
