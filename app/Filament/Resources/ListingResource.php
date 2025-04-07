<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ListingResource\Pages;
use App\Models\Listing;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class ListingResource extends Resource
{
    protected static ?string $model = Listing::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationGroup = 'Listings Management';
    protected static ?string $navigationLabel = 'Equipment Listings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->label('Tool Name'),
                TextInput::make('condition')
                    ->required()
                    ->label('Condition/Health'),
                TextInput::make('location')
                    ->required()
                    ->label('Location'),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->label('Price (Rental)'),
                FileUpload::make('image')
                    ->label('Tool Image')
                    ->image()
                    ->disk('public'),
                Textarea::make('description')
                    ->label('Description')
                    ->rows(3)
                    ->placeholder('Additional details about the tool'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Tool Name'),
                TextColumn::make('condition')->label('Condition'),
                TextColumn::make('location')->label('Location'),
                TextColumn::make('price')->label('Price')->money('usd', true),
                TextColumn::make('created_at')
                    ->label('Listed')
                    ->dateTime('M d, Y'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                // Custom "Contact Owner" action:
                Tables\Actions\Action::make('contact')
    ->label('Contact Owner')
    ->url(fn (Listing $record) => route('chat.start', ['user' => $record->user_id])) // Ensure correct parameter name
    ->icon('heroicon-o-mail')
    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageListings::route('/'),
        ];
    }
}
