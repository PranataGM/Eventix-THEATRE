<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'name',
        'slug',
        'icon',
    ];

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
