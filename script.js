var x = document.getElementById('output');
var lat = document.getElementById('lat');
var lng = document.getElementById('lng');

function getLocation() {
    if(navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    }else {
        x.innerHTML = "Not supporting";
    }
}
setTimeout(getLocation, 4000);
function showPosition(position) {
    //x.innerHTML = "latitude = " + position.coords.latitude
    //x.innerHTML += "<br />"
    //x.innerHTML += "longitude = " + position.coords.longitude

    var apikey = 'bf10098ea60c45b5852fcdcdab37cafd';
    var latitude =  position.coords.latitude;    
    var longitude =  position.coords.longitude;  

    lat.value = latitude;
    lng.value = longitude;
    //console.log(lat);

    var api_url = 'https://api.opencagedata.com/geocode/v1/json'

var request_url = api_url
    + '?'
    + 'key=' + apikey
    + '&q=' + encodeURIComponent(latitude + ',' + longitude)
    + '&pretty=1'
    + '&no_annotations=1';

    //x.innerHTML = request_url
$.get({
    url : request_url,
    success : function(data) {
        console.log(data)
        //x.innerHTML = data.results[0].components.state_district + ", ";
        //x.innerHTML = data.results[0].components.state + ", ";
        //x.innerHTML = data.results[0].components.country;
        x.innerHTML = data.results[0].formatted;
        
    }
});
}

//document.getElementById('resul').value = x.innerHTML;


// var request = new XMLHttpRequest();
// request.open('GET', request_url, true);

// request.onload = function() {
    

//     if (request.status === 200){ 
//     // Success!
//     var data = JSON.parse(request.responseText);
//     //x.innerHTML = data.results[0].formatted; // print the location

//     } else if (request.status <= 500){ 
//     // We reached our target server, but it returned an error
                        
//     console.log("unable to geocode! Response code: " + request.status);
//     var data = JSON.parse(request.responseText);
//     console.log('error msg: ' + data.status.message);
//     } else {
//     console.log("server error");
//     }
// };

// request.onerror = function() {
//     // There was a connection error of some sort
//     console.log("unable to connect to server");        
// };

// request.send();  // make the request

// }

function showError(error) {
    switch(error.code) {
        case error.PERMISSION_DENIED:
            x.innerHTML = "User don't want to share location";
            break;

        case error.POSITION_UNAVAILABLE:
            x.innerHTML = "User location data is not available";
            break;

        case error.TIMEOUT:
            x.innerHTML = "Timeout !";
            break;

        case error.UNKOWN_ERROR:
            x.innerHTML = "Unknown Error occurred";
            break;
    }
}
