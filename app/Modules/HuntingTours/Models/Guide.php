<?php

namespace App\Modules\HuntingTours\Models;

use App\Modules\HuntingTours\Database\Factories\GuideFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guide extends Model
{
    use HasFactory;

    protected $table = 'hunting_guides';

    protected $fillable = [
        'name',
        'experience_years',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'experience_years' => 'integer',
    ];

    public function huntingBookings(): HasMany
    {
        return $this->hasMany(HuntingBooking::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeMinExperience($query, int $years)
    {
        return $query->where('experience_years', '>=', $years);
    }

    protected static function newFactory()
    {
        return GuideFactory::new();
    }
}
