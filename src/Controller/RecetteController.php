<?php
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RecetteRepository;

class RecetteController extends AbstractController
{

    /**
     * @Route("/recette/{id}", name="recette_show")
     */
    public function show(int $id, RecetteRepository $recetteRepository)
    {
        $recette = $recetteRepository->find($id);

        return $this->render('recette/show.html.twig', [
            'recette' => $recette,
            'menu' => 'recette'
        ]);

    }




}

?>