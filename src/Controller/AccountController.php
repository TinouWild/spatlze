<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController
{
    /**
     * @Route("/account", name="account")
     */
    public function index()
    {
        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
        ]);
    }

    /**
     * @Route("/login", name="account_login")
     * @return Response
     */
    public function login(AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();
        return $this->render('account/login.html.twig',[
            'hasError' => $error !== null,
            'username' => $username
        ]);
    }

    /**
     * @Route("/logout", name="account_logout")
     *
     */
    public function logout()
    {

    }

    /**
     * @Route("/register", name="account_register")
     * @return Response
     */
    public function register(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getHash());
            $user->setHash($hash);

//            $guestExist = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email'=>$guest->getEmail()]);
//            if (is_null($guestExist)) {
//                $guest->getEvents($event);
//                $manager->persist($guest);
//            } else {
//                $guestExist->getEvents($event);
//                $event->removeGuest($guest);
//                $event->addGuest($guestExist);
//                $manager->persist($guestExist);
//            }

            $manager->persist($user);
            $manager->flush();

//            $message = (new \Swift_Message('Registration on TaskPlanner'))
//                ->setFrom('tinouclt@gmail.com')
//                ->setTo($user->getEmail())
//                ->setBody(
//                    '<html>' .
//                    ' <body>' .
//                    '  Congratulations, you are now register on TaskPlanner !' .
//                    'You can now access to your account' . ' ' . $user->getFullName().
//                    ' </body>' .
//                    '</html>'
//                );
//            $mailer->send($message);

            $this->addFlash(
                'success',
                "Votre inscription a bien été prise en compte !"
            );

            return $this->redirectToRoute('home_accueil');
        }

        return $this->render('account/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
