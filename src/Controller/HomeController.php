<?php

namespace App\Controller;

use App\Entity\Biblioteca;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository(Biblioteca::class)-> BuscarTodasLasBibliotecas() ;
        //$query = $em->getRepository(Biblioteca::class)->findAll();
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        return $this->render('home/index.html.twig', [
            'controller_name' => 'Bienvenido a la Home',
            'pagination' => $pagination
            
        ]);
    }
}
