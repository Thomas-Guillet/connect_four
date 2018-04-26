<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Game;
use \Datetime;

class GameController extends Controller
{
    /**
     * @Route("/game", name="game")
     */
    public function index()
    {
        $aUser = $this->getUser();

        if(!isset($_SESSION['game'])){
            $entityManager = $this->getDoctrine()->getManager();

            $game = new Game();
            $game->setState('on');
            $game->setPieces('0');
            $game->setCode('default');
            $game->setCreatedAt(new DateTime());
            $game->setType('private');
            $game->setOwner($aUser);

            $entityManager->persist($game);

            $entityManager->flush();

            $_SESSION['game'] = $game->getId();

            $sStatutPlayer = 'the owner';
            
        }else{
            $game = $this->getDoctrine()->getRepository(Game::class)->find($_SESSION['game']);
            if($game->getOwner()->getId() != $aUser->getId()){
                if($game->getPlayer() == null){
                    $game->setPlayer($aUser);
                    $this->getDoctrine()->getManager()->flush();
                    $sStatutPlayer = 'a player';
                }else if($game->getPlayer()->getId() == $aUser->getId()){
                    $sStatutPlayer = 'a player';
                }else{
                    $sStatutPlayer = 'a viewer';
                }
            }else{
                $sStatutPlayer = 'the owner';
            }
        }


        return $this->render('game/index.html.twig', [
            'session' => $_SESSION,
            'game' => $game,
            'statut' => $sStatutPlayer,
        ]);
    }
}
