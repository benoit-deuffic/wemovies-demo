<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

interface TmdbApiServiceInterface
{

    const AUTH_TOKEN_GET_URI = 'authentication/token/new?api_key=';
    const GENDER_LIST_URI = 'genre/movie/list?language=fr-FR&api_key=';
    const DISCOVER_MOVIE_URI = 'discover/movie?language=fr-FR&api_key=%api_key%&with_genres=%genres%';
    const TOP_RATED_MOVIE_URI = 'movie/top_rated?language=fr-FR&api_key=';
    const MOVIE_URI = 'movie/{movie_id}?language=fr-FR&api_key=';
    const SEARCH_URL = 'search/movie?query={keyword}&language=fr-FR&api_key=';
     /**
     * @return string $token
     */

    public function getApiToken(): string;

    /**
     * @return mixed
     */

    public function getToken(): string;

    /**
     * @return $list
     */

    public function getMovieGenders(): object;

    /**
     * @return $list
     */

    public function getMoviesByGender(string $ids): object;

    /**
     * @return $list
     */

    public function getTopRatedMovies(string $filter = null): object;

    /**
     * @return $movie
     */

    public function getMovieById(string $id): object;

   /**
    * @return $list
    */

    public function searchMovies(string $kw): object;

}