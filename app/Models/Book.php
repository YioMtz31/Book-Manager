<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

          /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'author_id',
        'category_id',
        'publication_date',
        'user_id'
    ];

    /**
     * Get the author associated with the book.
     */
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    /**
     * Get the category associated with the book.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    protected $with = ['author', 'category'];
}
