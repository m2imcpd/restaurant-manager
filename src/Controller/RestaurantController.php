<?php
namespace App\Controller;

use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RestaurantController extends AbstractController
{
    /**
     * Note: Retourne un objet Restaurant accessible par la vue show
     * grâce à la requête find du Repository Restaurant injecté en paramètre
     * @Route("/restaurant/{id}", name="restaurant.show")
     * @param $id
     * @return Response
     */
    public function show($id,RestaurantRepository $repository) : Response
    {

        $restaurant = $repository->find($id);
        if($restaurant)
            return new Response($this->renderView('restaurant/show.html.twig',[
                'restaurant' => $restaurant
            ]));
        else{
            return $this->redirectToRoute('home.index',[],301);
        }
    }
}