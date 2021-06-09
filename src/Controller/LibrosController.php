<?php

namespace App\Controller;

use App\Entity\Libros;
use App\Entity\Biblioteca;
use App\Form\RegistrarLibrosType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LibrosController extends AbstractController
{
    /*#[Route('/libros', name: 'libros')]
    public function index(): Response
    {
        return $this->render('libros/index.html.twig', [
            'controller_name' => 'LibrosController',
        ]);
    }*/
    /** 
     * @Route("/verLibro/{id}", name="ver_libro" )
    */
    public function VerBiblioteca($id, Request $request ): Response {
        $em = $this->getDoctrine()->getManager();
        $libros = $em->getRepository(Libros::class)->find($id);
        $showtitulo = $libros->getTitulo();
        $shownautor = $libros->getAutor();
        $showtipo = $libros->getTipo();
        $showfecha = $libros->getFechaPublicacion();
        $ejemplares = $libros->getEjemplares();
        
        return $this->render('libros/verLibro.html.twig', [
            'titulo' => $showtitulo,
            'autor' => $shownautor,
            'tipo' => $showtipo,
            'fecha' => $showfecha,
            'ejemplares' => $ejemplares
        ]);

    }
    /** 
     * @Route("/registrar_libros/{id_biblioteca}", name="registrar_libros" )
    */
    public function index(Request $request, $id_biblioteca): Response
    {
        $libro = new Libros();
        $formLibro = $this->createForm(RegistrarLibrosType::class, $libro);
        $formLibro->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $biblioteca = $em->getRepository(Biblioteca::class)->find($id_biblioteca);
        $shownombre = $biblioteca->getNombre();
        if($formLibro->isSubmitted() && $formLibro->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($libro);
            $em->flush();
            $this->addFlash(type: 'exito', message: 'Se ha registrado el libro exitoxamente');
            return $this->redirectToRoute( route: 'inicio' );
        }
        return $this->render('libros/registrarLibro.html.twig', [
            'controller_name' => 'Registra un nuevo libro en ',
            'formularioLibro' => $formLibro->createView(),
            'id_biblioteca'=> $id_biblioteca,
            'shownombre' => $shownombre
        ]);
    }
}
