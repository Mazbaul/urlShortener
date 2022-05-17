<?php
namespace App\Interfaces;

use Illuminate\Http\Client\Response AS HttpClientResponse;
use Illuminate\Http\JsonResponse;
use App\Models\ShortenUrlModel;


interface UrlShortenerInterface
{
    public function urlSafeBrowsingCheck(string $url);
    public function duplicateUrlCheck(string $url):ShortenUrlModel|null;
    public function generateUrl(string $url):array;
    public function saveShortenUrl(array $urlshort):ShortenUrlModel;
    public function redirectToUrl(string $url);

}
