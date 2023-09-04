<?php

namespace ArchiElite\AiWriter\Http\Controllers;

use ArchiElite\AiWriter\Facades\AiWriter;
use ArchiElite\AiWriter\Http\Requests\GenerateRequest;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Exception;

class AiWriterController extends BaseController
{
    public function generate(GenerateRequest $request, BaseHttpResponse $response): BaseHttpResponse
    {
        $prompt = $request->input('prompt');

        $prompt = sprintf(
            "%s\n%s . Answer in %s language",
            trans('plugins/ai-writer::ai-writer.form.request_output_format'),
            $prompt,
            $request->input('language') ?: 'English'
        );

        try {
            $result = AiWriter::generateContent($prompt);

            return $response
                ->setData(['content' => $result]);
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }
}
