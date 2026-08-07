<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FcmController extends Controller
{
    public function sendNotification()
    {
        // Path to your Firebase service account JSON
        $serviceAccountFile = storage_path('app/firebase-key.json');

        if (!file_exists($serviceAccountFile)) {
            return response()->json(['error' => 'firebase-key.json missing'], 500);
        }

        $key = json_decode(file_get_contents($serviceAccountFile), true);

        if (!$key || !isset($key['client_email'], $key['private_key'], $key['project_id'])) {
            return response()->json(['error' => 'Invalid Firebase service account JSON'], 500);
        }

        // Create JWT
        $header = ['alg' => 'RS256', 'typ' => 'JWT'];
        $now = time();
        $claims = [
            "iss" => $key["client_email"],
            "sub" => $key["client_email"],
            "aud" => "https://oauth2.googleapis.com/token",
            "iat" => $now,
            "exp" => $now + 3600, // 1 hour expiration
            "scope" => "https://www.googleapis.com/auth/firebase.messaging"
        ];

        $base64UrlHeader = rtrim(strtr(base64_encode(json_encode($header)), '+/', '-_'), '=');
        $base64UrlClaims = rtrim(strtr(base64_encode(json_encode($claims)), '+/', '-_'), '=');
        $signatureInput = $base64UrlHeader . "." . $base64UrlClaims;

        // Sign JWT with private key
        $privateKey = $key["private_key"];
        if (!openssl_sign($signatureInput, $signature, $privateKey, OPENSSL_ALGO_SHA256)) {
            return response()->json(['error' => 'Failed to sign JWT'], 500);
        }

        $base64UrlSignature = rtrim(strtr(base64_encode($signature), '+/', '-_'), '=');
        $jwt = $signatureInput . "." . $base64UrlSignature;

        // Request access token
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://oauth2.googleapis.com/token",
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => http_build_query([
                "grant_type" => "urn:ietf:params:oauth:grant-type:jwt-bearer",
                "assertion"  => $jwt
            ]),
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return response()->json(['error' => 'cURL error', 'details' => $err], 500);
        }

        $tokenData = json_decode($response, true);
        if (!isset($tokenData['access_token'])) {
            return response()->json(['error' => 'Could not generate access token', 'response' => $response], 500);
        }

        $accessToken = $tokenData['access_token'];

        // Send FCM notification
        $projectId = $key["project_id"];
        $deviceToken = "YOUR_DEVICE_TOKEN"; // Replace with actual device token

        $payload = [
            "message" => [
                "token" => $deviceToken,
                "notification" => [
                    "title" => "Hello",
                    "body"  => "Testing Push Notification"
                ],
                "data" => [
                    "screen" => "home",
                    "id" => "1001"
                ]
            ]
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/v1/projects/$projectId/messages:send");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $accessToken",
            "Content-Type: application/json"
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

        $res = curl_exec($ch);
        $curlError = curl_error($ch);
        curl_close($ch);

        return $curlError ? response()->json(['error' => $curlError], 500) : response()->json(['success' => true, 'response' => json_decode($res, true)]);
    }
}
