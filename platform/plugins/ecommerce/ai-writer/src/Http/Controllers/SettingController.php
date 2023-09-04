<?php

namespace ArchiElite\AiWriter\Http\Controllers;

use ArchiElite\AiWriter\Facades\AiWriter;
use ArchiElite\AiWriter\Http\Requests\SettingRequest;
use Botble\Base\Facades\Assets;
use Botble\Base\Facades\PageTitle;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\JsValidation\Facades\JsValidator;
use Botble\Setting\Facades\Setting;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

class SettingController extends BaseController
{
    public function index(): View
    {
        PageTitle::setTitle(trans('plugins/ai-writer::ai-writer.setting.page_title'));

        Assets::addScripts(['jquery-validation', 'form-validation'])
            ->addStylesDirectly('vendor/core/core/setting/css/setting.css')
            ->addScriptsDirectly([
                'vendor/core/core/setting/js/setting.js',
                'vendor/core/plugins/ai-writer/js/settings.js',
            ]);

        try {
            $models = Cache::remember('ai-writer-models', 3600, function () {
                return AiWriter::getModels();
            });
        } catch (Exception) {
            $models = [];
        }

        $jsValidation = JsValidator::formRequest(SettingRequest::class);

        return view('plugins/ai-writer::settings', [
            'models' => array_combine($models, $models),
            'jsValidation' => $jsValidation,
        ]);
    }

    public function update(SettingRequest $request, BaseHttpResponse $response): BaseHttpResponse
    {
        foreach ($request->validated() as $key => $value) {
            if ($key == 'ai_writer_spin_template' || $key == 'ai_writer_prompt_template') {
                $value = array_values($value);
            }

            if (is_array($value)) {
                $value = json_encode(array_filter($value));
            }

            Setting::set($key, (string) $value);
        }

        Setting::save();

        Cache::forget('ai-writer-models');

        return $response
            ->setPreviousUrl(route('settings.options'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }
}
