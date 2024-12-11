<?php

namespace App\Http\Controllers\Api\V1\Customer\TvShow;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Customer\TvShow\ListResource;
use App\Models\TvShow;
use App\Repositories\TvShowRepository;
use Botble\Base\Enums\BaseStatusEnum;
use Illuminate\Http\Request;

class ListController extends Controller
{
    public function __invoke(Request $request)
    {
        $pageSize = 20;
        $categoryId = null;
        if($request->has('category_id')) {
            $categoryId = $request->input('category_id');
        }
        if($request->has('featured')) {
            $featured = $request->input('featured');
        }

        $tvShows = TvShow::where('status', BaseStatusEnum::PUBLISHED()->getValue())
            ->when(!is_null($categoryId), function($query) use ($categoryId) {
                $query->whereHas('categories', function ($query) use ($categoryId) {
                    $query->where('show_categories.id', $categoryId);
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($pageSize);

        $tvShows = TvShowRepository::all([
            'sortByTitle' => null,
            'sortByTime' => null,
            'sortByDate' => 'desc'
        ])
            ->when(!is_null($categoryId), function($query) use ($categoryId) {
                $query->whereHas('categories', function ($query) use ($categoryId) {
                    $query->where('show_categories.id', $categoryId);
                });
            })
            ->paginate($pageSize);
        $tvShows->load(['categories', 'casts']);

        return response()->json([
            'success' => true,
            'message' => ApiResponseMessageEnum::TV_SHOWS->value,
            'data' => [
                'tv-shows' => ListResource::collection($tvShows),
                'pagination' => customPagination($tvShows)
            ]
        ]);
    }
}
