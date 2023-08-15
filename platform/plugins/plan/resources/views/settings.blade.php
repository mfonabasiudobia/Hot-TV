<x-core-setting::section
    :title="trans('plugins/Plan::base.settings.title')"
    :description="trans('plugins/Plan::base.settings.description')"
>
    <x-core-setting::checkbox
        name="Plan_post_schema_enabled"
        :label="trans('plugins/Plan::base.settings.enable_Plan_post_schema')"
        :checked="setting('Plan_post_schema_enabled', true)"
        :helper-text="trans('plugins/Plan::base.settings.enable_Plan_post_schema_description')"
    />

    <x-core-setting::select
        name="Plan_post_schema_type"
        :label="trans('plugins/Plan::base.settings.schema_type')"
        :options="[
            'NewsArticle' => 'NewsArticle',
            'News' => 'News',
            'Article' => 'Article',
            'PlanPosting' => 'PlanPosting'
        ]"
        :value="setting('Plan_post_schema_type', 'NewsArticle')"
    />
</x-core-setting::section>
