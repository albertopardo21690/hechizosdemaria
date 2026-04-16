<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Filament\Resources\PageResource\RelationManagers;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Paginas';

    protected static ?string $pluralModelLabel = 'Paginas';

    protected static ?string $modelLabel = 'Pagina';

    protected static ?string $navigationGroup = 'Contenido';

    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Titulo')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('slug', \Illuminate\Support\Str::slug($state))),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\RichEditor::make('content')
                    ->label('Contenido')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('excerpt')
                    ->label('Resumen')
                    ->rows(2)
                    ->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('Configuracion')->schema([
                Forms\Components\Select::make('status')
                    ->options(['draft' => 'Borrador', 'published' => 'Publicada'])
                    ->default('draft')
                    ->required(),
                Forms\Components\Select::make('template')
                    ->options([
                        'default' => 'Default',
                        'landing' => 'Landing',
                        'legal' => 'Legal',
                    ])
                    ->default('default')
                    ->required(),
                Forms\Components\TextInput::make('sort')
                    ->numeric()
                    ->default(0),
            ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Titulo')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => 'published',
                        'warning' => 'draft',
                    ]),
                Tables\Columns\TextColumn::make('template')->sortable(),
                Tables\Columns\TextColumn::make('sort')->numeric()->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('sort', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options([
                    'published' => 'Publicada',
                    'draft' => 'Borrador',
                ]),
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
            'index' => Pages\ManagePages::route('/'),
        ];
    }
}
