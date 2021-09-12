<?php

namespace App\Controller;

use App\Service\TmdbApiServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeMoviesController extends AbstractController
{

    private $tmdb;

    const BASE_HTML_TWIG = "base.html.twig";

    public function __construct(TmdbApiServiceInterface $tmdb)
    {
        $this->tmdb = $tmdb;
    }

    private function getGenders(): object
    {

        return $this->tmdb->getMovieGenders();
    }

    /**
     * @Route("/", name="wemovies")
     */

    public function index(): Response
    {
        $genders = $this->getGenders();
        $bestRatedMovieRes = $this->tmdb->getTopRatedMovies();
        $bestRandomRatedMovie = [$bestRatedMovieRes->results[array_rand($bestRatedMovieRes->results)]];
        return $this->render(self::BASE_HTML_TWIG,
            ['genders' => $genders,
                'top_rated_movies' => $bestRandomRatedMovie,
            ]);

    }

    /**
     * @Route("/movies/gender", name="wemovies_by_gender")
     */

    public function getMoviesByGender(Request $request): Response
    {

        $filter = $request->query->get('genre');

        $genders = $this->getGenders();
        $movies = $this->tmdb->getMoviesByGender($filter);

        return $this->render(self::BASE_HTML_TWIG,
            ['genders' => $genders,
                'top_rated_movies' => $movies->results,
            ]);

    }
    /**
     * @Route("/search/movies", name="wemovies_search")
     */

    public function searchMovies(Request $request): Response
    {
        $keyword = $request->query->get('kw');

        $results = $this->tmdb->searchMovies($keyword);

        return $this->json($results);
    }
}
