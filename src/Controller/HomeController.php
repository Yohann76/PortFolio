<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\ScopingHttpClient;

class HomeController extends AbstractController
{

    private $connection;
    /**
     * @var ContainerBagInterface
     */
    private $containerBag;

    public function __construct(ContainerBagInterface $containerBag)
    {
        $this->containerBag = $containerBag;
    }

    protected function checkConnection()
    {
        if($this->connection) {
            return $this->connection;
        }
        return $this->connect();
    }

    private function connect()
    {
        $this->connection = HttpClient::create();
        $this->connection = new ScopingHttpClient($this->connection, [
            'https://api.github.com' => [
                'headers' => [
                    'Accept' => 'application/vnd.github.v3+json',
                    'Authorization' => 'token '.$this->containerBag->get('GITHUB_TOKEN'),
                ],
            ]
        ]);
        return $this->connection;
    }

    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        // get Github Info
        $client = HttpClient::create();
        $response = $client->request('GET', 'https://github.com/Yohann76'); // view profil
        $content = $response->getContent(); // view profil content

        $content = preg_match('#[0-9][0-9][0-9][0-9]* contributions\n#', $content,$line); // echec, preg match after ","

        $commitsYears = trim(str_replace(' contributions','', $line[0]));

        $publicRepoResponse = $this->checkConnection()->request('GET', 'https://api.github.com/users/Yohann76')->toArray(); // info profil
        $publicRepo = $publicRepoResponse['public_repos'];
        $privateRepo =$publicRepoResponse['total_private_repos'];

        // end Github Info
        return $this->render('home/index.html.twig', [
            'commitsYears' => $commitsYears,
            'publicRepo' => $publicRepo,
            'privateRepo' => $privateRepo,
        ]);
    }
}
