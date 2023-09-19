<?php

namespace App\Controller;

use App\Entity\History;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ExchangeController extends AbstractController
{



    #[Route('/exchange/values', name: 'app_exchange', methods: "POST")]
    public function exchangeValue(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {

        $data = json_decode($request->getContent(), true);

        if(isset($data['first']) && isset($data['second'])) {
           $first = intval($data['first']);
           $second = intval($data['second']);

           //Zmiana wartości
            $first = $first + $second;
            $second = $first - $second;
            $first = $first - $second;

            $history = new History();
            $history->setFirstIn($data['first']);
            $history->setSecondIn($data['second']);
            $history->setFirstIn($first);
            $history->setSecondIn($second);
            $history->setDataUtworzenia(new \DateTime());
            $history->setDataAktualizacji(new \DateTime());

            $entityManager->persist($history);
            $entityManager->flush();

            $responseData = [
                'message' => "Wartości zostały zamienione i zapisane w bazie",
                'first' => $first,
                'second' => $second,
            ];

            return $this->json($responseData);
        }else {
            return $this->json(['error' => 'Brak wartosci "first" i "second" w danych.'], 400);
        }



    }
}
