<?php

namespace App\Http\Controllers\Api; // API folder use kar rahe hain

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FcmApiController extends Controller
{
    public function sendNotification(Request $request)
    {
        $serviceAccountFile = storage_path('app/firebase-key.json');

        if (!file_exists($serviceAccountFile)) {
            return response()->json(['error' => 'firebase-key.json missing'], 500);
        }

        $key = json_decode(file_get_contents($serviceAccountFile), true);

        if (!$key || !isset($key['client_email'], $key['private_key'], $key['project_id'])) {
            return response()->json(['error' => 'Invalid Firebase service account JSON'], 500);
        }

        // JWT create
        $header = ['alg' => 'RS256', 'typ' => 'JWT'];
        $now = time();
        $claims = [
            "iss" => $key["client_email"],
            "sub" => $key["client_email"],
            "aud" => "https://oauth2.googleapis.com/token",
            "iat" => $now,
            "exp" => $now + 3600,
            "scope" => "https://www.googleapis.com/auth/firebase.messaging"
        ];

        $base64UrlHeader = rtrim(strtr(base64_encode(json_encode($header)), '+/', '-_'), '=');
        $base64UrlClaims = rtrim(strtr(base64_encode(json_encode($claims)), '+/', '-_'), '=');
        $signatureInput = $base64UrlHeader . "." . $base64UrlClaims;

        $privateKey = $key["private_key"];
        if (!openssl_sign($signatureInput, $signature, $privateKey, OPENSSL_ALGO_SHA256)) {
            return response()->json(['error' => 'Failed to sign JWT'], 500);
        }

        $base64UrlSignature = rtrim(strtr(base64_encode($signature), '+/', '-_'), '=');
        $jwt = $signatureInput . "." . $base64UrlSignature;

        // Get access token
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
        $curlError = curl_error($curl);
        curl_close($curl);

        if ($curlError) {
            return response()->json(['error' => 'cURL error', 'details' => $curlError], 500);
        }

        $tokenData = json_decode($response, true);
        if (!isset($tokenData['access_token'])) {
            return response()->json(['error' => 'Could not generate access token', 'response' => $response], 500);
        }

        $accessToken = $tokenData['access_token'];

        // Receive input from API request
        $deviceToken = $request->device_token ?? null;
        $title = $request->title ?? 'Hello';
        $body = $request->body ?? 'Testing Push Notification';
        $dataPayload = $request->data ?? ['screen' => 'home', 'id' => '1001'];

        if (!$deviceToken) {
            return response()->json(['error' => 'Device token is required'], 422);
        }

        $payload = [
            "message" => [
                "token" => $deviceToken,
                "notification" => [
                    "title" => $title,
                    "body"  => $body
                ],
                "data" => $dataPayload
            ]
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/v1/projects/{$key['project_id']}/messages:send");
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

        return $curlError
            ? response()->json(['error' => $curlError], 500)
            : response()->json(['success' => true, 'response' => json_decode($res, true)]);
    }
}
