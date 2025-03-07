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
use Illuminate\Support\Facades\Storage;
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
            'index'  => Pages\ListLigaBarangays::route('/'),
            'create' => Pages\CreateLigaBarangay::route('/create'),
            'edit'   => Pages\EditLigaBarangay::route('/{record}/edit'),
        ];
    }

    /**
     * Export Data as ZIP with CSV and Images
     */
    public static function exportData($start, $end)
    {
        set_time_limit(300);

        $results = LigaBarangay::select(
            'id',
            'lastname',
            'firstname',
            'middlename',
            'extension',
            'home_address',
            'gender',
            'birthdate',
            'region',
            'province',
            'city',
            'barangay',
            'signature',
            'photo',
            'emergency_contact_person',
            'emergency_contact_number',
            'year_elected',
            'term'
        )
            ->whereBetween('id', [$start, $end])
            ->orderBy('id', 'asc')
            ->get();

        // Create a ZIP file
        $zipFileName = "download_{$start}_{$end}.zip";
        $zipPath     = storage_path("app/public/{$zipFileName}");

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE) === true) {
            // Add CSV file
            $csvData = static::generateCSV($results);
            $zip->addFromString("results_{$start}_{$end}.csv", $csvData);

            // Add images
            foreach ($results as $person) {
                static::addFileToZip($zip, 'profiles/' . $person->photo, 'profiles', $person->id, 'jpg');
                static::addFileToZip($zip, 'signatures/' . $person->signature, 'signatures', $person->id, 'png');
            }

            $zip->close();

            return response()->download($zipPath)->deleteFileAfterSend(true);
        }

        return response()->json(['message' => 'Unable to create ZIP file'], 500);
    }

    private static function generateCSV($results)
    {
        $csv = "ID, Lastname, Firstname, Middlename, Extension, Gender, Birthdate, Region, Province, City, Barangay, Emergency Contact Person, Emergency Contact Number, Year Elected, Term \n";

        foreach ($results as $person) {
            $csv .= "{$person->id}, {$person->lastname}, {$person->firstname}, {$person->middlename}, {$person->extension}, {$person->gender}, {$person->birthdate}, {$person->region}, {$person->province}, {$person->city}, {$person->barangay}, {$person->emergency_contact_person}, {$person->emergency_contact_number}, {$person->year_elected}, {$person->term}\n";
        }

        return $csv;
    }

    private static function addFileToZip($zip, $filePath, $folder, $id, $extension)
    {
        $filePath = "private/{$filePath}";

        // Storage disk is `external_storage` as defined in config/filesystems.php
        if (Storage::disk('external_storage')->exists($filePath)) {
            $fileContent = Storage::disk('external_storage')->get($filePath);
            $zip->addFromString("{$folder}/{$id}.{$extension}", $fileContent);
        }
    }
}
