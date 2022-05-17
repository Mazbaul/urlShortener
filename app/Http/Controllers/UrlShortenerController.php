<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\UrlShortenerInterface;
use App\Repository\UrlShortenerRepository;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UrlShortenerRequest;
use Illuminate\Http\Response;
use App\Models\ShortenUrlModel;
use App\Http\Resources\ShortenUrlResource;
use DB;
use Illuminate\Support\Facades\Redirect;



class UrlShortenerController extends Controller
{
    private UrlShortenerInterface $UrlShortenerRepository;

    public function __construct(UrlShortenerInterface $UrlShortenerRepository)
    {
      $this->UrlShortenerRepository =$UrlShortenerRepository;
    }

    public function generateShortenUrl(UrlShortenerRequest $request):ShortenUrlResource|JsonResponse
    {
          $url=$request->url;
          $safeBrowsingResponse = json_decode($this->UrlShortenerRepository->urlSafeBrowsingCheck($url),true);

          if (!isset($safeBrowsingResponse['matches'])) {
            DB::beginTransaction();
            try {
              $exists = $this->UrlShortenerRepository->duplicateUrlCheck($url);
              if(!$exists){
                    $newUrl=$this->UrlShortenerRepository->generateUrl($url);
                    $urlshort =[
                      'original_url'=>$url,
                      'shorten_url'=>$newUrl['baseUrl'].$newUrl['hash_code'],
                      'hash_code' =>$newUrl['hash_code']
                    ];
                    $urlshort=$this->UrlShortenerRepository->saveShortenUrl($urlshort);
                    DB::commit();
                    return new ShortenUrlResource($urlshort);
                }else{
                  return new ShortenUrlResource($exists);
                }

            } catch (\Exception $e) {
              DB::rollback();
              return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
          } else {
            return response()->json(['message' => 'This URL is not safe'], Response::HTTP_UNPROCESSABLE_ENTITY);
          }

    }

    public function redirectToOriginal($shortenUrl)
    {
      return Redirect::to($this->UrlShortenerRepository->redirectToUrl($shortenUrl));
    }
}
