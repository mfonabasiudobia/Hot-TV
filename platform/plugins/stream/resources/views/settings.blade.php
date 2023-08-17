<x-core-setting::section
    :title="trans('plugins/Stream::base.settings.title')"
    :description="trans('plugins/Stream::base.settings.description')"
>
    <x-core-setting::checkbox
        name="Plan_post_schema_enabled"
        :label="trans('plugins/Stream::base.settings.enable_Plan_post_schema')"
        :checked="setting('Plan_post_schema_enabled', true)"
        :helper-text="trans('plugins/Stream::base.settings.enable_Plan_post_schema_description')"
    />

    <x-core-setting::select
        name="Plan_post_schema_type"
        :label="trans('plugins/Stream::base.settings.schema_type')"
        :options="[
            'NewsArticle' => 'NewsArticle',
            'News' => 'News',
            'Article' => 'Article',
            'PlanPosting' => 'PlanPosting'
        ]"
        :value="setting('Plan_post_schema_type', 'NewsArticle')"
    />
</x-core-setting::section>
