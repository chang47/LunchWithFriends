      var map;
      var userLat;
      var userLng;
      function initialize() {
        var mapOptions = {
          //center: new google.maps.LatLng(47.6559, -122.3031),
          zoom: 18,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("map-canvas"),
            mapOptions);

        if(navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position){
            userLat = position.coords.latitude;
            userLng = position.coords.longitude;
            var pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            //alert(pos.lat() + " " + pos.lng());
            var iconBase = 'https://maps.google.com/mapfiles/kml/shapes/';
            var marker = new Array();
            for(var i = 0; i < 2; i++) {
              marker[0] = new google.maps.Marker({
                  position: new google.maps.LatLng(pos.lat(), pos.lng()),
                  map: map,
                  icon : iconBase + 'schools_maps.png'
                });
              var lat = 47.6559;
              var lng = -122.3031;
            }
            map.setCenter(pos);
          }, function(){
            //handleNoGeolocation(true);
          });
        }
      }
      google.maps.event.addDomListener(window, 'load', initialize);

$(document).ready(function() {
        request("get-friends", {}, function(data) {
    $.each(data, function(k, v) {
      $("#list").append('<li><img src="' + v.dp + '"> ' + v.name + '</li>');
      addUser(v)
    });
  });
            /*request("search-restaurants", {loc_lat: userLat, loc_lgn: userLgn, q: query}, function(data) {
                for(var building in data) {
                    building.
                }
            });*/
            var marker = new Array();
            var poopdata = new Array();
            var poopdata2 = new Array();
            var count = 0;
            var infowindow =  new google.maps.InfoWindow({
              content: ""
            });
                        
           /* $.getJSON("store.json", function(data){
                $.each(data.data.businesses, function(k, v) {
                    console.log(v.location.display_address[0]);
                    console.log(v.location.display_address[3]);
                    console.log(v.snippet_image_url);
                    poopdata[v.location.display_address[0]] = [{"image" : v.image_url,
                                                               "name" : v.name,
                                                               "ratingImage" :v.rating_img_url,
                                                               "reviewCount" : v.review_count,
                                                               "address1" : v.location.display_address[0],
                                                               "address2" : v.location.display_address[3]}];
                                                               console.log(v.rating_img_url);
                    //console.log("reading data! " + poopdata[v.location.display_address[0]][0].name);
                    //infowinodw.setContent(v.location.display_address[0]);
                    if(typeof(v.location.display_address[3]) !== "undefined") {
                      geocoder = new google.maps.Geocoder();
                      //1st asynchronous
                      geocoder.geocode({address: v.location.display_address[0] + ", " + v.location.display_address[3]}, function(results) {
                        console.log(results[0]);
                        lat = results[0].geometry.location.lat();
                        lng = results[0].geometry.location.lng();
                        console.log(results[0].address_components[0].short_name);

                        poopdata2[lat + ":" + lng] = poopdata[results[0].address_components[0].short_name + " " + results[0].address_components[1].short_name]
                        //Creates the markers
                        marker[lat + ":" + lng] = new google.maps.Marker({
                          position: new google.maps.LatLng(lat, lng),
                          map: map
                        }); //end marker

                        //2nd asynchronous
                        google.maps.event.addListener(marker[lat + ":" + lng], "click", function(poop1) {
                          console.log(poop1);
                          console.log("infowindow " + poopdata2[poop1.latLng.k + ":" + poop1.latLng.A])
                           poop = marker[poop1.latLng.k + ":" + poop1.latLng.A];
                          infowindow.setContent(
                            '<p><h3>' + poopdata2[poop1.latLng.k + ":" + poop1.latLng.A][0].name + '</h3></p>' 
                            + '<img src="' + poopdata2[poop1.latLng.k + ":" + poop1.latLng.A][0].ratingImage + '">'
                            + poopdata2[poop1.latLng.k + ":" + poop1.latLng.A][0].reviewCount 
                            + '<p>' + poopdata2[poop1.latLng.k + ":" + poop1.latLng.A][0].address1 + '</p>'
                            + '<p>' + poopdata2[poop1.latLng.k + ":" + poop1.latLng.A][0].address2 + '</p>'
                            + '<img src="' + poopdata2[poop1.latLng.k + ":" + poop1.latLng.A][0].image + '">');
                          infowindow.close();
                          infowindow.open(map, poop);
                        });
                      }); //geocoder

                    count++;
                   } // end if statement
                }); //end for each
            }); // end json
*/


     function addUser(data) {
        var people = new google.maps.Marker({
          position: new google.maps.LatLng(data.location_lat, data.location_lng),
          map: map,
          icon: data.dp
        });
      }




      $("#submitButton").click(function() {
        var start = $("select[name='startdatetime'] option:selected").val();
        var end = $("select[name='enddatetime'] option:selected").val();
        var food = $("#preference").val();
        alert(start + " " + end + " " + food);


        request("join-lunchline", {starttime :start , endtime: end , food_pref : food, loc_lat : userLat, loc_lng : userLng}, function(data){
          console.log(data);
          console.log(data.restaurants[0]);
          $.each(data, function(k, v) {
              console.log(v.restaurants.location.display_address[0]);
              console.log(v.location.display_address[3]);
              console.log(v.snippet_image_url);
              poopdata[v.location.display_address[0]] = [{"image" : v.image_url,
                                                         "name" : v.name,
                                                         "ratingImage" :v.rating_img_url,
                                                         "reviewCount" : v.review_count,
                                                         "address1" : v.location.display_address[0],
                                                         "address2" : v.location.display_address[3]}];
                                                         console.log(v.rating_img_url);
              //console.log("reading data! " + poopdata[v.location.display_address[0]][0].name);
              //infowinodw.setContent(v.location.display_address[0]);
              if(typeof(v.location.display_address[3]) !== "undefined") {
                geocoder = new google.maps.Geocoder();
                //1st asynchronous
                geocoder.geocode({address: v.location.display_address[0] + ", " + v.location.display_address[3]}, function(results) {
                  console.log(results[0]);
                  lat = results[0].geometry.location.lat();
                  lng = results[0].geometry.location.lng();
                  console.log(results[0].address_components[0].short_name);

                  poopdata2[lat + ":" + lng] = poopdata[results[0].address_components[0].short_name + " " + results[0].address_components[1].short_name]
                  //Creates the markers
                  marker[lat + ":" + lng] = new google.maps.Marker({
                    position: new google.maps.LatLng(lat, lng),
                    map: map
                  }); //end marker

                  //2nd asynchronous
                  google.maps.event.addListener(marker[lat + ":" + lng], "click", function(poop1) {
                    console.log(poop1);
                    console.log("infowindow " + poopdata2[poop1.latLng.k + ":" + poop1.latLng.A])
                     poop = marker[poop1.latLng.k + ":" + poop1.latLng.A];
                    infowindow.setContent(
                      '<p><h3>' + poopdata2[poop1.latLng.k + ":" + poop1.latLng.A][0].name + '</h3></p>' 
                      + '<img src="' + poopdata2[poop1.latLng.k + ":" + poop1.latLng.A][0].ratingImage + '">'
                      + poopdata2[poop1.latLng.k + ":" + poop1.latLng.A][0].reviewCount 
                      + '<p>' + poopdata2[poop1.latLng.k + ":" + poop1.latLng.A][0].address1 + '</p>'
                      + '<p>' + poopdata2[poop1.latLng.k + ":" + poop1.latLng.A][0].address2 + '</p>'
                      + '<img src="' + poopdata2[poop1.latLng.k + ":" + poop1.latLng.A][0].image + '">');
                    infowindow.close();
                    infowindow.open(map, poop);
                  });
                }); //geocoder

              count++;
             } // end if statement
          }); //end for each
      }); // end json );
  return false;
});

});
