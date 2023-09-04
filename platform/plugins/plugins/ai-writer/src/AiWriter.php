<?php

namespace ArchiElite\AiWriter;

use ArchiElite\AiWriter\Contracts\AiWriter as AiWriterContract;
use ArchiElite\AiWriter\Exceptions\ApiKeyIsMissingException;
use ArchiElite\AiWriter\Handlers\ChatResultHandler;
use ArchiElite\AiWriter\OpenAI\OpenAi;

class AiWriter implements AiWriterContract
{
    protected OpenAi $openAi;

    public function __construct(protected string|null $token, protected string $model)
    {
        if (empty($this->token)) {
            throw new ApiKeyIsMissingException('OpenAI API key is missing.');
        }

        $this->openAi = new OpenAi($this->token);
    }

    public function withProxy(): self
    {
        if (setting('ai_writer_proxy_enable')) {
            $this->openAi->setProxy($this->buildProxy());
        }

        return $this;
    }

    public function getModels(): array
    {
        $data = json_decode($this->openAi->listModels(), true);

        if (isset($data['error'])) {
            return [];
        }

        return collect($data['data'])->filter(function ($model) {
            return $model['object'] === 'model';
        })->pluck('id')->toArray();
    }

    public function generateContent(string $prompt): string
    {
        set_time_limit(0);

        $chatResult = $this->openAi->chat($this->buildChatParams($prompt));
        $chatHandler = new ChatResultHandler($chatResult);

        return $chatHandler->getResultContent();
    }

    protected function buildProxy(): string
    {
        $protocol = (string) setting('ai_writer_proxy_protocol');
        $ip = (string) setting('ai_writer_proxy_ip');
        $port = (string) setting('ai_writer_proxy_port');
        $username = (string) setting('ai_writer_proxy_username');
        $password = (string) setting('ai_writer_proxy_password');

        $proxy = (! empty($protocol)) ? "$protocol://" : 'http://';
        $proxy .= (! empty($username) && ! empty($password)) ? "$username:$password@" : '';
        $proxy .= (! empty($ip)) ? "$ip" : '';
        $proxy .= (! empty($port)) ? ":$port" : '';

        return $proxy;
    }

    protected function buildChatParams(string $prompt): array
    {
        return [
            'model' => $this->model,
            'messages' => [
                [
                    'role' => 'system',
                    'content' => $prompt,
                ],
            ],
            'temperature' => (float) setting('ai_writer_openai_temperature', 1.0),
            'max_tokens' => (int) setting('ai_writer_openai_max_tokens', 2000),
            'frequency_penalty' => (float) setting('ai_writer_openai_frequency_penalty', 0),
            'presence_penalty' => (float) setting('ai_writer_openai_presence_penalty', 0),
        ];
    }
}
