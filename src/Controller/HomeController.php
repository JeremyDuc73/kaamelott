<?php

namespace App\Controller;

use App\Entity\Quote;
use App\Entity\User;
use App\Repository\QuoteRepository;
use App\Service\KaamelottApiService;
use App\Service\TopQuotesService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(KaamelottApiService $kaamelottApiService): Response
    {
        $data = $kaamelottApiService->getQuote();
        return $this->render('home/index.html.twig', [
            'data'=>$data
        ]);
    }

    #[Route('/topquotes', name: 'app_topquotes')]
    public function topQuotes(TopQuotesService $topQuotesService): Response
    {
        return $this->render('home/topquotes.html.twig', [
            'topquotes'=>$topQuotesService->getTopQuotes()
        ]);
    }

    #[Route('/api/username', name: 'app_api_username', methods: ['GET'])]
    public function apiUsername(): Response
    {
        $user = $this->getUser();
        $username = $user->getUsername();
        return $this->json($username, 200);
    }

    #[Route('/api/quotes', name: 'app_api_quotes', methods: ['GET'])]
    public function apiQuotes(TopQuotesService $topQuotesService): Response
    {
        $topQuotes = $topQuotesService->getTopQuotes();
        return $this->json($topQuotes, 200, [], ['groups'=>'quote:read']);
    }

}
