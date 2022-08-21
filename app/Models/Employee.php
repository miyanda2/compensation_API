<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'fullName',
        'email',
        'eId',
    ];



public function compensation()
{
    return $this->belongsToMany(Employee::class, 'employee_id');
}
 }
