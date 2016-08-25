<?php

namespace Application\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Jcroll\FoursquareApiClient\Client\FoursquareClient;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    public function indexAction($endpoint, $modifier)
    {
        $aggregatedEndpoint = $modifier ? sprintf('%s/%s', $endpoint, $modifier) : $endpoint;

        /** @var $client FoursquareClient */
        $client = $this->get('jcroll_foursquare_client');
        $command = $client->getCommand($aggregatedEndpoint, $this->getRequest()->query->all());
        $results = $command->execute();

        return new JsonResponse($results);
    }
}
