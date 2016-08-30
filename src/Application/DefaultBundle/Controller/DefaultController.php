<?php

namespace Application\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Jcroll\FoursquareApiClient\Client\FoursquareClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $contents = file_get_contents(
            sprintf('%s/../vendor/jcroll/foursquare-api-client/src/Resources/config/client.json',
                $this->getParameter('kernel.root_dir')
            )
        );

        $operations = array_keys(json_decode($contents, true)['operations']);

        $endpoints = [];

        foreach ($operations as $operation) {
            if (strpos($operation, '/')) {
                list ($endpoint, $modifier) = explode('/', $operation);
            } else {
                $endpoint = $operation;
                $modifier = null;
            }

            $endpoints[$operation] = ['endpoint' => $endpoint, 'modifier' => $modifier];
        }

        ksort($endpoints);

        return $this->render('default/index.html.twig', [
            'base_dir'  => $this->getBaseDir(),
            'endpoints' => $endpoints,
        ]);
    }

    public function queryAction(Request $request, $endpoint, $modifier = null)
    {
        $aggregatedEndpoint = $modifier ? sprintf('%s/%s', $endpoint, $modifier) : $endpoint;

        /** @var $client FoursquareClient */
        $client   = $this->get('jcroll_foursquare_client');
        $command  = $client->getCommand($aggregatedEndpoint, $request->query->all());
        $response = $client->execute($command);

        return $this->render('default/query.html.twig', [
            'base_dir'  => $this->getBaseDir(),
            'response'  => json_encode($response, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES),
        ]);
    }

    /**
     * @return string
     */
    private function getBaseDir()
    {
        return realpath($this->getParameter('kernel.root_dir').'/..');
    }
}
