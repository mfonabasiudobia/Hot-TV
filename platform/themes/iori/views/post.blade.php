{!! Theme::partial('breadcrumb') !!}

<div class="section mt-40">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-7">
                <div class="content-single">
                    <h2 class="color-brand-1 mb-20">{{ $post->name }}</h2>
                    <div>
                        @foreach ($post->categories as $category)
                            <a class="btn btn-border mr-10 mb-10 btn-tag"
                               href="{{ $category->url }}">{{ $category->name }}</a>
                        @endforeach
                    </div>
                    <div class="box-author mb-20">
                        <div class="author-info">
                            <span
                                class="font-xs color-grey-500 department">{{ $post->created_at->translatedFormat('M d, Y') }}</span>
                            <span
                                class="font-xs color-grey-500 icon-read">{{ __(':number mins read', ['number' => number_format(strlen(strip_tags($post->content)) / 300)]) }}</span>
                        </div>
                    </div>
                    <p class="color-grey-900 font-lg-bold mb-25">{{ $post->description }}</p>
                    <div class="ck-content font-md color-grey-500">{!! BaseHelper::clean($post->content) !!}</div>
                    <div class="border-bottom bd-grey-80"></div>
                    <div class="row">
                        <div class="col-lg-8">
                            @foreach ($post->tags as $tag)
                                <a class="btn btn-border mr-10 mb-10 btn-tag"
                                   href="{{ $tag->url }}">#{{ $tag->name }}</a>
                            @endforeach
                        </div>
                        <div class="col-lg-4">
                            <div class="d-flex align-item-center float-end">
                                <strong class="font-xs-bold color-brand-1 mr-20">{{ __('Share') }}</strong>
                                <div class="list-socials mt-0 d-inline-block">
                                    <a class="icon-socials icon-facebook"
                                       href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($post->url) }}"></a>
                                    <a class="icon-socials icon-twitter"
                                       href="https://twitter.com/intent/tweet?url={{ urlencode($post->url) }}&text={{ strip_tags($post->description) }}"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-5">
                <div class="sidebar-author">
                    <div class="mt-25">
                        {!! dynamic_sidebar('blog_sidebar') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
