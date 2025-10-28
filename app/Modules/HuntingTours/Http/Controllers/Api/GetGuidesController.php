<?php

namespace App\Modules\HuntingTours\Http\Controllers\Api;

use App\Modules\HuntingTours\Http\Controllers\Controller;
use App\Modules\HuntingTours\Http\Requests\GetGuidesRequest;
use App\Modules\HuntingTours\Http\Resources\GuideResource;
use App\Modules\HuntingTours\Services\GuideService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class GetGuidesController extends Controller
{
    public function __construct(
        private readonly GuideService $guideService,
    ) {}

    public function __invoke(GetGuidesRequest $request): AnonymousResourceCollection
    {
        $validated = $request->validated();

        if (isset($validated['min_experience'])) {
            $minExperience = (int) $validated['min_experience'];
            $guides = $this->guideService->getActiveGuidesMinExperience($minExperience);
        } else {
            $guides = $this->guideService->getActiveGuides();
        }

        return GuideResource::collection($guides);
    }
}
