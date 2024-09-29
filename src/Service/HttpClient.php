<?php

declare(strict_types=1);

namespace Alura\BoasPraticas\Service;

class HttpClient
{
    public function get(string $url): string
    {
        return @file_get_contents($url);
    }

    public function post(string $url, \JsonSerializable $requestBody): array
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($requestBody));
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

        $responseBody = curl_exec($curl);
        $responseStatusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        return [$responseStatusCode, $responseBody];
    }
}
