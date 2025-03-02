<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LigaBarangayResource\Pages;
use App\Models\LigaBarangay;
use Filament\Actions\Action;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\File;
use ZipArchive;

class LigaBarangayResource extends Resource
{
    protected static ?string $model = LigaBarangay::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';

    protected static ?string $navigationGroup = 'Client Management';

    protected static ?string $navigationLabel = 'Liga ng Barangay';

    protected static ?bool $canCreate = false;

    public static function getBreadcrumb(): string
    {
        return 'Liga ng Barangay';
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //! find way to get the photo
                // ImageColumn::make('header_image')
                //     ->disk('s3'),
                TextColumn::make('id')->sortable()->searchable(),
                TextColumn::make('lastname')->sortable()->searchable(),
                TextColumn::make('firstname')->sortable()->searchable(),
                TextColumn::make('middlename')->sortable()->searchable(),
                TextColumn::make('extension')->sortable()->searchable(),
                TextColumn::make('home_address')->sortable()->searchable(),
                TextColumn::make('gender')->sortable()->searchable(),
                TextColumn::make('birthdate')->sortable()->searchable(),
                TextColumn::make('barangay')->sortable()->searchable(),
                TextColumn::make('city')->sortable()->searchable(),
                TextColumn::make('province')->sortable()->searchable(),
                TextColumn::make('region')->sortable()->searchable(),
                TextColumn::make('emergency_contact_person')->sortable()->searchable(),
                TextColumn::make('emergency_contact_number')->sortable()->searchable(),
                TextColumn::make('year_elected')->sortable()->searchable(),
                TextColumn::make('term')->sortable()->searchable(),

                TextColumn::make('created_at')->dateTime('M d, Y'),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                //
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
            ])
            ->headerActions([
                Tables\Actions\Action::make('Download')
                    ->form([
                        Grid::make(2) // 👈 Arrange the next two fields in one row
                        ->schema([
                            TextInput::make('start')
                                ->label('Start ID')
                                ->numeric()
                                ->required(),
                            TextInput::make('end')
                                ->label('End ID')
                                ->numeric()
                                ->required(),
                        ]),

                    ])
                    ->modalHeading('Download')
                    ->action(function (array $data) {
                        return self::exportData($data['start'], $data['end']);
                    })
                    ->color('success')
                    ->icon('heroicon-o-arrow-down-circle'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListLigaBarangays::route('/'),
            'create' => Pages\CreateLigaBarangay::route('/create'),
            'edit' => Pages\EditLigaBarangay::route('/{record}/edit'),
        ];
    }


    /**
     * Export Data as ZIP with CSV and Images
     */
    public static function exportData(int $start, int $end)
    {
        // Fetch data
        $results = LigaBarangay::select(
            'id', 'lastname', 'firstname', 'middlename', 'extension',
            'home_address', 'gender', 'birthdate', 'region', 'province',
            'city', 'barangay', 'signature', 'photo', 'emergency_contact_person',
            'emergency_contact_number', 'year_elected', 'term'
        )
            ->whereBetween('id', [$start, $end])
            ->orderBy('id', 'asc')
            ->get();

        // Create temporary folder
        $tempPath = storage_path('app/temp_export');
        File::ensureDirectoryExists($tempPath);

        // Generate CSV file
        $csvPath = "{$tempPath}/barangay_data.csv";
        $csvFile = fopen($csvPath, 'w');
        fputcsv($csvFile, array_keys($results->first()->toArray())); // Headers

        foreach ($results as $row) {
            fputcsv($csvFile, $row->toArray());
            self::copyImageToTemp($row->id, 'photo', $tempPath);
            self::copyImageToTemp($row->id, 'signature', $tempPath);
        }
        fclose($csvFile);

        // Create ZIP file
        $zipPath = storage_path("app/barangay_export_{$start}_{$end}.zip");
        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            // Add CSV to ZIP
            $zip->addFile($csvPath, 'barangay_data.csv');

            // Add images to ZIP
            foreach (['photo', 'signature'] as $folder) {
                $folderPath = "{$tempPath}/{$folder}";
                if (File::exists($folderPath)) {
                    foreach (File::files($folderPath) as $file) {
                        $zip->addFile($file->getRealPath(), "{$folder}/" . $file->getFilename());
                    }
                }
            }
            $zip->close();
        }

        // Clean up temporary files
        File::deleteDirectory($tempPath);

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    /**
     * Copy image from external storage
     */
    public static function copyImageToTemp($id, $folder, $tempPath)
    {
        $storagePath = storage_path("../../azitsorog-backend/storage/app/{$folder}/{$id}.jpg");
        $destinationPath = "{$tempPath}/{$folder}/{$id}.jpg";

        if (File::exists($storagePath)) {
            File::ensureDirectoryExists(dirname($destinationPath));
            File::copy($storagePath, $destinationPath);
        }
    }
}
