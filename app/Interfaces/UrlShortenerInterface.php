<?php
namespace App\Interfaces;

use Illuminate\Http\Client\Response AS HttpClientResponse;
use Illuminate\Http\JsonResponse;


interface UrlShortenerInterface
{
    public function urlSafeBrowsingCheck(string $url);
    public function duplicateUrlCheck(string $url):JsonResponse;
    public function generateUrl(string $url):JsonResponse;
    public function saveShortenUrl(string $url):JsonResponse;
    public function redirectToOriginal(string $url):JsonResponse;

}
