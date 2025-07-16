<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Applicant extends Model
{
    protected $fillable = [
        'user_id',
        'job_id',
        'full_name',
        'contact_phone',
        'contact_email',
        'message',
        'location',
        'cv_path'
    ];

    // Applicant belongs to a job
    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }

    // relation to user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
