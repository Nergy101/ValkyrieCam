<!DOCTYPE html

<html>

<head>
  <meta charset="utf-8">
  <title>Index</title>
  <link rel="stylesheet" type="text/css" href="style.css"> <!-- import style.css file -->
</head>
<body>
  <h1 align="center" style="font-size:10vw">Footage</h1>

  <div align = "center" id="result">test</div>

  <p align ="center">

    <textarea rows="4" cols="50" id="Location" readonly>

    </textarea>

  </p>

  <p align="center" > <img src="screen.jpg" id="myImage" /> </p> <!-- Image box -->

  <p align="center" ><a href="screen.jpg" download="foto.jpg">Manual Download</a></p> <!-- Manual download link -->


  <!-- De download locatie vd Raspberry moet vervangen worden door de "project/images" map -->
  <p align="center"><a  href="images" target="_blank">Click here to view "images" Folder</a></p> <!-- Go to images directory -->
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"> // import google Jquery library</script>

<script>
// https://github.com/Nergy101/ValkyrieCam
var a = $("<a>").attr("href", "screen.jpg").attr("download", "images/foto.png").appendTo("body");
//a.remove(); // remove downloading link

// function below does the refresh+download imgs

setInterval(function() {
  var ping = new Date;
  console.log("Ping send");
  $.ajax({ type: "POST",
      url: "https://pcvalkyrie.herokuapp.com/",
      data: {Ping: "ping"},
      cache:false,
      success: function(output){

          ping = new Date - ping;

      }
  });
}, 300000); // 300000 = 5 minutes



// setInterval(function() {
//   var myImageElement = $('#myImage');
//   myImageElement.src = 'screen.jpg?rand=' + Math.random(); // make sure the browser takes the new image
//   a[0].click(); // do the download link
// }, 5000); // 5 seconds (5000ms)

function startup(){
  $.get( "https://api.openweathermap.org/data/2.5/forecast?id=2745912&APPID=3e7479392874b48638d0847329f31fad", function( data ) {
    console.log("test");
    if(data == "") throw "No data loaded";

    //var gradenC = Math.round( (data.list[0].main.temp -272.15) * 100) / 100
    //$("#messageBox").text( "Data Loaded Succesfully");
    $("#Location").val("Date and Time: "+ data.list[0].dt_txt +'\n'+
      "Location Loaded: " + data.city.name +', '+data.city.country+
      '\nWeather: '+data.list[0].weather[0].description+
      ', '+ gradenC+'°C'+
       "\nWind speed: " + data.list[0].wind.speed+
     '\nLat: '+data.city.coord.lat+' Lon: '+data.city.coord.lon);
  });
}

$( document ).ready(function() {
  $.ajax({
            url: "http://api.openweathermap.org/data/2.5/forecast?id=2745912&APPID=3e7479392874b48638d0847329f31fad",

            type: "GET",

            dataType: "json",

            /**
             * A function to be called if the request fails.
             */
            error: function(jqXHR, textStatus, errorThrown) {

                $('#result').html("Data Failed To Load, jqXHR Status code(s): "+jqXHR.status);
                console.log(jqXHR);
                console.log(jqXHR.status);
                console.log(jqXHR.responseText);
                console.log('textStatus: '+textStatus);
                console.log(errorThrown);
            },
              /**
             * A function to be called if the request succeeds.
             */
            success: function(data, textStatus, jqXHR) {
                $('#result').html("Data Loaded Succesfully, Status code: "+ data.cod);
                console.log(jqXHR);
                console.log("Status: " +textStatus);
                console.log(data);
                var gradenC = Math.round( (data.list[0].main.temp -272.15) * 100) / 100

                $("#Location").val("Date and Time: "+ data.list[0].dt_txt +'\n'+
                  "Location Loaded: " + data.city.name +', '+data.city.country+
                  '\nWeather: '+data.list[0].weather[0].description+
                  ', '+ gradenC+'°C'+
                   "\nWind speed: " + data.list[0].wind.speed+
                 '\nLat: '+data.city.coord.lat+' Lon: '+data.city.coord.lon);
            }
        });

    });


</script>
</html>
