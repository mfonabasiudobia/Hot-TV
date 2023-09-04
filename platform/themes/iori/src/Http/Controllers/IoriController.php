<?php

namespace Theme\Iori\Http\Controllers;

use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Blog\Models\Category;
use Botble\Ecommerce\Facades\EcommerceHelper;
use Botble\Ecommerce\Services\Products\GetProductService;
use Botble\Theme\Facades\Theme;
use Botble\Theme\Http\Controllers\PublicController;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Request;

class IoriController extends PublicController
{
    public function __construct(protected BaseHttpResponse $httpResponse)
    {
        $this->middleware(function ($request, $next) {
            if (! $request->ajax()) {
                return $this->httpResponse->setNextUrl(route('public.index'));
            }

            return $next($request);
        })->only([
            'ajaxGetPostByCategory',
            'ajaxGetProducts',
            'getProducts',
        ]);
    }

    public function ajaxGetPostByCategory(int|string $categoryId, BaseHttpResponse $response)
    {
        $category = Category::query()
            ->where('id', $categoryId)
            ->wherePublished()
            ->first();

        if (! $category) {
            abort(404);
        }

        $posts = $category->loadMissing(['posts' => function (Builder $query) {
            $query->wherePublished();
        }])->posts;

        return $response->setData(Theme::partial('posts.posts', compact('posts')));
    }

    public function ajaxGetProducts(Request $request, BaseHttpResponse $response)
    {
        $limit = $request->integer('limit', 10) ?: 10;

        $products = match ($request->query('type')) {
            'featured' => get_featured_products(['take' => $limit]),
            'on-sale' => get_products_on_sale(['take' => $limit]),
            'trending' => get_trending_products(['take' => $limit]),
            'top-rated' => get_top_rated_products($limit),
            default => get_products(['take' => $limit]),
        };

        $data = view(Theme::getThemeNamespace('views.ecommerce.product-items'), compact('products'))->render();

        return $response->setData($data);
    }

    public function getProducts(Request $request, GetProductService $productService, BaseHttpResponse $response)
    {
        if (! EcommerceHelper::productFilterParamsValidated($request)) {
            return $response->setNextUrl(route('public.products'));
        }

        $products = $productService->getProduct($request);

        $total = $products->total();
        $layout = $request->input('layout');

        $message = $total > 1 ? __(':total Products found', compact('total')) : __(
            ':total Product found',
            compact('total')
        );

        $view = Theme::getThemeNamespace('views.ecommerce.includes.product-items');

        if (! view()->exists($view)) {
            $view = 'plugins/ecommerce::themes.includes.product-items';
        }

        $additional = [
            'breadcrumb' => view()->exists(Theme::getThemeNamespace('partials.breadcrumbs')) ? Theme::partial('breadcrumbs') : Theme::breadcrumb()
                ->render(),
        ];

        return $response
            ->setData(view($view, compact('products', 'layout'))->render())
            ->setAdditional($additional)
            ->setMessage($message);
    }
}
