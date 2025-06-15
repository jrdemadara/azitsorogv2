<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LigaBarangay extends Model
{
    protected $connection = "pgsql_lnb";
    protected $table = "profiles";
    protected $fillable = [
        "id",
        "lastname",
        "firstname",
        "middlename",
        "extension",
        "home_address",
        "gender",
        "birthdate",
        "region",
        "province",
        "city",
        "barangay",
        "signature",
        "photo",
        "emergency_contact_person",
        "emergency_contact_number",
        "year_elected",
        "term",
        "is_downloaded",
    ];
}
