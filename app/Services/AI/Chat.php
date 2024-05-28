<?php

namespace App\Services\AI;

use GuzzleHttp\Client;
use OpenAI\Client as OpenAIClient;
use OpenAI\Responses\StreamResponse;

class Chat
{
    public static function create(array $messages, AIModels $model): string
    {
        $client = self::client($model);

        $response = $client->chat()->create([
            'model' => $model->value,
            'temperature' => 0.8,
            'messages' => $messages,
        ]);

        return $response['choices'][0]['message']['content'];
    }

    public static function stream(array $messages, AIModels $model): StreamResponse
    {
        $client = self::client($model);

        return $client->chat()->createStreamed([
            'model' => $model->value,
            'temperature' => 0.8,
            'stream' => true,
            'messages' => $messages,
        ]);
    }

    private static function client(AIModels $model): OpenAIClient
    {
        if ('Anyscale' === AIModels::toArray()[$model->value]['provider']) {
            $yourApiKey = config('openai.anyscale_api_key');
            $yourOrganization = config('openai.anyscale_organization');
            $apiEndpoint = config('openai.anyscale_api_endpoint');
        } if ('Groq' === AIModels::toArray()[$model->value]['provider']) {
            $yourApiKey = config('openai.groq_api_key');
            $yourOrganization = config('openai.groq_organization');
            $apiEndpoint = config('openai.groq_api_endpoint');
        } else {
            throw new \InvalidArgumentException('Unsupported provider');
        }

        $client = \OpenAI::factory()
            ->withApiKey($yourApiKey)
            ->withOrganization($yourOrganization)
            ->withBaseUri($apiEndpoint)
            ->withHttpClient($client = new Client([]))
            ->make()
        ;

        return $client;
    }
}
