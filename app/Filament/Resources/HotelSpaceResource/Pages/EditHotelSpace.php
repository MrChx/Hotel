<?php

namespace App\Filament\Resources\HotelSpaceResource\Pages;

use App\Filament\Resources\HotelSpaceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHotelSpace extends EditRecord
{
    protected static string $resource = HotelSpaceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
