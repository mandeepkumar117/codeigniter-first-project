<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $authHeader = $request->getHeaderLine('Authorization');        
        if (! $authHeader) {
            return response()
                ->setStatusCode(401)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Token missing'
                ]);
        }

        // 2️⃣ Bearer token format check
        if (! preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            return response()
                ->setStatusCode(401)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Invalid token format'
                ]);
        }

        $token = $matches[1];

        try {
            $key = env('JWT_SECRET');

            // 3️⃣ Decode token
            $decoded = JWT::decode($token, new Key($key, 'HS256'));

            // Optional: store user info globally
            service('request')->user = $decoded;

        } catch (\Throwable $e) {
            return response()
                ->setStatusCode(401)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Invalid or expired token'
                ]);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // nothing
    }
}
