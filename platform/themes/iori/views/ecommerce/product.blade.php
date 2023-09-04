<div>
    {!! Theme::partial('breadcrumb') !!}
    <section class="section mt-50">
        <div class="container product-details">
            <div class="row">
                <div class="col-lg-6 text-center mb-30">
                    @if ($productImages)
                        <div class="detail-gallery">
                            <div class="product-image-slider">
                                @foreach($productImages as $image)
                                    <figure class="border-radius-10">
                                        <img src="{{ RvMedia::getImageUrl($image) }}" alt="{{ __('Product image') }}">
                                    </figure>
                                @endforeach
                            </div>
                        </div>

                        <div class="slider-nav-thumbnails">
                            @foreach($productImages as $image)
                                <div><div class="item-thumb"><img src="{{ RvMedia::getImageUrl($image) }}" alt="{{ __('Product image') }}"></div></div>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="col-lg-6 mb-30">
                    <h3 class="color-gray-800 mb-20 wow animate__animated animate__fadeIn" data-wow-delay=".0s">
                        {{ $product->name }}
                    </h3>

                    @if (EcommerceHelper::isReviewEnabled())
                        <a href="#review-tab" class="anchor-link">
                            <div class="d-flex mb-3">
                                <div class="product-rate d-inline-block me-2">
                                    <div class="product-rating" style="width: {{ $product->reviews_avg * 20 }}%;"></div>
                                </div>
                                <span class="text-semibold">
                                    <span>({{ number_format($product->reviews_count) }})</span>
                                </span>
                            </div>
                        </a>
                    @endif

                    <div class="d-flex align-items-center mb-30 box-price-banner">
                        @if ($product->front_sale_price === $product->price)
                            <h3 class="color-success mr-30">{{ format_price($product->front_sale_price_with_taxes) }}</h3>
                        @else
                            <h3 class="color-success mr-30">{{ format_price($product->front_sale_price_with_taxes) }}</h3>
                            <h4 class="color-grey-400 mr-30">{{ format_price($product->price_with_taxes) }}</h4>
                        @endif

                        @if ($stockStatusLabel = $product->stockStatusLabel)
                            <p class="font-md color-grey-400">({{ $stockStatusLabel }})</p>
                        @endif
                    </div>
                    <div class="mb-50 product-description">
                        <div class="product-description-text">
                            {!! BaseHelper::clean(Str::limit($product->description, 320)) !!}
                        </div>

                        @if (strlen($product->description) > 340)
                            <div style="display: none" class="product-description-full">
                                {!! BaseHelper::clean($product->description) !!}
                            </div>
                            <a href="#" class="btn-view" data-view="full">{{ __('View more') }}</a>
                        @endif
                    </div>
                    <div class="mb-50">
                        @if ($product->variations()->count() > 0)
                            <div class="pr_switch_wrap">
                                {!! render_product_swatches($product, [
                                    'selected' => $selectedAttrs,
                                    'view'     => Theme::getThemeNamespace('views.ecommerce.attributes.swatches-renderer')
                                ]) !!}
                            </div>
                            <div class="number-items-available" style="display: none; margin-bottom: 10px;"></div>
                        @endif
                    </div>
                    <div class="box-quantity">
                        <div class="form-quantity mr-10">
                            <input class="input-quantity" min="1" type="text" value="1">
                            <span class="button-quantity button-up" data-type="increase"></span>
                            <span class="button-quantity button-down" data-type="decrease"></span>
                        </div>
                        <form class="d-flex flex-wrap gap-2 cart-form" action="{{ route('public.cart.add-to-cart') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" class="hidden-product-id" value="{{ $product->id }}"/>
                            <input type="hidden" name="qty" value="1">
                            <button type="submit" @class(['btn btn-brand-1 btn-cart', 'disable' => $product->isOutOfStock()])>
                                <i class="fi fi-rr-shopping-cart me-2"></i>
                                {{ __('Add To Cart') }}
                            </button>
                            <button type="submit" name="checkout" value="1" @class(['btn btn-brand-1 btn-cart', 'disable' => $product->isOutOfStock()])>{{ __('Buy Now') }}</button>
                            @if (EcommerceHelper::isWishlistEnabled())
                                <a class="btn btn-brand-1 add-to-wishlist" href="{{ route('public.wishlist.add', $product->id) }}">
                                    <svg class="w-6 h-6 icon-16" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </a>
                            @endif
                        </form>
                    </div>

                    <div class="box-categories-link mt-30">
                        <div class="item-cat meta-sku @if (!$product->sku) d-none @endif">
                            <span class="text-body color-gray-900 d-inline-block">{{ __('SKU') }}:&nbsp;</span>
                            <span class="text-body color-gray-500 meta-value d-inline-block">{{ $product->sku }}</span>
                        </div>
                        @if ($product->categories->count())
                            <div class="item-cat d-block">
                                <span class="text-body color-gray-900 d-inline-block">{{ __('Categories') }}:&nbsp;</span>
                                @foreach($product->categories as $category)
                                    <a href="{{ $category->url }}" class="text-body meta-value d-inline-block">{{ $category->name }}</a>@if (!$loop->last),&nbsp;@endif
                                @endforeach
                            </div>
                        @endif
                        @if ($product->tags->count())
                            <div class="item-cat d-block">
                                <span class="text-body color-gray-900 d-inline-block">{{ __('Tags') }}:&nbsp;</span>
                                @foreach($product->tags as $tag)
                                    <a href="{{ $tag->url }}" class="text-body meta-value d-inline-block">{{ $tag->name }}</a>@if (!$loop->last), @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="border-bottom bd-grey-80 mt-50"></div>
    </section>

    <div class="text-center">
        <ul class="tabs-plan product-tabs" role="tablist" id="product-tabs">
            <li class="wow animate__animated animate__fadeIn me-2" data-wow-delay=".0s">
                <a class="active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description-tab-pane" type="button" role="tab" aria-controls="description-tab-pane" aria-selected="true">
                    {{ __('Description') }}
                </a>
            </li>
            @if (EcommerceHelper::isReviewEnabled())
                <li class="wow animate__animated animate__fadeIn" data-wow-delay=".1s">
                    <a id="review-tab" data-bs-toggle="tab" data-bs-target="#review-tab-pane" type="button" role="tab" aria-controls="review-tab-pane" aria-selected="false">
                        {{ __('Reviews') }}
                        (<span>{{ $product->reviews_count }}</span>)
                    </a>
                </li>
            @endif
        </ul>
    </div>

    <div class="tab-content" id="product-tabs-content">
        <div class="tab-pane fade show active" id="description-tab-pane" role="tabpanel" aria-labelledby="description-tab" tabindex="0">
            <div class="ck-content font-md">
                {!! BaseHelper::clean($product->content) !!}
            </div>
        </div>
        @if (EcommerceHelper::isReviewEnabled())
            <div class="tab-pane fade" id="review-tab-pane" role="tabpanel" aria-labelledby="review-tab" tabindex="0">
                <div class="comments-area">
                    @if($product->review_images)
                        <div class="mb-50">
                        <h5 class="mb-20">{{ __('Images from customer (:count)', ['count' => count($product->review_images)]) }}</h5>
                        <div class="row g-2 product-review-images">
                            @foreach ($product->review_images as $img)
                                <a href="{{ RvMedia::getImageUrl($img) }}" @class(['col-lg-1 col-sm-2 col-3', 'd-none' => $loop->iteration > 12])>
                                    <div class="border position-relative rounded">
                                        <img src="{{ RvMedia::getImageUrl($img, 'thumb') }}" alt="{{ $product->name }}" class="img-fluid rounded h-100">
                                        @if ($loop->iteration === 12 && (count($product->review_images) - $loop->iteration > 0))
                                            <div class="d-flex justify-content-center align-items-center position-absolute top-0 bottom-0 left-0 right-0 bg-black w-100" style="--bs-bg-opacity: .5;">
                                                <span class="text-white fs-6">+{{ count($product->review_images) - $loop->iteration }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="mb-20">{{ __('Customer questions & answers') }}</h5>

                            <div class="position-relative product-reviews-container">
                                <div class="comment-list" data-url="{{ route('public.ajax.product-reviews', $product->id) }}"></div>
                                <div class="loading-spinner"></div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-20">
                                <h5>{{ __('Add your review') }}</h5>
                                <p class="small text-muted mt-2">
                                    {{ __('Your email address will not be published. Required fields are marked.') }}
                                </p>
                            </div>

                            <form action="{{ route('public.reviews.create') }}" method="post" class="form-review-product">
                                @csrf

                                <input type="hidden" name="product_id" value="{{ $product->getKey() }}">

                                @guest('customer')
                                    <p class="text-danger mb-3">{!! BaseHelper::clean(__('Please <a href=":link">login</a> to write review!', ['link' => route('customer.login')])) !!}</p>
                                @endguest

                                <div class="d-flex align-items-center mb-3">
                                    <label for="rating" class="form-label">{{ __('Your rating:') }}</label>
                                    <div class="form-rating-stars ms-2 mb-1">
                                        @foreach(array_reverse(range(1, 5)) as $i)
                                            <input class="btn-check" type="radio" id="rating-star-{{ $i }}" name="star" value="{{ $i }}" @checked($i === 5)>
                                            <label for="rating-star-{{ $i }}" title="{{ $i }} stars">
                                                <i class="fi fi-rr-star"></i>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="comment" class="form-label">{{ __('Review:') }}</label>
                                    <textarea name="comment" id="comment" class="form-control" rows="3" required placeholder="{{ __('Write your review') }}" @disabled(! auth('customer')->check()) style="height: auto"></textarea>
                                </div>

                                <div class="mb-3">
                                    <script type="text/x-custom-template" id="review-image-template">
                                        <span class="image-viewer__item" data-id="__id__">
                                            <img src="{{ RvMedia::getDefaultImage() }}" alt="{{ __('Preview') }}" class="img-responsive d-block">
                                            <span class="image-viewer__icon-remove">
                                                <i class="fi fi-rr-cross-circle"></i>
                                            </span>
                                        </span>
                                    </script>
                                    <div class="image-upload__viewer d-flex">
                                        <div class="image-viewer__list position-relative">
                                            <div class="image-upload__uploader-container">
                                                <div class="d-table">
                                                    <div class="image-upload__uploader">
                                                        <i class="fi fi-rr-file-add"></i>
                                                        <div class="image-upload__text">{{ __('Upload photos') }}</div>
                                                        <input
                                                            type="file"
                                                            name="images[]"
                                                            data-max-files="{{ EcommerceHelper::reviewMaxFileNumber() }}"
                                                            class="image-upload__file-input"
                                                            accept="image/png,image/jpeg,image/jpg"
                                                            multiple="multiple"
                                                            data-max-size="{{ EcommerceHelper::reviewMaxFileSize(true) }}"
                                                            data-max-size-message="{{ trans('validation.max.file', ['attribute' => '__attribute__', 'max' => '__max__']) }}"
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="alert alert-info p-2 small muted">
                                        {{ __('You can upload up to :total photos, each photo maximum size is :max kilobytes.', [
                                            'total' => EcommerceHelper::reviewMaxFileNumber(),
                                            'max' => EcommerceHelper::reviewMaxFileSize(true),
                                        ]) }}
                                        </p>
                                    </div>
                                </div>

                                <button class="d-flex btn btn-brand-1" type="submit" @disabled(! auth('customer')->check())>
                                    <i class="fi fi-rr-paper-plane me-1" style="color: unset"></i>
                                    <span>{{ __('Submit Review') }}</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>


@if (($products = get_related_products($product)) && $products->count())
    <section class="section-box mt-40">
        <div class="container">
            <h2 class="text-heading-4 color-gray-900">{{ __('You may also like') }}</h2>
            <p class="text-body color-gray-600 mt-10">{{ __('Take it to your cart') }}</p>
        </div>
        <div class="container mt-50">
            <div class="row">
                @foreach($products as $product)
                    <div class="col-lg-3 col-md-4">
                        {!! Theme::partial('ecommerce.product.item-grid', compact('product')) !!}
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

