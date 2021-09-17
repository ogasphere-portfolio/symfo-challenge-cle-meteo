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
        $widget = $session->get('last_weather');

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
         
        
        if (false === $weather) {
            // ajouter un flash message
            // ou afficher une 404
            $this->addFlash('danger','City unavailable!');
        }
        else 
        {
            // mettre les informations en session
             // on ajoute la meteo en session
             $session->set('last_weather', $weather);
        }
      
             // redirection
        return $this->redirectToRoute('home');
            
           
        
    }
      /**
     * @Route("/plage", name="beach")
     */
    public function beach(SessionInterface $session): Response
    {
       
        return $this->render('weather/beach.html.twig', [
         
        ]);
    }

    /**
     * @Route("/montagne", name="mountain")
     */
    public function mountain(SessionInterface $session): Response
    {
        
        return $this->render('weather/mountain.html.twig', [
            
        ]);
    }
}
