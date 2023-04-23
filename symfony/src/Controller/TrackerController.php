<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TrackerController extends AbstractController
{
    #[Route('/')]
    public function home(): Response
    {
        return $this->render('tracker/index.html.twig', []);
    }
}