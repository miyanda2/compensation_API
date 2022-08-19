<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UploadCompensationdata extends Model
{
    use HasFactory;
    protected $fillable = [
        'age',
        'industry',
        'role',
        'annualSalary',
        'currencyType',
        'location(City)',
        'yearOfExperince',
        'additionalContents',
        'other',
    ];
}
