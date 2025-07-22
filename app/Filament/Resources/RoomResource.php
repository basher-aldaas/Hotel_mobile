<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoomResource\Pages;
use App\Models\Room;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RoomResource extends Resource
{
    protected static ?string $model = Room::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';
    protected static ?string $navigationLabel = 'Rooms';
    protected static ?string $pluralLabel = 'Rooms';
    protected static ?string $label = 'rooms';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')
                ->required()
                ->maxLength(255),

            Forms\Components\FileUpload::make('image')
                ->image()
                ->required()
                ->directory('rooms')
                ->imagePreviewHeight('150')
                ->loadingIndicatorPosition('left')
                ->panelAspectRatio('2:1')
                ->panelLayout('integrated'),

            Forms\Components\Textarea::make('description')
                ->maxLength(500),

            Forms\Components\TextInput::make('price')
                ->numeric()
                ->required(),

            Forms\Components\Toggle::make('wifi')
                ->label('Wi-Fi Available')
                ->default(false),

            Forms\Components\Select::make('room_type')
                ->required()
                ->options([
                    'regular' => 'Regular',
                    'premium' => 'Premium',
                    'deluxe' => 'Deluxe',
                ]),

            Forms\Components\Toggle::make('status')
                ->label('Is Active'),

            Forms\Components\TextInput::make('bed_number')
                ->required()
                ->numeric(),

            Forms\Components\TextInput::make('valuation')
                ->numeric()
                ->label('Rating')
                ->minValue(0)
                ->maxValue(5),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\ImageColumn::make('image')
                ->label('Image')
                ->disk('public')
                ->circular(),

            Tables\Columns\TextColumn::make('title')->searchable(),
            Tables\Columns\TextColumn::make('price')->sortable(),
            Tables\Columns\IconColumn::make('wifi')
                ->boolean()
                ->label('Wi-Fi'),
            Tables\Columns\TextColumn::make('room_type'),
            Tables\Columns\IconColumn::make('status')
                ->boolean()
                ->label('Active'),
            Tables\Columns\TextColumn::make('bed_number'),
            Tables\Columns\TextColumn::make('valuation'),
            Tables\Columns\TextColumn::make('created_at')->dateTime(),
        ])
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRooms::route('/'),
            'create' => Pages\CreateRoom::route('/create'),
            'view' => Pages\ViewRoom::route('/{record}'),
            'edit' => Pages\EditRoom::route('/{record}/edit'),
        ];
    }
}
