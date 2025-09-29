<?php

namespace AuthLibrary;

class SupabaseAuth implements Auth
{
    private string $supabaseUrl;
    private string $supabaseKey;
    private string $apiUrl;

    public function __construct($supabaseUrl, $supabaseKey)
    {
        $this->supabaseUrl = rtrim($supabaseUrl, '/');
        $this->supabaseKey = $supabaseKey;
        $this->apiUrl = $this->supabaseUrl . '/auth/v1';
    }

    /**
     * Make HTTP request to Supabase API
     *
     * @param string $endpoint API endpoint
     * @param string $method HTTP method
     * @param array $data Request data
     * @param array $additionalHeaders Additional headers
     * @return array Response data
     * @throws \Exception On API errors
     */
    private function makeRequest($endpoint, $method = 'GET', $data = [], $additionalHeaders = [])
    {
        $url = $this->apiUrl . $endpoint;
        
        $headers = [
            'apikey: ' . $this->supabaseKey,
            'Content-Type: application/json',
            'Accept: application/json'
        ];
        
        // Add additional headers
        foreach ($additionalHeaders as $header) {
            $headers[] = $header;
        }

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_TIMEOUT => 30
        ]);

        if (!empty($data) && in_array($method, ['POST', 'PUT', 'PATCH'])) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new \Exception("cURL error: " . $error);
        }

        $decodedResponse = json_decode($response, true);
        
        if ($httpCode >= 400) {
            $message = $decodedResponse['message'] ?? $decodedResponse['error_description'] ?? 'Unknown error';
            throw new \Exception("API error ({$httpCode}): " . $message);
        }

        return $decodedResponse ?? [];
    }

    public function signUp(string $email, string $password, array $metadata = []): array
    {
        $data = [
            'email' => $email,
            'password' => $password
        ];

        if (!empty($metadata)) {
            $data['data'] = $metadata;
        }

        return $this->makeRequest('/signup', 'POST', $data);
    }

    public function signIn(string $email, string $password): array
    {
        $data = [
            'email' => $email,
            'password' => $password
        ];

        return $this->makeRequest('/token?grant_type=password', 'POST', $data);
    }

    public function signOut(string $accessToken): bool
    {
        try {
            $this->makeRequest('/logout', 'POST', [], [
                'Authorization: Bearer ' . $accessToken
            ]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getUser(string $accessToken): array
    {
        return $this->makeRequest('/user', 'GET', [], [
            'Authorization: Bearer ' . $accessToken
        ]);
    }

    public function refreshToken(string $refreshToken): array
    {
        $data = [
            'refresh_token' => $refreshToken
        ];

        return $this->makeRequest('/token?grant_type=refresh_token', 'POST', $data);
    }

    public function resetPassword(string $email, ?string $redirectTo = null): bool
    {
        try {
            $data = [
                'email' => $email
            ];
            
            // Add redirect URL if provided (required by some Supabase configurations)
            if ($redirectTo) {
                $data['redirect_to'] = $redirectTo;
            }

            $this->makeRequest('/recover', 'POST', $data);
            return true;
        } catch (\Exception $e) {
            // Log the error with more details for debugging
            error_log("Password reset failed for email: $email, Error: " . $e->getMessage());
            return false;
        }
    }

    public function verify(string $token, string $type = 'signup'): array
    {
        $data = [
            'token' => $token,
            'type' => $type
        ];

        return $this->makeRequest('/verify', 'POST', $data);
    }
}
