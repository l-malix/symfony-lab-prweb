<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PersonRepository;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use App\Entity\Person as Person;
use App\Repository\BorrowRepository;
use App\Repository\BookRepository;
use App\Entity\Borrow;

class UsersController extends AbstractController
{
    // render user view with data
    #[Route('/user', name: 'user', methods: ['POST'])]
    public function index(PersonRepository $personRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'people' => $personRepository->findAll(),
        ]);
    }

    // Prevent direct access to users using GET
    #[Route('/user', name: 'user', methods: ['GET'])]
    public function users(): Response
    {
        return $this->redirectToRoute('index');
    }

    // Edit a user 
    #[Route('/editUser', name: 'editUser', methods: ['POST'])]
    public function editUser(Request $request, PersonRepository $personRepository, BorrowRepository $borrowRepository, BookRepository $bookRepository): Response
    {
        $idValue = $request->request->get('id');
        $person = $personRepository->find($idValue);
        $books = $bookRepository->findAll();
        $borrowed = $borrowRepository->findByUser($person);

        return $this->render('user/edit.html.twig', [
            'person' => $person,
            'books' => $books,
            'borrows' => $borrowed,
        ]);
    }

    // Saving a new or modified user
    #[Route('/saveUser', name: 'saveUser', methods: ['POST'])]
    public function saveUser(Request $request, PersonRepository $personRepository, PersistenceManagerRegistry $doctrine): Response
    {
        $idValue = $request->request->get('id');
        $firstName = $request->request->get('first-name');
        $lastName = $request->request->get('last-name');
        $dob = $request->request->get('dob');
        $dob_asDate = \DateTime::createFromFormat('d/m/Y', $dob);

        $manager = $doctrine->getManager();

        if ($idValue > 0) {
            $person = $personRepository->find($idValue);
        } else {
            $person = new Person();
            $manager->persist($person);
        }

        $person->setPersonFirstname($firstName);
        $person->setPersonLastname($lastName);
        $person->setPersonBirthdate($dob_asDate);

        $manager->flush();

        return $this->render('user/index.html.twig', [
            'people' => $personRepository->findAll(),
        ]);
    }

    // cancel edit user
    #[Route('/cancelEdit', name: 'cancelEdit', methods: ['POST'])]
    public function cancelEdit(PersonRepository $personRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'people' => $personRepository->findAll(),
        ]);
    }

    // add user into db
    #[Route('/addUser', name: 'addUser', methods: ['POST'])]
    public function addUser(BookRepository $bookRepository): Response
    {
        $person = new Person();
        $borrow = new Borrow();
        $books = $bookRepository->findAll();


        return $this->render('user/edit.html.twig', [
            'person' => $person,
            'borrows' => $borrow,
            'books' => $books,
        ]);
    }

    // Delete user
    #[Route('/delUser', name: 'delUser', methods: ['POST'])]
    public function delUser(Request $request, PersonRepository $personRepository, PersistenceManagerRegistry $doctrine): Response
    {

        $idValue = $request->request->get("id");
        $manager = $doctrine->getManager();
        $person = $personRepository->find($idValue);
        $manager->remove($person);
        $manager->flush();

        return $this->render('user/index.html.twig', [
            'people' => $personRepository->findAll(),
        ]);
    }

    #[Route('/tobook', name: 'tobook', methods: ['GET', 'POST'])]
    public function tobook(): Response
    {
        return $this->forward('App\Controller\BookController::index');
    }
}
