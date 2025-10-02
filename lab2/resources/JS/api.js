//we get spotify api token using client credentials (this uses )
async function getSpotifyToken(callback) {
    $.ajax({
        url: "https://accounts.spotify.com/api/token",
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        data: {
            grant_type: "client_credentials",
            client_id: "ea7f0d7803d9465e985a1d7d976d4e5b",
            client_secret: "7598a7ca29a34df19b717c537d33951b"
        },
        success: function(response) {
            console.log("Access token:", response.access_token);
            callback(response.access_token);
            // you can now use response.access_token in other requests
        },
        error: function(xhr, status, error) {
            console.error("Error:", status, error);
        }
    });
}

weatherButton = document.getElementById("getWeatherButton");
weatherButton.addEventListener("click", getWeather);

//this gets location from computer using geolocation api
function getWeather() {
    console.log("Getting location...");
    if(navigator.geolocation) {
        console.log("Getting position...");
        navigator.geolocation.getCurrentPosition(function(position) {
        const lat = position.coords.latitude;
        const lon = position.coords.longitude;
        console.log("Latitude: " + lat + ", Longitude: " + lon);
        getCurrentWeather(lat, lon);
    }, function(error) {
        console.error("Error getting location: ", error);
    });
    }
}

function getCurrentWeather(lat, lon) {
  const apiKey = "6ab771a9c5429bd3ade384b2edb9cef2";
  const url = "https://api.openweathermap.org/data/2.5/weather";

  $.ajax({
    url: url,
    method: "GET",
    dataType: "json",
    data: {
      lat: lat,
      lon: lon,
      units: "imperial",  
      appid: apiKey
    },
    success: function(data) {
        
        //update visibility of results divs
        $("#weatherResults").css("visibility", "visible");
        $("#musicResults").css("visibility", "visible");

      console.log("Weather data:", data);
        //pick out what you want
        const city = data.name;
        const country = data.sys.country;
        const temp = data.main.temp;
        const humidity = data.main.humidity;
        const desc = data.weather[0].description;
        const icon = data.weather[0].icon;
        const wind = data.wind.speed;

        //build HTML
        const html = `
            <h2>Weather in ${city}, ${country}</h2>
            <p><img src="https://openweathermap.org/img/wn/${icon}@2x.png" alt="${desc}"></p>
            <p><strong>Temperature 🌡️:</strong> ${temp} °F</p>
            <p><strong>Humidity 💦:</strong> ${humidity}%</p>
            <p><strong>Condition ☁️:</strong> ${desc}</p>
            <p><strong>Wind Speed 💨:</strong> ${wind} mph</p>
        `;
        getSongsFromGenre(desc);  //basically find a genre based on weather description
        document.getElementById("weatherResults").innerHTML = html;
    },
    error: function(xhr, status, error) {
      console.error("Error fetching weather:", status, error);
    }
  });
}

function getSongsFromGenre(genre) 
{
    //get token first
    getSpotifyToken(function(token) {
        const url = "https://api.spotify.com/v1/search";  

        console.log("Using token:", token);
        $.ajax({
            url: url,
            method: "GET",
            data: {
            q: genre,
            type: "track",
            limit: 5
            },
            headers: {
            "Authorization": "Bearer " + token
            },
            success: function(data) {
            console.log("Search results:", data);

            // Show track names + artists
            const results = data.tracks.items.map(track => 
                `<div class = "song">
                <h3> Listen to <b>${track.name}</b> by <b>${track.artists.map(a => a.name).join(", ")}</b></h3>
                ${displayMusic(track)}</div>`).join("");
            document.getElementById("musicResults").innerHTML = results;
            },
            error: function(xhr, status, error) {
            console.error("Spotify search error:", status, error);
            console.log("Response text:", xhr.responseText);
            }
        });
    });
}

//this will give spotifiy embed code
function displayMusic(song) 
{
  const track = song.id; //spotify track id
  const embedHtml = ` 
    <iframe 
      src="https://open.spotify.com/embed/track/${track}" 
      width="300" 
      height="80" 
      frameborder="0" 
      allowtransparency="true" 
      allow="encrypted-media">
    </iframe>
  `;
  return embedHtml;
}