<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_date',
        'to_date',
        'return_date',
        'delivere',
        'returned',
        'book_id',
        'user_id',
    ];

    protected $hidden = [
        'updated_at',
        'laravel_related_key',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
