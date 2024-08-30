<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminRoomController extends AbstractController
{
    #[Route('/admin/room', name: 'admin_room')]
    public function index(): Response
    {
        return $this->render('admin/room/index.html.twig');
    }
}
