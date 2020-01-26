<?php


namespace App\Controller;

use App\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class BooksController extends Controller
{
    public function books(){
        $books= $this->getDoctrine()->getRepository(Book::class)->findAll();

        return $this->render('books/index.html.twig', array('books' => $books));
    }

    public function new(Request $request) {
        $book = new Book();

        $form = $this->createFormBuilder($book)
            ->add('name', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('author', TextType::class, array(
                'attr' => array('class' => 'form-control')
            ))
            ->add('year', DateType::class, array('attr' => array('class' => 'form-control'),
                'widget' => 'single_text',
                'format' => 'yyyy'
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Создать',
                'attr' => array('class' => 'btn btn-primary mt-3')
            ))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $book = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('index');
        }

        return $this->render('books/new.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function edit(Request $request, $id) {
        $book = new Book();
        $book = $this->getDoctrine()->getRepository(Book::class)->find($id);

        $form = $this->createFormBuilder($book)
            ->add('name', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('author', TextType::class, array(
                'attr' => array('class' => 'form-control')
            ))
            ->add('year', DateType::class, array('attr' => array('class' => 'form-control'),
                'widget' => 'single_text',
                'format' => 'yyyy'
                ))
            ->add('save', SubmitType::class, array(
                'label' => 'Сохранить',
                'attr' => array('class' => 'btn btn-primary mt-3')
            ))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('index');
        }

        return $this->render('books/edit.html.twig', array(
            'form' => $form->createView()
        ));
    }
}