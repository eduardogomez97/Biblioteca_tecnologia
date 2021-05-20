<?php

namespace App\Controller;

use App\Entity\Biblioteca;
use App\Form\RegistrarBibliotecaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BibliotecaController extends AbstractController
{
    /** 
     * @Route("/registrar_biblioteca", name="registrar_biblioteca" )
    */
    public function index(Request $request): Response
    {
        $biblioteca = new Biblioteca();
        $formBiblioteca = $this->createForm(RegistrarBibliotecaType::class, $biblioteca);
        $formBiblioteca->handleRequest($request);
        if($formBiblioteca->isSubmitted() && $formBiblioteca->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($biblioteca);
            $em->flush();
            $this->addFlash(type: 'exito', message: 'Se ha registrado la nueva biblioteca exitoxamente');
            return $this->redirectToRoute( route: 'registrar_biblioteca');
        }
        return $this->render('biblioteca/index.html.twig', [
            'controller_name' => 'Registra una nueva biblioteca',
            'formularioBiblioteca' =>$formBiblioteca->createView()
        ]);
    }

    /** 
     * @Route("/verBiblioteca/{id}", name="ver_biblioteca" )
    */
    public function VerBiblioteca($id) {
        $em = $this->getDoctrine()->getManager();
        $biblioteca = $em->getRepository(/*className:*/ Biblioteca::class)->find($id);
        return $this->render('biblioteca/verBiblioteca.html.twig', [
            'pagination' => $biblioteca
            
        ]);

    }
}
