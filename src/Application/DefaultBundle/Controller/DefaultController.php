<?php

namespace Application\DefaultBundle\Controller;

use Jcroll\FoursquareApiBundle\JcrollFoursquareApiBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Jcroll\FoursquareApiBundle\Client\FoursquareClient;

class DefaultController extends Controller
{
    public function indexAction($endpoint, $modifier)
    {
        if ($modifier) {
            $aggregatedEndpoint = $endpoint.'/'.$modifier;
        } else {
            $aggregatedEndpoint = $endpoint;
        }

        /** @var $client FoursquareClient */
        $client = $this->get('jcroll_foursquare_client');
        $command = $client->getCommand($aggregatedEndpoint, $this->getRequest()->query->all());
        $results = $command->execute();

        return $this->render('ApplicationDefaultBundle:Default:index.html.twig', array(
            'endpoint' => $endpoint,
            'modifier' => $modifier,
            'results' => $results
        ));
    }
}
