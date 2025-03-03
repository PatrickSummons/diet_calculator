<?php

namespace App\Controller;

use App\Entity\MealPlan;
use App\Form\MealPlanFormType;
use App\Repository\MealPlanRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MealPlanController extends AbstractController
{
    #[Route('/meal-plan', name: 'app_meal_plan')]
    public function index(MealPlanRepository $mealPlanRepository): Response
    {
        $user = $this->getUser();
        $mealPlan = $mealPlanRepository->findOneBy(['userId' => $user->getId()]);

        return $this->render('meal_plan/index.html.twig', [
            'mealPlan' => $mealPlan,
        ]);
    }

    #[Route('/meal-plan/edit', name: 'app_meal_plan_edit')]
    public function edit(Request $request, EntityManagerInterface $entityManager, MealPlanRepository $mealPlanRepository): Response
    {
        $user = $this->getUser();
        $mealPlan = $mealPlanRepository->findOneBy(['userId' => $user->getId()]) ?? new MealPlan();
        $mealPlan->setUserId($user->getId());

        $form = $this->createForm(MealPlanFormType::class, $mealPlan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($mealPlan);
            $entityManager->flush();

            return $this->redirectToRoute('app_meal_plan');
        }

        return $this->render('meal_plan/edit.html.twig', [
            'mealPlanForm' => $form->createView(),
        ]);
    }
}
