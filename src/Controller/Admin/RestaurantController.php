<?php
namespace App\Controller\Admin;

use App\Form\RestaurantType;
use App\Repository\RestaurantRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class RestaurantController extends AbstractController
{
    /**
     * @var RestaurantRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * Note: Injection du Repository Restaurant dans le constructeur pour résoudre la dépendance
     * Injection du Object Manager pour les différentes persistances dans la base de donnée
     * AdminPropertyController constructor.
     * @param RestaurantRepository $repository
     * @param ObjectManager $em
     */
    public function __construct(RestaurantRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * Note: Retourne une liste d'objets de Restaurant accessibles par la vue index a l'admin
     * en vue des suppression, modification ou création (CRUD)
     * @Route("/admin/restaurant", name="admin.restaurant.index")
     * @return Response
     */
    public function index() :Response
    {
        $restaurants = $this->repository->findAll();
        return new Response($this->renderView('admin/restaurant/index.html.twig', compact('restaurants')));
    }

}