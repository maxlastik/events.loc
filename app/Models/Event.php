<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'description',
        'start_date',
        'end_date',
        'status'
    ];

    /**
     * The categories that belong to the event.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_event');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'event_user');
    }
}
