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
        $uri = $this->apiBaseUrl.$url;
        //uri= https://paperstreet.atlassian.net/rest/api/3/issue/TSV4-3333

        try {
            $response = $this->client->get(
                $uri,
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
}