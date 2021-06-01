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
    #[Route('/dashboard', name: 'inicio')]
    public function index(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository(Biblioteca::class)-> BuscarTodasLasBibliotecas();
        //$linkview = redirecti( route: 'registrar_biblioteca');
        return $this->render('home/index.html.twig', [
            'controller_name' => 'Bienvenido a la Home',
            'pagination' => $query//,
            //'linkview' => $linkview
            
        ]);
    }
}