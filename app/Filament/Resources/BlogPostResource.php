<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogPostResource\Pages;
use App\Models\BlogPost;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BlogPostResource extends Resource
{
    protected static ?string $model = BlogPost::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationLabel = 'Blog / Horoscopo';

    protected static ?string $pluralModelLabel = 'Posts del blog';

    protected static ?string $modelLabel = 'Post';

    protected static ?string $navigationGroup = 'Contenido';

    protected static ?int $navigationSort = 30;

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
                Forms\Components\Textarea::make('excerpt')
                    ->label('Resumen')
                    ->rows(2)
                    ->columnSpanFull(),
                Forms\Components\RichEditor::make('content')
                    ->label('Contenido')
                    ->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('Publicacion')->schema([
                Forms\Components\Select::make('status')
                    ->options(['draft' => 'Borrador', 'published' => 'Publicado'])
                    ->default('draft')
                    ->required(),
                Forms\Components\Select::make('category')
                    ->label('Categoria')
                    ->options([
                        'horoscopo' => 'Horoscopo',
                        'tarot' => 'Tarot',
                        'rituales' => 'Rituales',
                        'espiritualidad' => 'Espiritualidad',
                        'noticias' => 'Noticias',
                    ])
                    ->nullable(),
                Forms\Components\Select::make('zodiac_sign')
                    ->label('Signo (si aplica)')
                    ->options([
                        'aries' => 'Aries', 'tauro' => 'Tauro', 'geminis' => 'Geminis',
                        'cancer' => 'Cancer', 'leo' => 'Leo', 'virgo' => 'Virgo',
                        'libra' => 'Libra', 'escorpio' => 'Escorpio', 'sagitario' => 'Sagitario',
                        'capricornio' => 'Capricornio', 'acuario' => 'Acuario', 'piscis' => 'Piscis',
                    ])
                    ->nullable(),
                Forms\Components\DateTimePicker::make('published_at')
                    ->label('Fecha publicacion')
                    ->nullable(),
            ])->columns(2),
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
                Tables\Columns\TextColumn::make('category')
                    ->label('Categoria')
                    ->badge(),
                Tables\Columns\TextColumn::make('zodiac_sign')
                    ->label('Signo')
                    ->badge(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => 'published',
                        'warning' => 'draft',
                    ]),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Publicado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options([
                    'published' => 'Publicado',
                    'draft' => 'Borrador',
                ]),
                Tables\Filters\SelectFilter::make('category')->options([
                    'horoscopo' => 'Horoscopo',
                    'tarot' => 'Tarot',
                    'rituales' => 'Rituales',
                    'espiritualidad' => 'Espiritualidad',
                    'noticias' => 'Noticias',
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
            'index' => Pages\ManageBlogPosts::route('/'),
        ];
    }
}
