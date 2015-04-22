<?php

namespace Pesh\PortfolioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PortfolioController extends Controller
{
    public function indexAction()
    {
        return $this->render('PeshPortfolioBundle:Portfolio:index.html.twig', array());
    }

    public function aboutAction()
    {
        return $this->render('PeshPortfolioBundle:Portfolio:about.html.twig', array());
    }

    public function cvAction()
    {
        return $this->render('PeshPortfolioBundle:Portfolio:cv.html.twig', array());
    }

    public function veilleAction()
    {
        return $this->render('PeshPortfolioBundle:Portfolio:veille.html.twig', array());
    }

    public function contactAction()
    {
        return $this->render('PeshPortfolioBundle:Portfolio:contact.html.twig', array());
    }
}
