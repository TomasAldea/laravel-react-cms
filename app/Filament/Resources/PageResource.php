<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Filament\Resources\PageResource\RelationManagers;
use App\Models\Page;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
/* Chatgpt */
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Placeholder;
use Illuminate\Support\HtmlString;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->columnSpan(1)
                    ->maxLength(255),
                Repeater::make('modules')
                    ->relationship('modules')
                    ->schema([
                        Select::make('type')
                            ->options([
                                'header' => 'Header',
                                'text' => 'Text',
                                'image' => 'Image',
                            ])
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                switch ($state) {
                                    case 'header':
                                        $set('content', [
                                            'title' => '',
                                            'subtitle' => '',
                                            'link' => '',
                                            'image_url' => '',
                                        ]);
                                        break;
                                    case 'text':
                                        $set('content', [
                                            'content' => '',
                                        ]);
                                        break;
                                    case 'image':
                                        $set('content', [
                                            'image_url' => '',
                                            'caption' => '',
                                        ]);
                                        break;
                                }
                            }),
                        Placeholder::make('Image')
                            ->content(function (): HtmlString {
                                return new HtmlString("<img style='width: 400px' src='http://127.0.0.1:8000/imagesPanel/ejemplo.png')>");
                            }),
                        TextInput::make('content.title')
                            ->required()
                            ->hidden(fn (callable $get) => $get('type') !== 'header'),
                        TextInput::make('content.subtitle')
                            ->hidden(fn (callable $get) => $get('type') !== 'header'),
                        TextInput::make('content.link')
                            ->hidden(fn (callable $get) => $get('type') !== 'header'),
                        RichEditor::make('content.content')
                            ->required()
                            ->hidden(fn (callable $get) => $get('type') !== 'text'),
                        TextInput::make('content.caption')
                            ->hidden(fn (callable $get) => $get('type') !== 'image'),

                        CuratorPicker::make('media')
                            ->constrained(true | false) // defaults to false (forces image to fit inside the preview area)
                            ->acceptedFileTypes(['image/jpeg', 'image/png'])
                            ->multiple(),


                    ])
                    ->columnSpan('full')
                    ->createItemButtonLabel('Add Module')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
