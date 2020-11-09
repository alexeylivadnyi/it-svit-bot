<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    public $fillable = [
        'title',
    ];

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }
}
