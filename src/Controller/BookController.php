<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use App\Entity\Book;

class BookController extends AbstractController
{
    #[Route('/book', name: 'book', methods: ['POST'])]
    public function index(BookRepository $bookRepository): Response
    {
        return $this->render('book/index.html.twig', [
            'books' => $bookRepository->findAll(),
        ]);
    }

    #[Route('/book', name: 'book', methods: ['GET'])]
    public function book(): Response
    {
        return $this->redirectToRoute('index');
    }

    // Edit a book
    #[Route('/editBook', name: 'editBook', methods: ['POST'])]
    public function editBook(Request $request, BookRepository $bookRepository): Response
    {
        $idValue = $request->request->get('id');
        $book = $bookRepository->find($idValue);

        return $this->render('book/edit.html.twig', [
            'book' => $book,
        ]);
    }

    // Save a book
    #[Route('/saveBook', name: 'saveBook', methods: ['POST'])]
    public function saveBook(Request $request, BookRepository $bookRepository, PersistenceManagerRegistry $doctrine): Response
    {
        $idValue = $request->request->get('id');
        $title = $request->request->get('title');
        $authors = $request->request->get('authors');

        $manager = $doctrine->getManager();

        if ($idValue > 0) {
            $book = $bookRepository->find($idValue);
        } else {
            $book = new Book();
            $manager->persist($book);
        }

        $book->setBookTitle($title);
        $book->setBookAuthors($authors);

        $manager->flush();

        return $this->render('book/index.html.twig', [
            'books' => $bookRepository->findAll(),
        ]);
    }

    // cancel edit book
    #[Route('/cancelEditBook', name: 'cancelEditBook', methods: ['POST'])]
    public function cancelEdit(BookRepository $bookRepository): Response
    {
        return $this->render('book/index.html.twig', [
            'books' => $bookRepository->findAll(),
        ]);
    }

    // add book into db
    #[Route('/addBook', name: 'addBook', methods: ['POST'])]
    public function addBook(Request $request, BookRepository $personRepository): Response
    {
        $book = new Book();

        return $this->render('book/edit.html.twig', [
            'book' => $book,
        ]);
    }

    // Delete book
    #[Route('/delBook', name: 'delBook', methods: ['POST'])]
    public function delBook(Request $request, BookRepository $bookRepository, PersistenceManagerRegistry $doctrine): Response
    {

        $idValue = $request->request->get("id");
        $manager = $doctrine->getManager();
        $book = $bookRepository->find($idValue);
        $manager->remove($book);
        $manager->flush();

        return $this->render('book/index.html.twig', [
            'books' => $bookRepository->findAll(),
        ]);
    }

    #[Route('/toUser', name: 'toUser', methods: ['GET', 'POST'])]
    public function toUser(): Response
    {
        return $this->forward('App\Controller\UsersController::index');
    }
}
