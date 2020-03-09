<?php

namespace App\Controller;

use App\Entity\ServiceEntity;
use App\Form\Type\RamseyUuidType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ValidationTestController extends AbstractController
{
    /**
     * @Route("/validate/test")
     */
    public function validateTest(Request $request)
    {
        $service = new ServiceEntity();

        $form = $this->createFormBuilder($service)
            ->add('id', RamseyUuidType::class)
            ->add('name', TextType::class)
            ->add('alias', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Service'])
            ->getForm();

        $form->handleRequest($request);

        return $this->render('service.html.twig', [
            'form' => $form->createView(),
        ]);

    }


}
