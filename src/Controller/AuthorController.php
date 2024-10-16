<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Author;
use App\Form\AuthorType;

#[Route('/author')]
class AuthorController extends AbstractController
{
    // Propriété de la classe pour stocker l'instance de AuthorRepository
    private $authorRepo;
    private $entityManager;
    
   
 

    // Constructeur qui prend une instance de AuthorRepository
    public function __construct(AuthorRepository $authorRepositoryParam,EntityManagerInterface $entityManagerParam)
    {
        // Assignation de l'instance à la propriété
        $this->authorRepo = $authorRepositoryParam; 
        $this->entityManager=$entityManagerParam;
       

     
}

    #[Route('/author', name: 'app_author', methods:['GET'])]
    public function index(): Response
    {
        return $this->render('author/index.html.twig');
    }

    #[Route('/showAuthor/{name}', name: 'app_showAuthor', defaults:['name'=>'victor hugo'], methods:['GET'])]
    public function showAuthor($name): Response
    {
        return $this->render('author/showAuthor.html.twig', [
            'name' => $name
        ]);
    }

    #[Route('/authorList', name: 'app_authorList', methods:['GET'])]
    public function AuthorList(): Response
    {
        // Récupérer la liste des auteurs
        $authors = $this->authorRepo->findAllAuthors(); 

        // Rendre la vue avec la liste des auteurs
        return $this->render('author/listAuthor.html.twig', [
            'authors' => $authors,
        ]);
    }

    #[Route('/author/details/{id}', name: 'author_details', methods: ['GET'])]
    public function authorDetails(int $id): Response
    {
        // Récupérer l'auteur en fonction de l'ID en utilisant le repository
        $author = $this->authorRepo->findAuthorById($id); 

        // Rendre la vue avec les détails de l'auteur
        return $this->render('author/details.html.twig', [
            'author' => $author,
        ]);
    }

    #[Route('/addAuthor', name: 'addAuthor', methods: ['GET'])]
    public function addAuthor(): Response{
         $author=new Author();
        $author->setUsername('Mohamed');
        $author->setEmail('Mohamed@esprit.tn');
        $author->setPicture('Mohamed.png');
        $author->setNb_Books(453);
        $this->entityManager->persist($author);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_authorList');

    }

    #[Route('/deleteAuthor/{id}', name: 'deleteAuthor', methods: ['GET','DELETE'])]
    public function deleteAuthor(Author $author):Response{
        if($author){
        // $author=$this->authorRepo->findAuthorById($id);
        $this->entityManager->remove($author);
        $this->entityManager->flush();
        }
        return $this->redirectToRoute('app_authorList');

    }

    
    
    #[Route('/{id}/edit', name: 'author_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Author $author): Response
    {
        // Create a form for editing the author (assuming you have a form type created)
        $form = $this->createForm(AuthorType::class, $author);

        // Handle the request
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Update the author entity
            $this->entityManager->persist($author);
            $this->entityManager->flush();

            // Redirect to the author list or details page after successful update
            return $this->redirectToRoute('app_authorList');
        }

        return $this->render('author/edit.html.twig', [
            'form' => $form->createView(),
            'author' => $author,
        ]);
    }
    #[Route('/addAuthor', name: 'add_author', methods: ['GET', 'POST'])]
public function AddAuthor1(Request $request): Response
{
    $author = new Author();
    $form = $this->createForm(AuthorType::class, $author);

    // Handle the form submission
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $this->entityManager->persist($author);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_authorList'); // Redirige vers la liste des auteurs
    }

    return $this->render('author/addAuthor.html.twig', [
        'form' => $form->createView(),
    ]);
}

}