<?php

namespace App\Controller\Admin;

use App\Entity\Horaire;
use App\Form\HoraireType;
use App\Repository\HoraireRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/horaire")
 */
class HoraireController extends AbstractController
{

    /**
     * @var HoraireRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * Note: Injection du Repository Horaire dans le constructeur pour résoudre la dépendance
     * Injection du Object Manager pour les différentes persistances dans la base de donnée
     * @param HoraireRepository $repository
     * @param ObjectManager $em
     */
    public function __construct(HoraireRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/", name="admin.horaire.index", methods="GET")
     */
    public function index(): Response
    {
        return $this->render('admin/horaire/index.html.twig', ['horaires' => $this->repository->findAll()]);
    }

    /**
     * Note:Permet l'ajout d'un Horaire de restaurant grâce à la génération d'un formulaire mappé sur l'entité Horaire
     * avec une validation des donnéesau niveau du isValid et la persistance des données avec le object manager($em)
     * suivie d'un message addflash passé a la vue et d'une redirection vers l'index
     * @Route("/new", name="admin.horaire.new", methods="GET|POST")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $horaire = new Horaire();
        $form = $this->createForm(HoraireType::class, $horaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($horaire);
            $em->flush();

            return $this->redirectToRoute('admin.horaire.index');
        }

        return $this->render('admin/horaire/new.html.twig', [
            'horaire' => $horaire,
            'form' => $form->createView(),
        ]);
    }
}
