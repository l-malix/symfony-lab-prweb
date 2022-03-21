<?php

namespace App\Controller;

use App\Repository\BookRepository;
use App\Repository\BorrowRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PersonRepository;
use App\Entity\Borrow;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

class BorrowController extends AbstractController
{
    #[Route('/borrow', name: 'app_borrow')]
    public function index(): Response
    {
        return $this->render('borrow/index.html.twig', [
            'controller_name' => 'BorrowController',
        ]);
    }

    #[Route('/addBorrowBook', name: 'addBorrowBook', methods: ["POST"])]
    public function addBorrowBook(Request $request, BorrowRepository $borrowRepository, PersonRepository $personRepository, BookRepository $bookRepository, PersistenceManagerRegistry $doctrine): Response
    {
        $userId = $request->request->get('userId');
        $bookId = $request->request->get('bookId');

        $person = $personRepository->find($userId);
        $book = $bookRepository->find($bookId);
        $manager = $doctrine->getManager();
        $borrow = new Borrow();
        $manager->persist($borrow);

        $manager = $doctrine->getManager();

        $borrowDate = new \DateTime('now');
        $borrowReturn = null;

        $borrow->setBorrowDate($borrowDate);
        $borrow->setBorrowReturn($borrowReturn);
        $borrow->setBook($book);
        $borrow->setPerson($person);

        $manager->flush();

        return $this->render('user/edit.html.twig', [
            'person' => $person,
            'borrows' => $borrowRepository->findByUser($person),
            'books' => $bookRepository->findAll(),
        ]);
    }

    #[route("/returnBorrow", name: "returnBorrow", methods: ["POST"])]
    public function returnBorrow(Request $request, PersonRepository $personRepository, PersistenceManagerRegistry $doctrine, BorrowRepository $borrowRepository): Response
    {
        $borrowId = $request->request->get('id');
        $borrowReturn = new \DateTime('now');
        $borrow = $borrowRepository->find($borrowId);

        $manager = $doctrine->getManager();
        $borrow->setBorrowReturn($borrowReturn);
        $manager->flush();

        $data = ['returnedValue' => $borrowReturn];

        return new JsonResponse($data);
    }
}
