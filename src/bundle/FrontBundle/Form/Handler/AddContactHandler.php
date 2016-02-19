<?php

namespace bundle\FrontBundle\Form\Handler;


use bundle\FrontBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;


class AddContactHandler
{
    protected $form;
    protected $request;
    protected $em;

    public function __construct(Form $form, Request $request, EntityManager $em)
    {
        $this->form = $form;
        $this->request = $request;
        $this->em = $em;

    }


    public function process(User $user)
    {
        $this->form->handleRequest($this->request);

        if ($this->request->isMethod('post') && $this->form->isValid())
        {
            $this->onSuccess($user);

            return true;
        }

        return false;

    }


    public function onSuccess(User $user)
    {
        $contact = $this->form->getData();
        $contact->setEnabled(true);

        $user->addMembre($contact);
        $this->em->persist($contact);
        $this->em->flush();
    }

    /**
     * @return Form
     */
    public function getForm()
    {
        return $this->form;
    }

}