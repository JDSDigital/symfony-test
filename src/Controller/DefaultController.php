<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Calc;
use App\Form\CalcType;

class DefaultController extends AbstractController
{
    /**
     * @Route("/default", name="default")
     */
    public function index(Request $request): Response
    {
        $calc = new Calc();
        $number = 0;
        $calcForm = $this->createForm(CalcType::class, $calc);
        $calcForm->handleRequest($request);

        if ($calcForm->isSubmitted() && $calcForm->isValid()) {

            $data = $calcForm->getData();
            $number = $data->guessNumber();
        }

        return $this->render('default/index.html.twig', [
            'calc_form' => $calcForm->createView(),
            'number' => $number
        ]);
    }
}
