<?php

namespace App\Controller;

use App\Entity\Game;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {

        unset($_SESSION['game']);

        if(isset($_GET['game'])){
            $_SESSION['game'] = $_GET['game'];
            return $this->redirectToRoute('game');
        }

        $gameRepository = $this->getDoctrine()->getRepository(Game::class);

        // On récupère toutes les parties
        $games = $gameRepository->findAll();

        // On récupère toutes les parties joignables
        $activeGames = $gameRepository->findBy([
            'state' => 'on',
            'type' => 'public',
        ]);

        return $this->render('home/index.html.twig', [
            'allGames' => $games,
            'joinGames' => $activeGames,
        ]);
    }
}
