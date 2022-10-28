<?php

namespace App\Services;

use GuzzleHttp\Client;
use Carbon\Carbon;

class JiraService {

    /**
     * @var Client
     */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client  = $client;
        $this->account = config('jira.account');
        $this->token = config('jira.token');
        $this->apiBaseUrl = config('jira.apiBaseUrl');
    }


    public function getIssueInfo($key)
    {
        // if empty key or key is LR, return empty
        if (empty($key) || str_contains($key, 'LR')) {
            return [];
        }

        // trim both sides of the string
        $key = trim($key);

        if ( ! str_contains($key, '-')) {
            // if key does not contain dash, add TSV4- prefix, TSV4-3333
            $key = 'TSV4-'.$key;
        }

        //uri= https://paperstreet.atlassian.net/rest/api/3/issue/TSV4-3333
        $uri = $this->apiBaseUrl.'/issue/'.$key;

        // fetch issue info from Jira
        try {
            $response = $this->client->get(
                $uri,
                [
                    'auth' => [
                        $this->account,
                        $this->token
                    ]
                ]);

            if ( $response->getStatusCode() === 200 ) {
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