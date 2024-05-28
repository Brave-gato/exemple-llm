<?php

namespace App\Services\AI;

/**
 * AI Models.
 *
 * @see https://docs.endpoints.anyscale.com/category/guides
 * @see https://docs.endpoints.anyscale.com/category/supported-models
 * @see https://console.groq.com/docs/text-chat
 * @see https://console.groq.com/docs/models
 */
enum AIModels: string
{
    case NeuralHermes = 'mlabonne/NeuralHermes-2.5-Mistral-7B';
    case Mistral = 'mistralai/Mistral-7B-Instruct-v0.1';
    case Mixtral = 'mistralai/Mixtral-8x7B-Instruct-v0.1';
    case Mixtral8x22B = 'mistralai/Mixtral-8x22B-Instruct-v0.1';
    case Llama3_8B = 'meta-llama/Meta-Llama-3-8B-Instruct';
    case Llama3_70B = 'meta-llama/Meta-Llama-3-70B-Instruct';

    case GroqLlama3_8B = 'llama3-8b-8192';
    case GroqLlama3_70B = 'llama3-70b-8192';
    case GroqMixtral = 'mixtral-8x7b-32768';
    case GroqGemma = 'gemma-7b-it';

    public static function default(): self
    {
        return self::GroqLlama3_70B;
    }

    public static function toArray(): array
    {
        return [
            self::NeuralHermes->value => [
                'name' => 'Anyscale NeuralHermes 7B 16k',
                'value' => self::NeuralHermes,
                'maxTokens' => 16384,
                'provider' => 'Anyscale',
            ],
            self::Mistral->value => [
                'name' => 'Anyscale Mistral 7B 16k',
                'value' => self::Mistral,
                'maxTokens' => 16384,
                'provider' => 'Anyscale',
            ],
            self::Mixtral->value => [
                'name' => 'Anyscale Mixtral 8x7B 32k',
                'value' => self::Mixtral,
                'maxTokens' => 32768,
                'provider' => 'Anyscale',
            ],
            self::Mixtral8x22B->value => [
                'name' => 'Anyscale Mixtral 8x22B 64k',
                'value' => self::Mixtral8x22B,
                'maxTokens' => 65536,
                'provider' => 'Anyscale',
            ],
            self::Llama3_8B->value => [
                'name' => 'Anyscale Llama3 8B 8k',
                'value' => self::Llama3_8B,
                'maxTokens' => 8192,
                'provider' => 'Anyscale',
            ],
            self::Llama3_70B->value => [
                'name' => 'Anyscale Llama3 70B 8k',
                'value' => self::Llama3_70B,
                'maxTokens' => 8192,
                'provider' => 'Anyscale',
            ],
            self::GroqLlama3_8B->value => [
                'name' => 'Groq Llama3 8B 8k',
                'value' => self::GroqLlama3_8B,
                'maxTokens' => 8192,
                'provider' => 'Groq',
            ],
            self::GroqLlama3_70B->value => [
                'name' => 'Groq Llama3 70B 8k',
                'value' => self::GroqLlama3_70B,
                'maxTokens' => 8192,
                'provider' => 'Groq',
            ],
            self::GroqMixtral->value => [
                'name' => 'Groq Mixtral 8x7B 32k',
                'value' => self::GroqMixtral,
                'maxTokens' => 32768,
                'provider' => 'Groq',
            ],
            self::GroqGemma->value => [
                'name' => 'Groq Gemma 7B 8k',
                'value' => self::GroqGemma,
                'maxTokens' => 8192,
                'provider' => 'Groq',
            ],
        ];
    }
}
