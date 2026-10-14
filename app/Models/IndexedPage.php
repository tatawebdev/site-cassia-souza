<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** URL enviada à Google Indexing API e o resultado do último envio. */
class IndexedPage extends Model
{
    protected $fillable = ['url', 'indexed_at', 'last_error'];

    protected function casts(): array
    {
        return ['indexed_at' => 'datetime'];
    }
}
