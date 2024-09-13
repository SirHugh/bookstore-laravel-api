<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'publication_year',
        'stock',
        'is_active'
    ];

    protected $hidden = [
        'created_at',
        'laravel_through_key',
        'updated_at',
        'stock',
        'is_active'
    ];

    public function author()
    {
        return $this->hasManyThrough(
            Author::class,
            BookAuthor::class,
            'book_id',      //forein key on the book_author table
            'id',           //local key in the books table
            'id',           //local key in the authors table
            'author_id',    //forein author key on the book_author table 
        );
    }

    public function genre() //: HasMany
    {
        return $this->hasManyThrough(
            Genre::class,
            BookGenre::class,
            'book_id',
            'id',
            'id',
            'genre_id',
        );
    }

    public function rents()
    {
        return $this->hasMany(Rent::class);
    }
}
