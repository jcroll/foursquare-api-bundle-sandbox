<?php

namespace Application\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Jcroll\FoursquareApiBundle\Client\FoursquareClient;

class DefaultController extends Controller
{
    public function indexAction()
    {
        /** @var $client FoursquareClient */
        $client = $this->get('jcroll_foursquare_client');
        $command = $client->getCommand('GetVenuesCategories');
        ladybug_dump_die($command->execute());

        return $this->render('ApplicationDefaultBundle:Default:index.html.twig', array('name' => $name));
    }
}
