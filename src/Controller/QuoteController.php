<?php

namespace App\Controller;

use App\Entity\Quote;
use App\Repository\QuoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/quote')]
class QuoteController extends AbstractController
{
    #[Route('/myquotes', name: 'app_myquotes')]
    public function myQuotes(): Response
    {
        return $this->render('quote/index.html.twig');
    }

    #[Route('/savequote', name: 'app_savequote')]
    public function saveQuote(QuoteRepository $quoteRepository, Request $request): Response
    {
        $quote = new Quote();

        $content = $request->get('content');
        $character = $request->get('character');
        $existingQuote = $quoteRepository->findOneBy(['content'=> $content]);
        if ($existingQuote){
            $existingQuote->addOwner($this->getUser());
            $quoteRepository->save($existingQuote, true);
            return $this->redirectToRoute('app_myquotes');
        } else {
            $quote->setContent($content);
        }
        $quote->setCharacter($character);
        $quote->addOwner($this->getUser());
        $quoteRepository->save($quote, true);

        return $this->redirectToRoute('app_myquotes');
    }

    #[Route('/delete/{quoteId}', name: 'app_deletequote')]
    public function deleteQuote(Request $request, EntityManagerInterface $manager, QuoteRepository $quoteRepository): Response
    {
        $quoteId =$request->get('quoteId');
        $quote = $quoteRepository->findOneBy(['id'=>$quoteId]);
        $quote->removeOwner($this->getUser());
        $manager->flush();
        return $this->redirectToRoute('app_myquotes');
    }


}
