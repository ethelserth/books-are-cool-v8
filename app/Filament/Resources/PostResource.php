<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Tables\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Str;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\ImageColumn;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Main Informations')
                    ->schema([
                        TextInput::make('title')
                            ->live()
                            ->required()
                            ->maxLength(150)
                            ->afterStateUpdated(
                                function(string $operation, $state, Forms\Set $set){
                                    if($operation == 'create'){
                                        $set('slug',Str::slug($state));
                                    }
                                }
                            ),
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(150),
                        Checkbox::make('enabled'),
                        Checkbox::make('featured'),
                        TextInput::make('author')->required(),
                        DateTimePicker::make('published_at')->nullable(),
                        FileUpload::make('image')
                            ->image()
                            ->directory('posts/covers')
                            ->columnSpanFull(),
                        Select::make('categories')
                            ->relationship('categories','title')
                            ->searchable()
                            ->multiple(),
                    ])->columns(2),
                Section::make('Content')
                    ->schema([
                        RichEditor::make('content')
                            ->required()
                            ->fileAttachmentsDirectory('posts/images')
                            ->columnSpanFull(),
                    ]),
                Section::make('Seo')
                    ->schema([
                        TextInput::make('meta_description')->nullable(),
                        TextInput::make('meta_title')->nullable(),
                        TextInput::make('meta_keywords')->nullable(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image'),
                TextColumn::make('title')->sortable()->searchable(),
                TextColumn::make('author')->sortable()->searchable(),
                TextColumn::make('categories.title')->sortable()->searchable(),
                TextColumn::make('published_at')->date('Y-m-d')->sortable(),
                CheckboxColumn::make('enabled'),
                CheckboxColumn::make('featured'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                Action::make('notion.sync')
                ->label('Sync Notion')
                ->url(route('notion.sync'))
            ])
            ;
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }    

}
