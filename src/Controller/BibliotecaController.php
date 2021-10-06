<?php

namespace App\Controller;

use App\Entity\Biblioteca;
use App\Repository\BibliotecaRepository;
use App\Repository\LibroRepository;
use App\Entity\Libro;
use App\Form\EditarBibliotecaType;
use App\Form\RegistrarBibliotecaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
    public function VerBiblioteca($id, Request $request ): Response {
        $em = $this->getDoctrine()->getManager();
        $biblioteca = $em->getRepository(Biblioteca::class)->find($id);
        $libros = $em->getRepository(Libro::class)->BuscarTodosLosLibros($id);
        return $this->render('biblioteca/verBiblioteca.html.twig', [
            'biblioteca' =>  $biblioteca,
            'libr' => $libros

        ]);

    }
    /**
     * @Route("/borrarBiblioteca/{id}", name="borra_biblioteca")
     */
    public function borrarBiblioteca($id, Request $request ): Response {
        $em = $this->getDoctrine()->getManager();
        $biblioteca = $em->getRepository(Biblioteca::class)->find($id);
        if (!$biblioteca) {
            throw $this->createNotFoundException(
                'No existe la biblioteca '.$id
            );
        }
        $em->remove($biblioteca);

        $em->flush();
        return $this->redirectToRoute( route: 'inicio');

    }
    /**
     * @Route("/editarBiblioteca/{id}", name="editar_biblioteca")
     */
    public function editarBiblioteca($id, Request $request ): Response {
        
        $viewbiblioteca = new Biblioteca();
        $formBiblioteca = $this->createForm(EditarBibliotecaType::class, $viewbiblioteca);
        $formBiblioteca->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $biblioteca = $em->getRepository(Biblioteca::class)->find($id);
        if($formBiblioteca->isSubmitted() && $formBiblioteca->isValid()) {
            if (!$biblioteca) {
                throw $this->createNotFoundException(
                    'No existe la biblioteca '.$id
                );
            }     
            $biblioteca->setNombre($formBiblioteca['nombre']->getData());
            $biblioteca->setNumTrabajadores($formBiblioteca['num_trabajadores']->getData());
            $biblioteca->setDireccion($formBiblioteca['direccion']->getData());
            $biblioteca->setFechaFundacion($formBiblioteca['fecha_fundacion']->getData());
            $em->flush();
            return $this->redirectToRoute('editar_biblioteca', [
                'id' => $biblioteca->getId()
            ]);
        }
        return $this->render('biblioteca/editarBiblioteca.html.twig', [
            'formularioeditarBiblioteca' =>$formBiblioteca->createView(),
            'biblioteca' => $biblioteca 
        ]);
        
    }
}
