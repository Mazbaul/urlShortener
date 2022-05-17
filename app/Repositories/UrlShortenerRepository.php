<?php

namespace App\Repositories;

use App\Interfaces\UrlShortenerInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use App\Models\ShortenUrlModel;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Client\Response AS HttpClientResponse;

class UrlShortenerRepository implements UrlShortenerInterface
{
  private string $api_key;

  public function __construct()
  {
      $this->apikey = is_null(env('GOOGLE_APP_API_KEY')) ? '' : env('GOOGLE_APP_API_KEY');
  }

  public function urlSafeBrowsingCheck(string $url)
  {
      $postUrl = 'https://safebrowsing.googleapis.com/v4/threatMatches:find?key='.$this->apikey;

             $payload = [
                 'client' => [
                     'clientId' => 'mazba',
                     'clientVersion' => '1.5.2',
                 ],
                 'threatInfo' => [
                    "threatTypes"       =>   [
                                              'THREAT_TYPE_UNSPECIFIED',
                                              'MALWARE',
                                              'SOCIAL_ENGINEERING',
                                              'UNWANTED_SOFTWARE',
                                              'POTENTIALLY_HARMFUL_APPLICATION',
                                              ],
                     "platformTypes"     =>  [
                                              'WINDOWS',
                                              'LINUX',
                                              'ANDROID',
                                              'OSX',
                                              'IOS',
                                              'ANY_PLATFORM',
                                            ],
                     "threatEntryTypes"  => ["URL"],
                     "threatEntries"     =>[
                                            [ "url"=>"$url"]
                                          ]
                 ]
             ];

             $ch = curl_init();
             $timeout = 20;
             curl_setopt($ch,CURLOPT_URL,$postUrl);
             curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($payload));
             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
             curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
             curl_setopt($ch, CURLOPT_HTTPHEADER,
                 array(
                     'Content-Type: application/json',
                     'Connection: Keep-Alive'
                 ));

             $data = curl_exec($ch);
             $responseDecoded = json_decode($data, true);
             $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
             curl_close($ch);


             if ($responseCode != 200) {
                 return $responseDecoded;
             }

             return $data;
  }

  public function duplicateUrlCheck(string $url):ShortenUrlModel|null
  {
    return ShortenUrlModel::where('original_url','=',$url)->first();
  }

  public function generateUrl(string $url):array
  {
    $baseUrl = URL::to('');
    return [
            'baseUrl'=>$baseUrl.'/',
            'hash_code'=>substr(md5(microtime()), 0, 6)
            ];
  }

  public function saveShortenUrl(array $urlshort ):ShortenUrlModel
  {
     return ShortenUrlModel::create($urlshort);
  }

  public function redirectToUrl(string $hash):string
  {
    return ShortenUrlModel::where('hash_code','=',$hash)->first()->original_url;
  }
}
