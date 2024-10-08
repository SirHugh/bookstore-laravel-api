<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    protected $hidden = [
        'laravel_through_key',
        'created_at',
        'updated_at'
    ];

    public function book()
    {
        return $this->hasManyThrough(
            Book::class,
            BookAuthor::class,
            'author_id', //forein author key on the book_author table 
            'id',       //local key in the authors table
            'id',       //local key in the books table
            'book_id',  //forein key on the book_author table
        );
    }
}
