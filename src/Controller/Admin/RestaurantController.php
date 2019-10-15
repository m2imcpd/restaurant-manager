<?php
namespace App\Controller\Admin;

use App\Form\RestaurantType;
use App\Entity\Restaurant;
use App\Repository\RestaurantRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * Note:Permet l'ajout d'un restaurant grâce à la génération d'un formulaire mappé sur l'entité restaurant
     * avec une validation des donnéesau niveau du isValid et la persistance des données avec le object manager($em)
     * suivie d'un message addflash passé a la vue
     * @Route("/admin/restaurant/create", name= "admin.restaurant.new")
     * @param Request $request permet de gérer la requête en l'occurence du POST
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request)
    {
        $restaurant = new Restaurant();
        $form = $this->createForm(RestaurantType::class,$restaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $this->em->persist($restaurant);
            $this->em->flush();
            $this->addFlash('succes', 'Créer avec succès');
            return $this->redirectToRoute('admin.restaurant.index');
        }

        return $this->render('admin/restaurant/new.html.twig',[
            'restaurant' => $restaurant,
            'form' => $form->createView()
        ]);
    }

    /**
     * Note:Permet l'édition d'un restaurant grâce à la génération d'un formulaire mappé sur l'entité restaurant
     * avec une validation des donnéesau niveau du isValid et la persistance des données avec le object manager($em)
     * suivie d'un message addflash passé a la vue et d'une redirection vers l'index
     * @Route("/admin/restaurant/{id}", name="admin.restaurant.edit", methods="GET|POST")
     * @param $id
     * @return Response
     */
    public function edit($id, Request $request)
    {
        $restaurant = $this->repository->find($id);
        $form = $this->createForm(RestaurantType::class,$restaurant);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->addFlash('succes', 'Modifier avec succès');
            return $this->redirectToRoute('admin.restaurant.index');
        }
        return $this->render('admin/restaurant/edit.html.twig',[
            'restaurant' => $restaurant,
            'form' => $form->createView()
        ]);
    }

    /**
     *Note: Permet la suppression d'un restaurant avec une validation du CsrfToken du formulaire au niveau du isCsrfTokenValid
     * suivie la suppression des données avec le object manager($em) et d'une redirection vers l'index
     * suivie d'un message addflash passé a la vue
     * @Route("/admin/restaurant/{id}", name="admin.restaurant.delete", methods="DELETE")
     */
    public function delete(Restaurant $restaurant, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $restaurant->getId(), $request->get('_token'))){
            $this->em->remove($restaurant);
            $this->em->flush();
            $this->addFlash('succes', 'Supprimer avec succès');
            return $this->redirectToRoute('admin.restaurant.index');
        }

    }
}