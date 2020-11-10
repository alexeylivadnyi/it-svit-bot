<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    public const FILTER_BY_LINK = 'link';
    public const FILTER_BY_DATE = 'date';
    public const FILTER_BY_DESCRIPTION = 'description';
    public const FILTER_BY_CATEGORY = 'category';

    public $fillable = [
        'link',
        'title',
        'lang',
        'description',
        'issue_number',
        'issue_url',
        'date',
        'category_id'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
