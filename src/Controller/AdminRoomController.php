<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Room;
use App\Form\AdminRoomType;
use App\Service\UploadImage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationRequestHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminRoomController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/admin/room', name: 'admin_room')]
    public function index(): Response
    {
        return $this->render('admin/room/index.html.twig');
    }

    #[Route('/admin/room/new', name: 'admin_room_new')]
    public function create(Request $request, EntityManagerInterface $entityManager, UploadImage $uploader): Response
    {

        $room = new Room();

        $form = $this->createForm(AdminRoomType::class, $room);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /* foreach ($ad->getImages() as $image) {

                $image->setAd($ad);
                $manager->persist($image);
            } */

            //On récupère les images transmise
            $images = $form->get('images')->getData();

            //ON boucle sur les images
            foreach ($images as $image) {
                // On génère un noveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                //On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('imagesRoomDestination'),
                    $fichier
                );

                //On stock l'image dans la base de donner
                $img = new Image();
                $img->setCaption($fichier);
                $room->addImage($img);
            }
            $nouvauNomImage = $uploader->enregistreImage($form->get('imageFile')->getData(), $room->getImage());

            if ($nouvauNomImage != null) {
                $room->setImage($nouvauNomImage);
            }

            // $room->setAuthor($this->getUser());

            $entityManager->persist($room);
            $entityManager->flush();

            $this->addFlash(
                'success',
                "La chambre <strong>{$room->getType()}</strong> a été bien enregisttée !"
            );

            /* return $this->redirectToRoute('ads_show', [
                'slug' => $ad->getSlug(),
            ]); */
        }

        return $this->render('admin/room/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
