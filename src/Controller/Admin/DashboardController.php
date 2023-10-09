<?php
namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DashboardController extends AbstractController
{
/**
 * @Route("/admin", name="admin_dashboard")
 */
    public function dashboard(): Response
    {
        return new Response('test');
    }
}

