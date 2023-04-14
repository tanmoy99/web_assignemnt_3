<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Weather</title>
</head>
<?php
$city = $_POST['city']??"";
$weather_data="";
if($city!="")
    {
        $json = file_get_contents('https://api.openweathermap.org/data/2.5/weather?q='.$city.'&appid=859c5991d0fde05d931f5bfb2fd82b6c');
        if($json===false)
            header('Location: ./index.php');
        $weather_data = json_decode($json, true)??"";
    }
if($weather_data!="")
{   
    $temperature = $weather_data['main']['temp'] - 273;
    $feels_like = $weather_data['main']['feels_like'] - 273;
    $humidity = $weather_data['main']['humidity'];
    $wind_speed = $weather_data['wind']['speed'];
    $wind_degree = $weather_data['wind']['deg'];
    $icon="http://openweathermap.org/img/w/".$weather_data['weather'][0]['icon'].".png";
    $type = $weather_data['weather'][0]['main'];}
    else{
         $temperature = "";
    $feels_like = "";
    $humidity = "";
    $wind_speed = "";
    $wind_degree = "";
    $icon= "";
    $type= "";
    }
?>
<body>
    <nav class="navbar navbar-expand bg-dark navbar-dark py-3">
        <div class="container">
            <a href="#current_weather" class="navbar-brand">Current Weather</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="#forecast" class="nav-link">Forecast</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <section class="text-light p-5 text-center" 
    style="z-index: 9999; 
    width: 100%; "
    height: 100%; 
    position: fixed; 
    left: 0; ">
        <div class="container">
            <form action="./index.php" method="post">
      <input type="text" placeholder="City Name" name="city">
      <button type="submit"><i class="fa fa-search"></i></button>
    </form>

    </div>
    </section>
    <?php 
            if($city!=""){
    echo
    '<section id="current_weather" class=" text-light p-5 text-center" 
    style="z-index: 9999; 
    width: 100%; "
    height: 100%; 
    position: fixed; 
    left: 0; ">
        <div class="container">
            <div class="d-flex bg-light align-items-center justify-content-between" 
            style="border-radius: 25px;
            padding: 20px;
            padding-left: 20%;
            width: 98%;">
                <div class="text-dark">
                    <div class="container">
                         <h1> City : '.strtoupper($city).'</h1>
                        <p>Temperature Now</p>
                         <h1 class=\"text-center\">'. $temperature.'°C</h1><br>
                         <p class=\"text-center\"> Feels Like : '. $feels_like.'°C</p><br>
                         <p class=\"text-center\"> humidity : '. $humidity.' %</p><br>
                         <p class=\"text-center\"> Wind Speed : '. $wind_speed.'MPH  </p>
                         <p class=\"text-center\"> Wind Degree : '. $wind_degree.'</p><br>
                    </div>
                </div> 
                <din class="px-5">     
                    <img class="img-fluid" src="'.$icon.'" alt="" style="width: 200px;">
                    <h1 class="text-dark">'.$type.'</h1>
                </din>      
            </div>
        </div>
    </section>';
    echo
   ' <section id="forecast" class=" text-dark p-5 text-center" 
    style="z-index: 9999; 
    width: 100%; "
    height: 100%; 
    position: fixed; 
    left: 0; ">
    <div class="text-center">
        <div class="container"><h1>5 Days Forecast</h1></div><br>
        <div class="container d-flex flex-row">';
            
                $json = file_get_contents('https://api.openweathermap.org/data/2.5/forecast?q='.$city.'&appid=859c5991d0fde05d931f5bfb2fd82b6c');
                $forecast_data = json_decode($json, true)??"";
                for ($x = 1; $x <=count($forecast_data['list']) ; $x+=8) {
                    $temperature = $forecast_data['list'][$x]['main']['temp'] - 273;
                    $feels_like = $forecast_data['list'][$x]['main']['feels_like'] - 273;
                    $humidity = $forecast_data['list'][$x]['main']['humidity'];
                    $wind_speed = $forecast_data['list'][$x]['wind']['speed'];
                    $icon="http://openweathermap.org/img/w/".$forecast_data['list'][$x]['weather'][0]['icon'].".png";
                    $type = $forecast_data['list'][$x]['weather'][0]['main'];
                    echo '<div class="card mx-2" style="width: 18rem;">
                        <div class="card-body">
                        <img class="img-fluid"src="'.$icon.'" alt="" style="width: 50px;">
                        <p class="card-text text-dark">'.$type.'</p>
                        <ul class="list-group">
                            <li class="list-group-item">Temperature '.$temperature.'°C <p class="text-secondary">('.$feels_like.'°C)</p></li>
                            <li class="list-group-item">Humidity '.$humidity.' %</li>
                            <li class="list-group-item">Wind Speed '.$wind_speed.' MPH</li>
                        </ul>
                        </div>
                        </div>';
                }
        echo '</div>
    </div>
    </section>';
        }
    ?>
</body>
<?php exit();?>
</html>