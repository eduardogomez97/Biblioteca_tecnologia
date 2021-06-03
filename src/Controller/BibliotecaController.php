<?php

namespace App\Controller;

use App\Entity\Biblioteca;
use App\Entity\Libros;
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
        $shownombre = $biblioteca->getNombre();
        $showntrabajadores = $biblioteca->getNumTrabajadores();
        $showdirection = $biblioteca->getDireccion();
        $showfecha = $biblioteca->getFechaFundacion();
        $query = $em->getRepository(Libros::class)->BuscarTodasLasLibros($id);
        
        return $this->render('biblioteca/verBiblioteca.html.twig', [
            'nombre_biblioteca' => $shownombre,
            'ntrabajadores' => $showntrabajadores,
            'direction' => $showdirection,
            'fecha' => $showfecha,
            'libros' => $query
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
        $shownombre = $biblioteca->getNombre();
        $showntrabajadores = $biblioteca->getNumTrabajadores();
        $showdirection = $biblioteca->getDireccion();
        $showfecha = $biblioteca->getFechaFundacion();
        if($formBiblioteca->isSubmitted() && $formBiblioteca->isValid()) {
            if (!$biblioteca) {
                throw $this->createNotFoundException(
                    'No existe la biblioteca '.$id
                );
            }
            $nombre = $formBiblioteca['nombre']->getData();
            $ntrabajadores = $formBiblioteca['num_trabajadores']->getData();
            $direction = $formBiblioteca['direccion']->getData();
            $fecha = $formBiblioteca['fecha_fundacion']->getData();           
            $biblioteca->setNombre($nombre);
            $biblioteca->setNumTrabajadores($ntrabajadores);
            $biblioteca->setDireccion($direction);
            $biblioteca->setFechaFundacion($fecha);
            $em->flush();
            $this->addFlash(type: 'exito', message: 'Se ha modificado la biblioteca exitoxamente');
            return $this->redirectToRoute('editar_biblioteca', [
                'id' => $biblioteca->getId()
            ]);
        }
        return $this->render('biblioteca/editarBiblioteca.html.twig', [
            'formularioeditarBiblioteca' =>$formBiblioteca->createView(),
            'nombre_biblioteca' => $shownombre,
            'ntrabajadores' => $showntrabajadores,
            'direction' => $showdirection,
            'fecha' => $showfecha
        ]);
        
    }
}
