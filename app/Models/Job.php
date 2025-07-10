<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Job extends Model
{
    use HasFactory;

    protected $table = 'job_listings'; // because our job model points to job_listings table

    protected $fillable = ['title', 'description', 'salary', 'tags', 'job_type', 'remote', 'requirements', 'benefits', 'address', 'city', 'state', 'postcode', 'contact_email', 'contact_phone', 'company_name', 'company_description', 'company_logo', 'company_website', 'user_id'];

    // relationship to user, jobs belong to a user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // relationship to bookmarks
    // users can have multiple bookmarks, bookmarks can have multiple users
    public function bookmarkedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'job_user_bookmarks')->withTimestamps();
    }
}
