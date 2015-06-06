<?php

namespace Pesh\PortfolioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class PortfolioController extends Controller
{
    public function indexAction()
    {
        return $this->render('PeshPortfolioBundle:Portfolio:index.html.twig', array());
    }

    public function travauxAction()
    {
        return $this->render('PeshPortfolioBundle:Portfolio:travaux.html.twig', array());
    }

    public function competencesAction()
    {
        return $this->render('PeshPortfolioBundle:Portfolio:competences.html.twig', array());
    }

    public function veilleAction()
    {
        return $this->render('PeshPortfolioBundle:Portfolio:veille.html.twig', array());
    }

    public function contactAction()
    {
        return $this->render('PeshPortfolioBundle:Portfolio:contact.html.twig', array());
    }

    public function ajaxproxyAction($url)
    {
        $opts = array('http'=>array('header' => "User-Agent:ajaxproxy/1.0\r\n"));
        $context = stream_context_create($opts);

        $response = new Response(file_get_contents(urldecode($url), false, $context));
        $response->headers->set('Content-Type', 'text/xml');
        return $response;
    }
}
