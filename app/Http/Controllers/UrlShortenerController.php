<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\UrlShortenerInterface;
use App\Repository\UrlShortenerRepository;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UrlShortenerRequest;

class UrlShortenerController extends Controller
{
    private UrlShortenerInterface $UrlShortenerRepository;

    public function __construct(UrlShortenerInterface $UrlShortenerRepository)
    {
      $this->UrlShortenerRepository =$UrlShortenerRepository;
    }

    public function generateShortenUrl(UrlShortenerRequest $request):JsonResponse
    {
          $url=$request->url;
          $safeBrowsingResponse = $this->UrlShortenerRepository->urlSafeBrowsingCheck($url);
         return response()->json($this->UrlShortenerRepository->urlSafeBrowsingCheck($url));
    
    }
}
