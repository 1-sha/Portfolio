<?php

namespace Pesh\PortfolioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Pesh\PortfolioBundle\Form\Type\ContactType;

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
        $kernel = $this->get('kernel');
        $path = $kernel->locateResource('@PeshPortfolioBundle/Resources/public/etc/comp.xml');
        $comps = simplexml_load_file($path);
        return $this->render('PeshPortfolioBundle:Portfolio:competences.html.twig', array(
            'comps' => $comps));
    }

    public function veilleAction()
    {
        return $this->render('PeshPortfolioBundle:Portfolio:veille.html.twig', array());
    }

    public function contactAction(Request $request)
    {
        $form = $this->createForm(new ContactType());

        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                $message = \Swift_Message::newInstance()
                    ->setSubject($form->get('sujet')->getData())
                    ->setFrom($form->get('email')->getData())
                    ->setTo('contact.ybehlouli@gmail.com')
                    ->setBody(
                        $this->renderView(
                            'PeshPortfolioBundle:Mail:contact.html.twig',
                            array(
                                'ip' => $request->getClientIp(),
                                'nom' => $form->get('nom')->getData(),
                                'message' => $form->get('message')->getData()
                            )
                        )
                    );

                $this->get('mailer')->send($message);

                $request->getSession()->getFlashBag()->add('success', 'Your email has been sent! Thanks!');

                return $this->redirect($this->generateUrl('pesh_portfolio_contact'));
            }
        }

        return $this->render('PeshPortfolioBundle:Portfolio:contact.html.twig', array(
            'form' => $form->createView(),
        ));
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
