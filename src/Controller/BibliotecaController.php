<?php

namespace App\Controller;

use App\Entity\Biblioteca;
use App\Form\EditarBibliotecaType;
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
    public function VerBiblioteca($id, Request $request ): Response {
        $em = $this->getDoctrine()->getManager();
        $biblioteca = $em->getRepository(Biblioteca::class)->find($id);
        return $this->render('biblioteca/verBiblioteca.html.twig', [
            'pagination' => $biblioteca
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
        //foreach ($biblioteca as $biblioteca) {
            //$em->remove($biblioteca);
        //}
        $em->flush();
        return $this->redirectToRoute( route: 'home');

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
        $nombre = $biblioteca->getNombre();
        if($formBiblioteca->isSubmitted() && $formBiblioteca->isValid()) {
            if (!$biblioteca) {
                throw $this->createNotFoundException(
                    'No existe la biblioteca '.$id
                );
            }
            $nombre = $biblioteca->getNombre();
            $ntrabajadores = $biblioteca->getNumTrabajadores();
            $direction = $biblioteca->getDireccion();
            $fecha = $biblioteca->getFechaFundacion();
            $biblioteca->setNombre($nombre);
            $biblioteca->setNumTrabajadores($ntrabajadores);
            $biblioteca->setDireccion($direction);
            $biblioteca->setFechaFundacion($fecha);
            $em->flush();
            return $this->redirectToRoute('editar_biblioteca', [
                'id' => $biblioteca->getId()
            ]);
        }
        return $this->render('biblioteca/editarBiblioteca.html.twig', [
            'formularioeditarBiblioteca' =>$formBiblioteca->createView(),
            'nombre_biblioteca' => $nombre
            //'ntrabajadores' =>  $ntrabajadores,
            //'direction' => $direction,
            //'fecha' => $fecha

        ]);
        
    }
}
