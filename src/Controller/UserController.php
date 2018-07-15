<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AdminUserAdd;
use App\Helper\Translater;
use App\Traits\OrderableTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserController extends Controller
{
    use OrderableTrait;

    /**
     * Admin Panel : Show list of users
     *
     * @Route("/admin/user/list", name="adminUserList")
     */
    public function admin_user_list(Request $request)
    {
        /*Breadcrumbs*/
        Translater::setLocale($request->getLocale());
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem(Translater::show('Admin Panel'), $this->get("router")->generate("admin"));
        $breadcrumbs->addItem(Translater::show('List of users'), $this->get("router")->generate("adminUserList"));

        /*Set order by column*/
        $this->OrderByColumn($request);
        
        /*Get list of users*/
        $userRep = $this->getDoctrine()->getRepository(User::class);
        $users = $userRep->adminUserList($request);
        
        return $this->render('admin/user/list.html.twig', [
            'page_title' => Translater::show("List of users"),
            'active_menu' => 'adminUsers',
            'users' => $users
        ]);
    }

    /**
     * Admin Panel : Add new user
     *
     * @Route("/admin/user/add", name="adminUserAdd")
     */
    public function admin_user_add(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        /*Breadcrumbs*/
        Translater::setLocale($request->getLocale());
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem(Translater::show("Admin Panel"), $this->get("router")->generate("admin"));
        $breadcrumbs->addItem(Translater::show("Add user"), $this->get("router")->generate("adminUserAdd"));

        // 1) build the form
        $user = new User();
        $form = $this->createForm(AdminUserAdd::class, $user);

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

            // 7) send notification message
            $this->get('session')->set('actionResult', [
                'result'=>'success',
                'message' => Translater::show('Record has been created')
            ]);

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('adminUserList');
        }

        return $this->render('admin/user/show.html.twig', [
            'page_title' => Translater::show("User's info"),
            'active_menu' => 'adminUsers',
            'form' => $form->createView()
        ]);
    }
}
