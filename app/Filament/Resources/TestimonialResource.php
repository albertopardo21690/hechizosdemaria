<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Models\Testimonial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';

    protected static ?string $navigationLabel = 'Testimonios';

    protected static ?string $pluralModelLabel = 'Testimonios';

    protected static ?string $modelLabel = 'Testimonio';

    protected static ?string $navigationGroup = 'Contenido';

    protected static ?int $navigationSort = 20;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(120),
                Forms\Components\TextInput::make('location')
                    ->label('Ubicacion')
                    ->placeholder('Madrid, Espana')
                    ->maxLength(120),
                Forms\Components\Textarea::make('text')
                    ->label('Testimonio')
                    ->required()
                    ->rows(4)
                    ->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('Clasificacion')->schema([
                Forms\Components\Select::make('rating')
                    ->label('Valoracion')
                    ->options([1 => '1 estrella', 2 => '2', 3 => '3', 4 => '4', 5 => '5 estrellas'])
                    ->default(5)
                    ->required(),
                Forms\Components\Select::make('service_type')
                    ->label('Servicio')
                    ->options([
                        'lectura' => 'Lectura de tarot',
                        'ritual' => 'Ritual',
                        'producto' => 'Producto tienda',
                        'curso' => 'Curso / libro',
                        'otro' => 'Otro',
                    ])
                    ->nullable(),
                Forms\Components\Toggle::make('featured')
                    ->label('Destacado en home'),
                Forms\Components\Toggle::make('approved')
                    ->label('Aprobado para publicar')
                    ->default(false),
                Forms\Components\TextInput::make('sort')
                    ->label('Orden')
                    ->numeric()
                    ->default(0),
            ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('location')
                    ->label('Ubicacion')
                    ->searchable(),
                Tables\Columns\TextColumn::make('text')
                    ->label('Testimonio')
                    ->limit(60),
                Tables\Columns\TextColumn::make('rating')
                    ->label('Estrellas')
                    ->formatStateUsing(fn ($state) => str_repeat('*', $state)),
                Tables\Columns\IconColumn::make('featured')
                    ->label('Destacado')
                    ->boolean(),
                Tables\Columns\IconColumn::make('approved')
                    ->label('Aprobado')
                    ->boolean(),
                Tables\Columns\TextColumn::make('service_type')
                    ->label('Servicio')
                    ->badge(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('approved')->label('Aprobado'),
                Tables\Filters\TernaryFilter::make('featured')->label('Destacado'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageTestimonials::route('/'),
        ];
    }
}
