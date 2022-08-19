<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compensation extends Model
{
    use HasFactory;

    protected $fillable = [
        'age',
        'industry',
        'role',
        'annualSalary',
        'currencyType',
        'loc',
        'yearOfExperince',
        'additionalContents',
        'other',
    ];



public function employee()
{
    //return $this->belongsTo(Employee::class, 'employee_id');
}
 }
