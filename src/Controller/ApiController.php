<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    #[Route('/api', name: 'api', methods: ['GET'])]
    public function api(Request $request): Response
    {
        $fromdate = '';
        $todate = '';

        if (!$request->query->has('tagged') || empty($request->query->get('tagged'))) {
            return $this->json(['tagged' => 'El parametro es obligatorio, puede usar hasta 5 separados por ; ejemplo: tagged=php;symfony']);
        }

        if ($request->query->has('fromdate')) {
            $fromdate = $request->query->get('fromdate');
            if (\DateTime::createFromFormat('Y-m-d', $fromdate) == false && !is_numeric($fromdate)) {
                return $this->json(['fromdate' => 'formato invalido. Los formatos aceptados son fecha YYYY-MM-DD y UNIX timestamp']);
            }
        }

        if ($request->query->has('todate')) {
            $todate = $request->query->get('todate');
            if (\DateTime::createFromFormat('Y-m-d', $todate) == false && !is_numeric($todate)) {
                return $this->json(['todate' => 'formato invalido. Los formatos aceptados son fecha YYYY-MM-DD y UNIX timestamp']);
            }
        }

        $response = $this->client->request('GET', 'https://api.stackexchange.com/2.2/questions', [
            'query' => [
                'site' => 'stackoverflow',
                'tagged' => $request->query->get('tagged'),
                'fromdate' => $fromdate,
                'todate' => $todate
            ]
        ]);

        return $this->json($response->toArray());
    }
}
