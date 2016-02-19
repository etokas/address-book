<?php

namespace bundle\FrontBundle\Controller;

use bundle\FrontBundle\Form\Handler\AddContactHandler;
use bundle\FrontBundle\Form\Type\AddContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FrontBundle::index.html.twig');
    }


    // Cet action permet juste de retourner tous les utilisateur present
    // dans la base de donnée.
    public function addContactAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $current = $this->getCurrentUser();

        //La gestion de mon formulaire se fait dans un fichier a part
        // bundle\FrontBundle\Form\Handler\AddContactHandler.php

        $form = new AddContactHandler($this->createForm(AddContactType::class), $request, $em);

        if($form->process($current)){

            $this->get('fos_user.user_manager')->updateUser($current);

            return $this->redirect($this->generateUrl('list_contact'));

        }

        return $this->render('FrontBundle:Pages:addcontact.html.twig', array('form' => $form->getForm()->createView()));
    }


    // cet action affiche la liste des contact de l'utilisateur connecté
    public function listContactAction()
    {
        $user = $this->getCurrentUser();

        $users = $user->getMembres();

        return $this->render('FrontBundle:Pages:listcontact.html.twig', array('users' => $users));
    }

    // Cet action permet de supprimer l'utilisateur selectionné
    public function deleteUserAction($id)
    {
        $curentuser = $this->getUser();

        $user = $this->findUserById($id);

        $curentuser->removeMembre($user);

        $this->get('fos_user.user_manager')->updateUser($user);

        return $this->redirect($this->generateUrl('list_contact'));
    }

    // On ne fait jamais de copié coller dans le code
    // c'et pour cela j'ai crée cette fonction qui me retourbe juste le user
    // avec l'id selectionné
    private function findUserById($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('FrontBundle:User')->find($id);

        return $user;
    }

    // Fonction qui permet de retourner l'utilsateur connecté
    private function getCurrentUser()
    {
        return $this->getUser();
    }

}
