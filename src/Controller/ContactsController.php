<?php

namespace App\Controller;

use App\Entity\Contacts;
use App\Form\ContactsType;
use App\Repository\ContactsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactsController extends AbstractController
{
    #[Route('/contacts', name: 'contacts.index', methods: ['GET'])]
    public function index(
        ContactsRepository $repository, PaginatorInterface $paginator, Request $request
    ): Response
    {

        $contacts = $paginator->paginate(
            $repository->findAll(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('pages/contacts/index.html.twig', [
            'contacts' => $contacts,
        ]);
    }

    #[Route('/contacts/create', name: 'contacts.new', methods:['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {

        $contact = new Contacts();
        $form = $this->createForm(ContactsType::class, $contact);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $contact = $form->getData();

            // dd($contact, 'uu');

            $manager->persist($contact);
            $manager->flush();

            $this->addFlash(
                'success',
                "ce contact a été crée avec success"
            );

            return $this->redirectToRoute('contacts.index');
        }
        else if($form->isSubmitted() && !$form->isValid()) {
            $errors = $form->getErrors(true, false);
            // dd($errors);
            // Renvoyer les erreurs à la vue...
            return $this->render('pages/contacts/new.html.twig', [
                'form' => $form->createView(),
                'errors' => $errors,
            ]);
        }

        // dd($contact, $form->isValid());
       
        return $this->render('pages/contacts/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/contacts/edit/{id}', name: 'contacts.edit', methods:['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $manager, Contacts $contact): Response
    {

        $form = $this->createForm(ContactsType::class, $contact);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $contact = $form->getData();

            $manager->persist($contact);
            $manager->flush();

            $this->addFlash(
                'success',
                "ce contact a été modifié avec success"
            );

            return $this->redirectToRoute('contacts.index');
        }
       
        return $this->render('pages/contacts/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/contacts/delete/{id}', name: 'contacts.delete', methods:['GET'])]
    public function delete(EntityManagerInterface $manager, Contacts $contact): Response
    {

        if(!$contact){
            $this->addFlash(
                'success',
                "ce contact n'a pas été trouve"
            );
        };

        $manager->remove($contact);
        $manager->flush();
       
        return $this->render('pages/contacts/index.html.twig');
    }
}
