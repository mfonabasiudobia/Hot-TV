<?php

namespace Botble\Stream\Providers;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Facades\Assets;
use Botble\Base\Facades\BaseHelper;
use Botble\Base\Facades\Html;
use Botble\Base\Supports\ServiceProvider;
use Botble\Stream\Services\PlanService;
use Botble\Dashboard\Supports\DashboardWidgetInstance;
use Botble\Language\Facades\Language;
use Botble\Media\Facades\RvMedia;
use Botble\Menu\Facades\Menu;
use Botble\Page\Models\Page;
use Botble\Page\Repositories\Interfaces\PageInterface;
use Botble\Shortcode\Compilers\Shortcode;
use Botble\Slug\Models\Slug;
use Botble\Theme\Facades\AdminBar;
use Botble\Theme\Facades\Theme;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class HookServiceProvider extends ServiceProvider
{
//     public function boot(): void
//     {
//         if (defined('MENU_ACTION_SIDEBAR_OPTIONS')) {
//             Menu::addMenuOptionModel(Category::class);
//             Menu::addMenuOptionModel(Tag::class);
//             add_action(MENU_ACTION_SIDEBAR_OPTIONS, [$this, 'registerMenuOptions'], 2);
//         }
//         add_filter(DASHBOARD_FILTER_ADMIN_LIST, [$this, 'registerDashboardWidgets'], 21, 2);
//         add_filter(BASE_FILTER_PUBLIC_SINGLE_DATA, [$this, 'handleSingleView'], 2);
//         if (defined('PAGE_MODULE_SCREEN_NAME')) {
//             add_filter(PAGE_FILTER_FRONT_PAGE_CONTENT, [$this, 'renderPlanPage'], 2, 2);
//             add_filter(PAGE_FILTER_PAGE_NAME_IN_ADMIN_LIST, [$this, 'addAdditionNameToPageName'], 147, 2);
//         }

//         $this->app['events']->listen(RouteMatched::class, function () {
//             if (function_exists('admin_bar')) {
//                 AdminBar::registerLink(
//                     trans('plugins/Stream::stream.post'),
//                     route('stream.create'),
//                     'add-new',
//                     'stream.create'
//                 );
//             }
//         });

//         if (function_exists('add_shortcode')) {
//             add_shortcode(
//                 'Stream-stream',
//                 trans('plugins/Stream::base.short_code_name'),
//                 trans('plugins/Stream::base.short_code_description'),
//                 [$this, 'renderPlanPosts']
//             );
//             shortcode()->setAdminConfig('Stream-stream', function ($attributes, $content) {
//                 return view('plugins/Stream::partials.stream-short-code-admin-config', compact('attributes', 'content'))
//                     ->render();
//             });
//         }

//         if (function_exists('theme_option')) {
//             add_action(RENDERING_THEME_OPTIONS_PAGE, [$this, 'addThemeOptions'], 35);
//         }

//         if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
//             add_action(BASE_ACTION_META_BOXES, [$this, 'addLanguageChooser'], 55, 2);
//         }

//         if (defined('THEME_FRONT_HEADER') && setting('Plan_post_schema_enabled', 1)) {
//             add_action(BASE_ACTION_PUBLIC_RENDER_SINGLE, function ($screen, $post) {
//                 add_filter(THEME_FRONT_HEADER, function ($html) use ($post) {
//                     if (get_class($post) != Post::class) {
//                         return $html;
//                     }

//                     $schemaType = setting('Plan_post_schema_type', 'NewsArticle');

//                     if (! in_array($schemaType, ['NewsArticle', 'News', 'Article', 'PlanPosting'])) {
//                         $schemaType = 'NewsArticle';
//                     }

//                     $schema = [
//                         '@context' => 'https://schema.org',
//                         '@type' => $schemaType,
//                         'mainEntityOfPage' => [
//                             '@type' => 'WebPage',
//                             '@id' => $post->url,
//                         ],
//                         'headline' => BaseHelper::clean($post->name),
//                         'description' => BaseHelper::clean($post->description),
//                         'image' => [
//                             '@type' => 'ImageObject',
//                             'url' => RvMedia::getImageUrl($post->image, null, false, RvMedia::getDefaultImage()),
//                         ],
//                         'author' => [
//                             '@type' => 'Person',
//                             'url' => route('public.index'),
//                             'name' => class_exists($post->author_type) ? $post->author->name : '',
//                         ],
//                         'publisher' => [
//                             '@type' => 'Organization',
//                             'name' => theme_option('site_title'),
//                             'logo' => [
//                                 '@type' => 'ImageObject',
//                                 'url' => RvMedia::getImageUrl(theme_option('logo')),
//                             ],
//                         ],
//                         'datePublished' => $post->created_at->toDateString(),
//                         'dateModified' => $post->updated_at->toDateString(),
//                     ];

//                     return $html . Html::tag('script', json_encode($schema), ['type' => 'application/ld+json'])
//                             ->toHtml();
//                 }, 35);
//             }, 35, 2);
//         }

//         add_filter(BASE_FILTER_AFTER_SETTING_CONTENT, [$this, 'addSettings'], 193);
//         add_filter('cms_settings_validation_rules', [$this, 'addSettingRules'], 193);
//     }

//     public function addThemeOptions(): void
//     {
//         $pages = $this->app->make(PageInterface::class)->pluck('name', 'id', ['status' => BaseStatusEnum::PUBLISHED]);

//         theme_option()
//             ->setSection([
//                 'title' => 'Stream',
//                 'desc' => 'Theme options for Stream',
//                 'id' => 'opt-text-subsection-Stream',
//                 'subsection' => true,
//                 'icon' => 'fa fa-edit',
//                 'fields' => [
//                     [
//                         'id' => 'Plan_page_id',
//                         'type' => 'customSelect',
//                         'label' => trans('plugins/Stream::base.Plan_page_id'),
//                         'attributes' => [
//                             'name' => 'Plan_page_id',
//                             'list' => ['' => trans('plugins/Stream::base.select')] + $pages,
//                             'value' => '',
//                             'options' => [
//                                 'class' => 'form-control',
//                             ],
//                         ],
//                     ],
//                     [
//                         'id' => 'number_of_plan_in_a_category',
//                         'type' => 'number',
//                         'label' => trans('plugins/Stream::base.number_plan_per_page_in_category'),
//                         'attributes' => [
//                             'name' => 'number_of_plan_in_a_category',
//                             'value' => 12,
//                             'options' => [
//                                 'class' => 'form-control',
//                             ],
//                         ],
//                     ],
//                     [
//                         'id' => 'number_of_plan_in_a_tag',
//                         'type' => 'number',
//                         'label' => trans('plugins/Stream::base.number_plan_per_page_in_tag'),
//                         'attributes' => [
//                             'name' => 'number_of_plan_in_a_tag',
//                             'value' => 12,
//                             'options' => [
//                                 'class' => 'form-control',
//                             ],
//                         ],
//                     ],
//                 ],
//             ]);
//     }

//     /**
//      * Register sidebar options in menu
//      */
//     // public function registerMenuOptions(): void
//     // {
//     //     if (Auth::user()->hasPermission('categories.index')) {
//     //         Menu::registerMenuOptions(Category::class, trans('plugins/Stream::categories.menu'));
//     //     }

//     //     if (Auth::user()->hasPermission('tags.index')) {
//     //         Menu::registerMenuOptions(Tag::class, trans('plugins/Stream::tags.menu'));
//     //     }
//     // }

//     public function registerDashboardWidgets(array $widgets, Collection $widgetSettings): array
//     {
//         if (! Auth::user()->hasPermission('stream.index')) {
//             return $widgets;
//         }

//         Assets::addScriptsDirectly(['/vendor/core/plugins/Stream/js/Stream.js']);

//         return (new DashboardWidgetInstance())
//             ->setPermission('stream.index')
//             ->setKey('widget_plan_recent')
//             ->setTitle(trans('plugins/Stream::stream.widget_plan_recent'))
//             ->setIcon('fas fa-edit')
//             ->setColor('#f3c200')
//             ->setRoute(route('stream.widget.recent-stream'))
//             ->setBodyClass('scroll-table')
//             ->setColumn('col-md-6 col-sm-6')
//             ->init($widgets, $widgetSettings);
//     }

//     public function handleSingleView(Slug|array $slug): Slug|array
//     {
//         return (new PlanService())->handleFrontRoutes($slug);
//     }

//     public function renderPlanPosts(Shortcode $shortcode): array|string
//     {
//         $stream = get_all_plan(true, (int)$shortcode->paginate);

//         $view = 'plugins/Stream::themes.templates.stream';
//         $themeView = Theme::getThemeNamespace() . '::views.templates.stream';

//         if (view()->exists($themeView)) {
//             $view = $themeView;
//         }

//         return view($view, compact('stream'))->render();
//     }

//     public function renderPlanPage(string|null $content, Page $page): string|null
//     {
//         if ($page->id == theme_option('Plan_page_id', setting('Plan_page_id'))) {
//             $view = 'plugins/Stream::themes.loop';

//             if (view()->exists(Theme::getThemeNamespace() . '::views.loop')) {
//                 $view = Theme::getThemeNamespace() . '::views.loop';
//             }

//             return view($view, [
//                 'stream' => get_all_plan(true, (int)theme_option('number_of_plan_in_a_category', 12)),
//             ])->render();
//         }

//         return $content;
//     }

//     public function addAdditionNameToPageName(string|null $name, Page $page): string|null
//     {
//         if ($page->getKey() == theme_option('Plan_page_id', setting('Plan_page_id'))) {
//             $subTitle = Html::tag('span', trans('plugins/Stream::base.Plan_page'), ['class' => 'additional-page-name'])
//                 ->toHtml();

//             if (Str::contains($name, ' —')) {
//                 return $name . ', ' . $subTitle;
//             }

//             return $name . ' —' . $subTitle;
//         }

//         return $name;
//     }

//     public function addLanguageChooser(string $priority, Model $model): void
//     {
//         if ($priority == 'head' && $model instanceof Category) {
//             $route = 'categories.index';

//             $languages = Language::getActiveLanguage(['lang_id', 'lang_name', 'lang_code', 'lang_flag']);

//             if ($languages->count() < 2) {
//                 return;
//             }

//             echo view('plugins/language::partials.admin-list-language-chooser', compact('route', 'languages'))->render();
//         }
//     }

//     public function addSettings(string|null $data = null): string
//     {
//         return $data . view('plugins/Stream::settings')->render();
//     }

//     public function addSettingRules(array $rules): array
//     {
//         $rules['Plan_post_schema_enabled'] = 'nullable|in:0,1';

//         $rules['Plan_post_schema_type'] = [
//             'nullable',
//             'string',
//             Rule::in(['NewsArticle', 'News', 'Article', 'PlanPosting']),
//         ];

//         return $rules;
//     }
}
