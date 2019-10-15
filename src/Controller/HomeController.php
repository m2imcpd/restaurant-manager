<?php
namespace App\Controller;

use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @var RestaurantRepository
     */
    private $repository;

    /**
     * Note: Injection du Repository Restaurant dans le constructeur pour résoudre la dépendance
     * HomeController constructor.
     * @param RestaurantRepository $repository
     */
    public  function __construct(RestaurantRepository $repository)
    {

        $this->repository = $repository;
    }

    /**
     * Note: Retourne une liste d'objets de Restaurant accessibles par index
     * grâce à la requête findAll du Repository Restaurant
     * @Route("/", name="home.index")
     * @param RestaurantRepository $repository
     * @return Response
     */
    public function index(RestaurantRepository $repository) : Response
    {
        $restaurants = $this->repository->findAll();
        dump($restaurants);
        return $this->render('home/index.html.twig',[
            'restaurants' =>$restaurants
        ]);
    }

}