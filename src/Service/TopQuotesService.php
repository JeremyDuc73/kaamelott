<?php

namespace App\Service;

use App\Repository\QuoteRepository;

class TopQuotesService
{
    public function __construct(private QuoteRepository $repository){}

    public function getTopQuotes(): array
    {
        $quotes = $this->repository->findAll();
        foreach ($quotes as $quote){
            $quotesArray[] = [
                'saves' => count($quote->getOwner()),
                'quote_id' => $quote->getId()
            ];
        }
        arsort($quotesArray);
        $quotesArray = array_slice($quotesArray, 0, 3);
        for ($i = 0; $i < 3; $i++) {
            $quote = $this->repository->findById($quotesArray[$i]['quote_id']);
            $finalArray[] = $quote;
        }
        return $finalArray;
    }
}