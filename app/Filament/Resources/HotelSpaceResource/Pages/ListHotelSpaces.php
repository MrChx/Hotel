<?php

namespace App\Filament\Resources\HotelSpaceResource\Pages;

use App\Filament\Resources\HotelSpaceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHotelSpaces extends ListRecords
{
    protected static string $resource = HotelSpaceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
