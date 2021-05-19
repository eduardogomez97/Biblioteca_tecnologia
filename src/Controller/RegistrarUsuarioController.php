<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrarUsuarioController extends AbstractController
{
    #[Route('/registrar_usuario', name: 'registrar_usuario')]
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $formUsuario = $this->createForm(UserType::class, $user);
        $formUsuario->handleRequest($request);
        if($formUsuario->isSubmitted() && $formUsuario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user->setPassword($passwordEncoder->encodePassword($user, $formUsuario['password']->getData()));
            $em->persist($user);
            $em->flush();
            $this->addFlash(type: 'exito', message: User::REGISTRO_EXITOSO);
            return $this->redirectToRoute( route: 'registrar_usuario');
        }
        return $this->render('registrar_usuario/index.html.twig', [
            'controller_name' => 'RegistrarUsuarioController',
            'formularioUsuario' =>$formUsuario->createView()
        ]);
    }
}
