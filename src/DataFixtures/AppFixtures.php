<?php

namespace App\DataFixtures;

use App\Entity\Person;
use App\Entity\Book;
use App\Entity\Borrow;
use App\Repository\PersonRepository;
use App\Repository\BookRepository;
use App\Repository\BorrowRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $people = [
            ['Pierre', 'KIMOUS', '2000-02-04'],
            ['Jean-Yves', 'MARTIN', '1963-08-12'],
            ['Jean-Marie', 'NORMAND', '1991-04-16']
        ];
        foreach ($people as $index => $aPerson) {
            $aDate = \DateTime::createFromFormat('Y-m-d', $aPerson[2]);
            $person = new Person();
            $person->setPersonFirstname($aPerson[0]);
            $person->setPersonLastName($aPerson[1]);
            $person->setPersonBirthdate($aDate);
            $manager->persist($person);
            $people[$index][3] = $person;
        }

        $manager->flush();

        $books = [
            ['book 1', 'author 1'],
            ['book 2', 'author 2'],
            ['book 3', 'author 3'],
            ['book 4', 'author 4']
        ];
        foreach ($books as $index => $aBook) {
            $book = new Book();
            $book->setBookTitle($aBook[0]);
            $book->setBookAuthors($aBook[1]);
            $manager->persist($book);
            $books[$index][2] = $book;
        }
        $manager->flush();


        $borrows = [
            [2, 4, '2021-07-15', '2021-09-01'],
            [1, 2, '2021-08-01', NULL],
            [3, 3, '2021-10-01', NULL],
            [2, 1, '2021-10-02', NULL]
        ];
        foreach ($borrows as $index => $aBorrow) {
            $borrow = new Borrow();
            $borrow->setPerson($people[$aBorrow[0] - 1][3]);
            $borrow->setBook($books[$aBorrow[1] - 1][2]);
            $aDate = \DateTime::createFromFormat('Y-m-d', $aBorrow[2]);
            $borrow->setBorrowDate($aDate);
            if ($aBorrow[3] != NULL) {
                $aDate = \DateTime::createFromFormat('Y-m-d', $aBorrow[3]);
                $borrow->setBorrowReturn($aDate);
            }
            $manager->persist($borrow);
        }

        $manager->flush();
    }
}
