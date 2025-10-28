<?php

namespace App\Modules\HuntingTours\Http\Controllers\Api;

use App\Modules\HuntingTours\Http\Controllers\Controller;
use App\Modules\HuntingTours\Http\Requests\StoreHuntingBookingRequest;
use App\Modules\HuntingTours\Http\Resources\HuntingBookingResource;
use App\Modules\HuntingTours\Services\BookingService;
use Illuminate\Http\JsonResponse;

final class StoreHuntingBookingController extends Controller
{
    public function __construct(
        private readonly GuideService $guideService,
        private readonly BookingService $bookingService,
    )
    {
    }

    public function __invoke(StoreHuntingBookingRequest $request): JsonResponse
    {
        $validated = $request->validated();

        if (!$this->guideService->isAvailableOn($validated['guide_id'], $validated['date'])) {
            return response()->json([
                'message' => 'Гид уже забронирован на эту дату',
                'errors' => [
                    'guide_id' => ['Выбранный гид недоступен на указанную дату'],
                ],
            ], 422);
        }

        $booking = $this->bookingService->createBooking($validated);

        return response()->json([
            'message' => 'Бронирование успешно создано',
            'data' => new HuntingBookingResource($booking),
        ], 201);
    }
}
