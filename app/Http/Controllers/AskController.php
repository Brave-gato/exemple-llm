<?php

namespace App\Http\Controllers;

use App\Services\AI\AIModels;
use App\Services\AI\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AskController extends Controller
{
    public function index()
    {
        return view('ask.index', [
            'default_model' => AIModels::default()->value,
            'models' => AIModels::toArray(),
            'answer' => '',
        ]);
    }

    public function ask(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'model' => 'required|string',
        ]);

        // On va créer une conversation en respectant le format attendu par l'API.
        $messages = $this->getMessages($validated['question']);

        // On fait l'appel à l'API pour obtenir une réponse.
        $answer = Chat::create($messages, AIModels::tryFrom($validated['model']));

        return view('ask.index', [
            'default_model' => $validated['model'],
            'models' => AIModels::toArray(),
            'answer' => Str::markdown($answer), // On transforme la réponse markdown en HTML.
        ]);
    }

    public function async()
    {
        return view('ask.async', [
            'default_model' => AIModels::default()->value,
            'models' => AIModels::toArray(),
        ]);
    }

    public function askAsync(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'model' => 'required|string',
        ]);

        $messages = $this->getMessages($validated['question']);

        $response = Chat::create($messages, AIModels::tryFrom($validated['model']));

        // On retourne la réponse en JSON pour pouvoir l'afficher dans la page de manière asynchrone.
        return response()->json([
            'answer' => Str::markdown($response),
        ]);
    }

    private function getMessages(string $question): array
    {
        $today = now()->format('Y-m-d H:i:s');

        // On retourne un tableau de messages, le premier étant le système prompt, expliquant à l'IA ce qu'on attend d'elle.
        // Le second message est la question posée par l'utilisateur.
        return [
            [
                'role' => 'system',
                'content' => <<<EOT
                    # Répondre à une question
                    Tu es un chatbot qui répond à des questions. Tu peux répondre à des questions sur n'importe quel sujet.
                    ## Informations
                    - **Date:** {$today}
                    ## Format de la réponse
                    - Réponds de façon claire et précise.
                    - Utilise le format Markdown pour mettre en forme ta réponse.
                    - Utilise des titres pour structurer ta réponse.
                    - Utilise des listes pour énumérer des éléments. Mets en gras les mots importants.
                    - Utilise des tableaux pour présenter des données.
                    EOT,
            ],
            [
                'role' => 'user',
                'content' => $question,
            ],
        ];
    }
}
