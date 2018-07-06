<?php

namespace App\Controller;

use App\Form\UserType;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthController extends Controller
{
    /**
     * Register new user
     *
     * @Route("/register", name="user_registration")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // 1) build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        
        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // 4) Generate code activation
            $active_code = md5(random_bytes(10));
            $user->setActiveCode($active_code);

            // 5) save the User
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // 6) send Email to user with activate code
            $message = (new \Swift_Message('Hello Email'))
                ->setFrom('send@example.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                    // templates/emails/registration.html.twig
                        'emails/registration.html.twig',
                        ['active_code' => $active_code]
                    ),
                    'text/html'
                )
            ;
            $this->get('mailer')->send($message);
            
            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('tender_index');
        }

        return $this->render(
            'auth/register.html.twig',
            array('form' => $form->createView())
        );
    }
    
    /**
     * User login
     *
     * @Route("/login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastEmail = $authenticationUtils->getLastUsername();

        return $this->render('auth/login.html.twig', array(
            'last_email' => $lastEmail,
            'error' => $error,
        ));
    }

    /**
     * User activation
     *
     * @Route("/activeuser", name="activeuser")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function user_activate(Request $request)
    {
        $active_code = $request->get('active_code');
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository(User::class);
        $user = $repository->findOneBy(['activeCode' => $active_code]);

        if (!$user) {
            throw $this->createNotFoundException(
                'User not found'
            );
        }

        $user->setStatus(1);
        $entityManager->flush();

        return $this->redirectToRoute('login');
    }
}