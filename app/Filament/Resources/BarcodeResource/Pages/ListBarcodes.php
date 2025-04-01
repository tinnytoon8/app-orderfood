<?php

namespace App\Filament\Resources\BarcodeResource\Pages;

use App\Filament\Resources\BarcodeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBarcodes extends ListRecords
{
    protected static string $resource = BarcodeResource::class;

    protected static?string $title = 'Qr Codes';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
