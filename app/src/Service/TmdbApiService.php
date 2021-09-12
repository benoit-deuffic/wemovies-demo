<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class TmdbApiService implements TmdbApiServiceInterface
{
    private $client;
    private $apiKey;
    private $apiEndPoint;
    private $parameters;

    private $token;

    public function __construct(HttpClientInterface $client, ContainerBagInterface $params)
    {
        $this->client = $client;
        $this->parameters = $params;
        $this->apiKey = $this->parameters->get('app.api_key');
        $this->apiEndPoint = $this->parameters->get('app.api_endpoint');
    }


    /**
     * @return string $token
     */

    public function getApiToken(): string
    {
        $authEndpoint = $this->apiEndPoint .
            self::AUTH_TOKEN_GET_URI .
            $this->apiKey;
        $response = $this->client->request('GET',
            $authEndpoint);

        $this->token = $response->getContent();

        return $this->token;

    }

    /**
     * @return mixed
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return $list
     */

    public function getMovieGenders(): object
    {
        $genderListEndpoint = $this->apiEndPoint .
            self::GENDER_LIST_URI .
            $this->apiKey;
        $response = $this->client->request('GET',
            $genderListEndpoint);

        $list = json_decode($response->getContent());

        return $list;

    }

    /**
     * @return $list
     */

    public function getMoviesByGender(string $ids): object
    {

        $replace_keys = ['%api_key%', '%genres%'];
        $replace_values = [$this->apiKey, $ids];

        $requestUri = $this->apiEndPoint .
            str_replace($replace_keys, $replace_values, self::DISCOVER_MOVIE_URI);
        $response = $this->client->request('GET',
            $requestUri);

        $list = json_decode($response->getContent());

        return $list;


    }

    /**
     * @return $list
     */

    public function getTopRatedMovies(string $filter = null): object
    {

        $TopREndpoint = $this->apiEndPoint .
            self::TOP_RATED_MOVIE_URI .
            $this->apiKey;
        $response = $this->client->request('GET',
            $TopREndpoint);

        $movie = json_decode($response->getContent());

        return $movie;


    }

    /**
     * @return $movie
     */

    public function getMovieById(string $id): object
    {
        $queryString = str_replace('{movie}', $id, self::MOVIE_URI);
        $movieEndpoint = $this->apiEndPoint . $queryString . $this->apiKey;
        $response = $this->client->request('GET',
            $movieEndpoint);

        $movie = json_decode($response->getContent());

        return $movie;
    }

    /**
     * @return $list
     */

    public function searchMovies(string $kw): object {

        $queryString = str_replace('{keyword}', $kw, self::SEARCH_URL);
        $searchEndpoint = $this->apiEndPoint. $queryString . $this->apiKey;

        $response = $this->client->request('GET', $searchEndpoint);

        $list = json_decode($response);

        return $list;

    }
}