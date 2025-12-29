<?php

namespace App\Controllers\Api;

use CodeIgniter\Controller;

class GeminiTest extends Controller
{
    public function index()
    {
        $apiKey = env('GEMINI_API_KEY');

        if (!$apiKey) {
            return $this->response->setJSON([
                'status' => false,
                'answer' => 'API key missing'
            ]);
        }

        // ✅ FORM POST DATA (IMPORTANT)
        $question = $this->request->getPost('question');

        if (!$question) {
            return $this->response->setJSON([
                'status' => false,
                'answer' => 'Sawal khali hai'
            ]);
        }

        $url = "https://generativelanguage.googleapis.com/v1/models/gemini-2.5-flash:generateContent?key={$apiKey}";

        $payload = [
            "contents" => [[
                "parts" => [[
                    "text" => $question
                ]]
            ]]
        ];

        $client = \Config\Services::curlrequest();

        $res = $client->POST($url, [
            'headers' => ['Content-Type' => 'application/json'],
            'body'    => json_encode($payload),
            'http_errors' => false
        ]);

        $result = json_decode($res->getBody(), true);

        $answer = $result['candidates'][0]['content']['parts'][0]['text']
            ?? 'AI ne jawab nahi diya';

        return $this->response->setJSON([
            'status' => true,
            'answer' => $answer
        ]);
    }
}
