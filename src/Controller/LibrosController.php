<?php

namespace App\Controller;

use App\Entity\Biblioteca;
use App\Entity\Libro;
use App\Form\EditarLibroType;
use App\Form\RegistrarLibrosType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LibrosController extends AbstractController
{
    /** 
     * @Route("/verBiblioteca/{id_biblioteca}/verLibro/{id}", name="ver_libro" )
    */
    public function VerBiblioteca($id, Request $request ): Response {
        $em = $this->getDoctrine()->getManager();
        $libros = $em->getRepository(Libro::class)->find($id);
        
        return $this->render('libros/verLibro.html.twig', [
            'libros' => $libros,
        ]);

    }
    /** 
     * @Route("/verBiblioteca/{id_biblioteca}/registrar_libros", name="registrar_libros" )
    */
    public function index(Request $request, $id_biblioteca): Response
    {
        $libro = new Libro();
        $formLibro = $this->createForm(RegistrarLibrosType::class, $libro);
        $formLibro->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $biblioteca = $em->getRepository(Biblioteca::class)->find($id_biblioteca);
        $shownombre = $biblioteca->getNombre();
        if($formLibro->isSubmitted() && $formLibro->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $libro->setBiblioteca($biblioteca);
            $em->persist($libro);
            $em->flush();

            return $this->redirectToRoute('ver_biblioteca', [
                'id' => $id_biblioteca
            ]);
        }
        return $this->render('libros/registrarLibro.html.twig', [
            'controller_name' => 'Registra un nuevo libro en ',
            'formularioLibro' => $formLibro->createView(),
            'shownombre' => $shownombre
        ]);
    }
    /**
     * @Route("/verBiblioteca/{id_biblioteca}/borrarLibro/{id}", name="borra_libro")
     */
    public function borrarLibro($id_biblioteca,$id, Request $request ): Response {
        $em = $this->getDoctrine()->getManager();
        $libro = $em->getRepository(Libro::class)->find($id);
        if (!$libro) {
            throw $this->createNotFoundException(
                'No existe el libro '.$id
            );
        }
        $em->remove($libro);

        $em->flush();
        return $this->redirectToRoute('ver_biblioteca', [
            'id' => $id_biblioteca
        ]);

    }
    /**
     * @Route("/verBiblioteca/{id_biblioteca}/editarLibro/{id}", name="editar_libro")
     */
    public function editarLibro($id_biblioteca,$id, Request $request ): Response {
        
        $viewlibro = new Libro();
        $formLibro = $this->createForm(EditarLibroType::class, $viewlibro);
        $formLibro->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $libro = $em->getRepository(Libro::class)->find($id);
        if($formLibro->isSubmitted() && $formLibro->isValid()) {
            if (!$libro) {
                throw $this->createNotFoundException(
                    'No existe la biblioteca '.$id
                );
            }        
            $libro->setTitulo($formLibro['titulo']->getData());
            $libro->setAutor($formLibro['autor']->getData());
            $libro->setTipo($formLibro['tipo']->getData());
            $libro->setFechaPublicacion($formLibro['fecha_publicacion']->getData());
            $libro->setEjemplares($formLibro['ejemplares']->getData());
            $em->flush();
            return $this->redirectToRoute('ver_biblioteca', [
                'id' => $id_biblioteca
            ]);
        }
        return $this->render('libros/editarLibro.html.twig', [
            'formularioeditarLibro' =>$formLibro->createView(),
            'libros' => $libro
        ]);
        
    }
}
