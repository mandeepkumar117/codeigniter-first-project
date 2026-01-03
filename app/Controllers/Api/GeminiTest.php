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

        $question = $this->request->getVar('question');

        if (!$question) {
            return $this->response->setJSON([
                'status' => false,
                'answer' => 'Sawal khali hai'
            ]);
        }

        $url = "https://generativelanguage.googleapis.com/v1/models/gemini-1.5-pro:generateContent?key={$apiKey}";


        $payload = [
        "contents" => [
            [
                "role" => "user",
                "parts" => [
                    ["text" => $question]
                ]
            ]
        ]
];


        $client = \Config\Services::curlrequest();

        $res = $client->post($url, [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => json_encode($payload),
            'verify' => false,
            'http_errors' => false
        ]);
        
        $result = json_decode($res->getBody(), true);
        
        return $this->response->setJSON([
            'http_code' => $res->getStatusCode(),
            'full_response' => $result
        ]);

    }
}
