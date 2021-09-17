<?php

namespace App\Controller;


use App\entity\WeatherModel;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WeatherController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function list(SessionInterface $session,WeatherModel $WeatherModel ) : Response
    {
       
        $weathers = $WeatherModel->getWeatherData();
       
        return $this->render('weather/home.html.twig', [
            'weathers' => $weathers ,
        ]);
    }
}
