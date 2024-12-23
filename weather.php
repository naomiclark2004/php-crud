<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather</title>
    <?php
    include("./style/styles.php");
    ?>
</head>

<body>
    <!-- Nav -->
    <?php

    include('view/menu.php');
    include('database.php');
    $db = new DB();

    $menu = new Menu($db);
    $menu->showMenu();
    ?>

    <!-- Header -->
    <?php
    $title = "Weather";
    include('view/header.php');
    $header = new Header($title);
    $header->showHeader();
    ?>

    <!-- Main Content -->
    <?php
    $queryUrl = 'https://api.worldweatheronline.com/premium/v1/weather.ashx?q=phoenix,arizona&num_of_days=7&key=1f238c8c45cf4f2a89d31808240305&tp=24&format=json';

    $options = array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array('Content-type: application/json'),
        CURLOPT_URL => $queryUrl
    );

    // Setting curl options
    $curl = curl_init();
    curl_setopt_array($curl, $options);

    if (!$result = curl_exec($curl)) {
        die('Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
    }
    curl_close($curl);

    $response = json_decode($result, true);

    foreach ($response['data']['current_condition'] as $current) {
        $img = $current['weatherIconUrl'][0]['value'];
        $temp = $current['temp_F'];
        $wind_speed = $current['windspeedMiles'];
        $feels_like = $current['FeelsLikeF'];
        $wind_degree = $current['winddirDegree'];
        $weather_desc = $current['weatherDesc'][0]['value'];

        echo "<section>";
        echo "<div class='card'>";
        echo "<img src='" . $img . "' width='100px'>";
        echo "<h1>" . $weather_desc . "</h1>";
        echo "<h1>Current Temp: " . $temp . "F</h1>";
        echo "<p>Feels Like: " . $feels_like . "F</p>";
        echo "<p>Wind Speed: " . $wind_speed . " Miles Per Hour</p>";
        echo "<p>Wind Degree: " . $wind_degree . " Degrees</p>";
        echo "</div>";
        echo "</section>";
    }
    ?>

    <!-- Footer -->
    <?php
    include('view/footer.php')
    ?>
</body>

</html>