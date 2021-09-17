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


    /**
     * @route("/weather/{id}", name="weather_widget", methods={"GET","HEAD"}, requirements={"id"="\d+"})"
     * @param  mixed $id
     * @return void
     */
    public function show($id, SessionInterface $session, WeatherModel $WeatherModel) 
    {
        
        $weather = $WeatherModel->getWeatherByCityIndex($id);
        $weathers = $WeatherModel->getWeatherData();
         
        if ($weather === null) {
            // affiche une page 404 avec le message d'erreur fournit en argument
            throw $this->createNotFoundException('The oisal does not exist'); 
          
        }
            // on ajoute la meteo en session
            $session->set('last_weather', $weather);

            $widget = $session->get('last_weather');
           
            return $this->render('weather/home.html.twig', [
                'weathers' => $weathers ,
                'widget' => $widget,
            ]);
            
           
        
    }
      /**
     * @Route("/plage", name="beach")
     */
    public function beach(SessionInterface $session): Response
    {
        $widget = $session->get('last_weather');
        return $this->render('weather/beach.html.twig', [
            'widget' => $widget,
        ]);
    }

    /**
     * @Route("/montagne", name="mountain")
     */
    public function mountain(SessionInterface $session): Response
    {
        $widget = $session->get('last_weather');
        return $this->render('weather/mountain.html.twig', [
            'widget' => $widget,
        ]);
    }
}
