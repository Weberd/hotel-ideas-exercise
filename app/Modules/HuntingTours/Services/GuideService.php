<?php

namespace App\Modules\HuntingTours\Services;

use App\Modules\HuntingTours\Models\Guide;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;
use Ramsey\Uuid\Guid\Guid;

class GuideService
{
    public function getActiveGuides(): Collection
    {
        $query = Guide::query()->active();
        return $query->orderBy('experience_years', 'desc')->get();
    }

    public function getActiveGuidesMinExperience(int $minExperience): Collection
    {
        $query = Guide::query()->active();
        $query->minExperience($minExperience);
        return $query->orderBy('experience_years', 'desc')->get();
    }

    public function isAvailableOn(int $guideId, string $date): bool
    {
        $guide = Guide::findOrFail($guideId);

        return !$guide->huntingBookings()
            ->whereDate('date', $date)
            ->exists();
    }
}
