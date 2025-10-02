# ITWS2110-S25-Lab 1 | Dathan Lang 

## Background
Hey this is my web app for getting the weather around you as well as music relating to that weather.

## Process and Struggles
For this project I spent most of my time just researching how to even set of the ajax and jquery scripts to get data from the api stuff. After i got the weather going, it wasn't too bad but I realized early on that spotify resets their api token stuff every hour, so to make this even work, I just borrow some of spotify's code to refresh the token and set it so it just requests a new one instead. After that stuff was done, did some generic styling to make it look presentable. I do think, for further improvements, I should think of figuring out how to cache data and info or some method to speed up load times. Currently it can take up to 10 seconds to load in, which can be bad for user experience.

## Notes
Its probably a bad idea to do this in the front end, but I understood the directions that we shouldn't use frameworks or php.

## Resources Used:
- https://www.youtube.com/watch?v=Ph1R7LZsymI this was to help get latitude and longitude for api call
- https://docs.openweather.co.uk/current documentation for web api
- https://www.w3schools.com/xml/ajax_xmlhttprequest_send.asp used w3 schools for general ajax help
- https://api.jquery.com/jQuery.ajax/ to make life easier using jquery built in functions
- https://www.flaticon.com/free-icon/music-cloud_1598707 - using this for logo
- https://developer.spotify.com/documentation/embeds (embeds for spotify)
- https://www.w3schools.com/js/js_callback.asp - this helped with logic to dynamically get new spotify credentials
- https://developer.spotify.com/documentation/web-api/tutorials/refreshing-tokens
