<?php

namespace App\Http\Controllers;

use App\Models\Dealer\Dealer;
use Illuminate\Http\JsonResponse;

class DealerController extends Controller
{
    /** * Get all active dealers. */
    public function index(): JsonResponse
    {
        $dealers = Dealer::query()->where('is_active', true)->with(['locations' => function ($query) {
            $query->where('is_active', true)->with(['phones' => function ($query) {
                $query->orderBy('sort_order');
            }])->orderBy('sort_order');
        }])->orderBy('sort_order')->get();

        return response()->json($dealers);
    }

    /** * Get active dealer by ID. */
    public function show(Dealer $dealer): JsonResponse
    {
        abort_unless($dealer->is_active, 404);
        $dealer->load(['locations' => function ($query) {
            $query->where('is_active', true)->with(['phones' => function ($query) {
                $query->orderBy('sort_order');
            }])->orderBy('sort_order');
        }]);

        return response()->json($dealer);
    }
}
