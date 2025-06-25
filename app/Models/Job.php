<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $table = 'job_listings'; // because our job model points to job_listings table

    protected $fillable = ['title', 'description'];
}
