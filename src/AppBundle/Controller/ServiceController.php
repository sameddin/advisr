<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Service;
use AppBundle\Form\Type\ServiceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/services")
 */
class ServiceController extends Controller
{
    /**
     * @Route(name="service.list")
     * @Template
     *
     * @param Request $request
     * @return array
     */
    public function listAction(Request $request)
    {
        $services = $this->getDoctrine()
            ->getRepository('AppBundle:Service')
            ->findAll();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $services,
            $request->query->getInt('page', 1),
            10
        );

        return [
            'services' => $services,
            'pagination' => $pagination,
        ];
    }

    /**
     * @Route("/add", name="service.add")
     * @Template
     *
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function addAction(Request $request)
    {
        $service = new Service();
        $form = $this->createForm(new ServiceType(), $service);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($service);
            $em->flush();

            return $this->redirectToRoute('service.list');
        }

        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/edit/{id}", name="service.edit")
     * @Template
     *
     * @param Request $request
     * @param Service $service
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Service $service) {

        $form = $this->createForm(new ServiceType(), $service);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($service);
            $em->flush();

            return $this->redirectToRoute('service.list');
        }

        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/delete/{id}", name="service.delete")
     *
     * @param Service $service
     * @return RedirectResponse|Response
     */
    public function deleteAction(Service $service)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($service);
        $em->flush();

        return $this->redirectToRoute('service.list');

    }
}
