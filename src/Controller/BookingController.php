<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingController extends AbstractController
{
    #[Route('/check-availability', name: 'check_availability')]
    public function search(Request $request, RoomRepository $roomRepository): Response
    {
        // Créer le formulaire
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        $availableRooms = [];

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer les données du formulaire
            $data = $form->getData();
            $startDate = $data['startDate'];
            $endDate = $data['endDate'];

            // Utiliser la méthode custom dans RoomRepository pour rechercher les chambres disponibles
            $availableRooms = $roomRepository->findAvailableRooms($startDate, $endDate);
        }

        return $this->render('booking/search.html.twig', [
            'form' => $form->createView(),
            'availableRooms' => $availableRooms,
        ]);
    }
}
