<?php

namespace App\Services;

use GuzzleHttp\Client;
use Carbon\Carbon;

class JiraService {

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var \Illuminate\Foundation\Application|mixed
     */
    protected $apiKey;

    public function __construct(Client $client)
    {
        $this->client  = $client;
        $this->account = config('jira.account');
        $this->token = config('jira.token');
        $this->apiBaseUrl = config('jira.apiBaseUrl');
    }


    public function getIssueInfo($key)
    {
        $url = '/issue/'.$key;
        try {
            $response = $this->client->get(
                $this->apiBaseUrl.$url,
                [
                    'auth' => [
                        $this->account,
                        $this->token
                    ]
                ]);

            if ( $response->getStatusCode() === 200 )
            {
                $issue = json_decode($response->getBody(), true);

                return [
                    'key'     => $key,
                    'summary' => $issue['fields']['summary'],
                    'url'     => 'https://paperstreet.atlassian.net/browse/' . $issue['key'],
                ];
            }

            return [];

        }  catch (\GuzzleHttp\Exception\RequestException $e) {
            return [];
        }
    }


    public function getTotalCasesByCountryAndType($country, $type)
    {
        $today = Carbon::now()->toDateString();

        $httpClient = new \GuzzleHttp\Client();
        $request =
            $httpClient
                ->get("https://api.covid19api.com/total/country/${country}/status/${type}?from=${today}&to=${today}");

        $response = json_decode($request->getBody()->getContents());

        return $response[count($response) - 1];
    }

}