<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AuthorController extends AbstractController
{
    private $authors;
    public function __construct()
    {
        $this->authors = [
            ['id' => 1, 'picture' => '/images/Victor-Hugo.jpeg', 'username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com', 'nb_books' => 100],
            ['id' => 2, 'picture' => '/images/william-shakespeare.jpeg', 'username' => 'William Shakespeare', 'email' => 'william.shakespeare@gmail.com', 'nb_books' => 200],
            ['id' => 3, 'picture' => '/images/Taha-Hussein.jpg', 'username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300],
        ];
        
    }
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }


    #[Route('/auteur/{name}', name: 'show_author' , defaults:['name'=>'citron'],methods:['GET'])]
public function showAuthor(string $name): Response
{
    return $this->render('author/autherrrr.html.twig', [
        'name' => $name,]);
}

#[Route('/author/{id}', name: 'author_details', methods: ['GET'])]

#[Route('/listauthor', name: 'listauthor' , methods:['GET'])]
public function listAuthors(): Response
{
    return $this->render('author/listAuthor.html.twig', [
        'authors' => $this->authors,
    ]);
}

    #[Route('/author/{id}', name: 'author_details', methods: ['GET'])]
    public function authorDetails(int $id): Response
    {
        $author = null;
        foreach ($this->authors as $a) {
            if ($a['id'] === $id) {
                $author = $a;
                break;
            }
        }
    
        if (!$author) {
            throw $this->createNotFoundException('Auteur non trouvé');
        }
    
        return $this->render('author/showAuthor.html.twig', [
            'author' => $author,
        ]);
    }   

}