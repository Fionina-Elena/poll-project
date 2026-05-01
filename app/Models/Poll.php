<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Poll extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'short_code'
    ];

    protected $guarded = [
        'created_at'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s'
    ];

    public function options(): HasMany
    {
        return $this->hasMany(Option::class);
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }
}
