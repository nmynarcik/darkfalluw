function CustomMapType() {
}
CustomMapType.prototype.tileSize = new google.maps.Size(256,256);
CustomMapType.prototype.maxZoom = 7;
CustomMapType.prototype.getTile = function(coord, zoom, ownerDocument) {
    var div = ownerDocument.createElement('DIV');
    var baseURL = templateDir+'/images/tiles/';
    baseURL += zoom + '_' + coord.x + '_' + coord.y + '.png';
    div.style.width = this.tileSize.width + 'px';
    div.style.height = this.tileSize.height + 'px';
    div.style.backgroundColor = '#00000';
    div.style.backgroundImage = 'url(' + baseURL + ')';
    return div;
};

CustomMapType.prototype.name = "Custom";
CustomMapType.prototype.alt = "Tile Coordinate Map Type";
var map;
var CustomMapType = new CustomMapType();
var fullscreen = false;
var showMobs = false;
var showBanks = false;
var showCrafts = false;
var showBinds = false;
var showPortals = false;
var showChests = false;
var showHoldings = false;
var showVillages = false;
var mobs = [];
var banks = [];
var binds = [];
var crafts = [];
var portals = [];
var chambers = [];
var chests = [];
var holdings = [];
var villages = [];
var searchArray = [];
var searchResults = [];
var infowindow = null;

function map_initialize() {

  var mapOptions = {
      minZoom: 3,
    maxZoom: 7,
    isPng: true,
      mapTypeControl: false,
      streetViewControl: false,
        center: new google.maps.LatLng(73,-109),
      zoom: 4,
    mapTypeControlOptions: {
      mapTypeIds: ['custom', google.maps.MapTypeId.ROADMAP],
      style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
    }
  };
  map = new google.maps.Map(document.getElementById("map_canvas"),mapOptions);
  map.mapTypes.set('custom',CustomMapType);
  map.setMapTypeId('custom');

  google.maps.event.addListener(map, 'click', function(event) {
    placeMarker(event.latLng);
  });

  infowindow = new google.maps.InfoWindow({
        content: 'loading...'
    });

  getPOIs();
}

var marker;
var poiArray;

function getUserLoc(loc){
  var phpLoc = loc.split('%7C');
  var userLoc = new google.maps.LatLng(phpLoc[0], phpLoc[1]);
  placeMarker(userLoc);
  if(map){
    map.setZoom(7);
    map.setCenter(userLoc);
  }
}

function placeMarker(location) {
  if ( marker ) {
    marker.setPosition(location);
    marker.title = 'Click Me!';
  } else {
    marker = new google.maps.Marker({
      position: location,
      map: map,
      icon: templateDir+"/images/poi-default.png",
      title: 'Click Me!'
    });

    google.maps.event.addListener(marker, 'click', function() {
      copyToClipboard(marker);
    });
  }

  window.location.hash = marker.getPosition().lat()+"%7C"+marker.getPosition().lng();
  // map.setZoom(7);
  // map.setCenter(marker.getPosition());
}

function copyToClipboard (poi) {
    window.prompt ("Copy to clipboard: Ctrl+C, Enter", 'http://darkfallunholywars.info/world-map/#'+poi.getPosition().lat()+"%7C"+poi.getPosition().lng());
}

function getPOIs(){
  if(mobs.length){ //have we done this already?
    return;
  }
  //get the pois from the database
  jQuery.ajax({
      url: templateDir+'/getPOIs.php',
      dataType: 'json',
      success: function(data){
        // console.log(data);
        poiArray = data.pois;
        createMarkers();
      },
      error: function(jqXHR, textStatus, errorThrown){
        //window.console.log(jqXHR, textStatus, errorThrown);
        alert('Problem with Map. Please contact us through the feedback form describing what happened! Thanks!')
      }
    });
  if(userPOI != ""){
    getUserLoc(userPOI);
  }
}

function searchPOIs(text){
  // console.log('searching pois');
  if(text.length < 3){
    alert('Please enter atleast 3 characters to perform search.');
    return;
  }

  for(var i = 0; i < searchResults.length; i++){ //clear results from map
    searchResults[i].setMap(null);
  }

  searchArray = [];
  for(var i = 0; i < poiArray.length; i++){
    // console.log(poiArray[i].title);
    if(poiArray[i].title == null){
      //do nothing
    }else{
      var n =poiArray[i].title.toLowerCase().match(text.toLowerCase());
      if(n != null){
        searchArray.push(poiArray[i]);
      }
    }
  }
  showSearchResults(searchArray);
}

function showSearchResults(arr){
  console.log('showing results');
   searchResults = [];

   if(arr.length == 0){
    alert('No Results Found. :(');
      return;
   }

  for(var i = 0; i < arr.length; i++){

    var poiLoc = arr[i]._poi_loc.split('|');

    var poiLatLng = new google.maps.LatLng(poiLoc[0], poiLoc[1]);

    var itemTitle = arr[i].title;
    itemTitle = itemTitle.split(' | ');

    var contentString = '<ul>';

    for(var j = 0; j < itemTitle.length; j++){
      contentString = contentString + '<li>' + itemTitle[j] + '</li>';
    }
    contentString = contentString + '</ul>';

    var result = new google.maps.Marker({
      position: poiLatLng,
      map: map,
      animation: google.maps.Animation.DROP,
      icon: templateDir+"/images/poi-pink.png",
      // title: arr[i].title,
      html: contentString
    });


    google.maps.event.addListener(result, 'click', function() {
      copyToClipboard(result);
    });
    google.maps.event.addListener(result, 'mouseover', function() {
      // where I have added .html to the marker object.
      infowindow.setContent(this.html);
      infowindow.open(map, this);
    });
    // console.log('result',result);
    searchResults.push(result);
  }

  var bounds = new google.maps.LatLngBounds();
  for(var i = 0; i < searchResults.length; i++){
    searchResults[i].setMap(map);
    bounds.extend(searchResults[i].getPosition());
    map.fitBounds(bounds);
  }
}

function createMarkers(){
 // console.log('creating markers');
  var overlay = null;
  var image;
  for(var i = 0; i < poiArray.length; i++){
    switch(poiArray[i]._poi_type){
      case 'bank':
        image = templateDir+'/images/poi-bank.png';
        overlay = banks;
        break;
      case 'mob':
        if(poiArray[i]._poi_level == ""){
          image = templateDir+'/images/poi-mob.png';
        }else{
          image = templateDir+'/images/poi-mob-'+poiArray[i]._poi_level+'.png';
        }
        overlay = mobs;
        break;
      case 'city':
        image = templateDir+'/images/poi-city.png';
        overlay = holdings;
        break;
      case 'hamlet':
        image = templateDir+'/images/poi-hamlet.png';
        overlay = holdings;
        break;
      case 'cbind':
        image = templateDir+'/images/poi-bind-chaos.png';
        overlay = binds;
        break;
      case 'sbind':
        image = templateDir+'/images/poi-bind-safe.png';
        overlay = binds;
        break;
      case 'craft':
        image = templateDir+'/images/poi-craft.png';
        overlay = crafts;
        break;
       case 'portal':
        image = templateDir+'/images/poi-portal.png';
        overlay = portals;
        break;
      case 'pchamber':
        image = templateDir+'/images/poi-chamber.png';
        overlay = portals;
        break;
      case 'village':
        image = templateDir+'/images/poi-village.png';
        overlay = villages;
        break;
      case 'chest':
        image = templateDir+'/images/poi-chest.png';
        overlay = chests;
        break;
    }

    var poiLoc = poiArray[i]._poi_loc.split('|');

    var itemTitle = poiArray[i].title;
    if(itemTitle != null && itemTitle.match('|')) {
      itemTitle = itemTitle.split('|');
    }

    var contentString = '<ul>';

    if(itemTitle != null && itemTitle.length > 0){
      for(var j = 0; j < itemTitle.length; j++){
        contentString = contentString + '<li>' + itemTitle[j] + '</li>';
      }
    }else{
      contentString = contentString + '<li>' + itemTitle + '</li>';
    }
    contentString = contentString + '</ul>';

    var poiLatLng = new google.maps.LatLng(poiLoc[0], poiLoc[1]);
    var poiMarker = new google.maps.Marker({
        position: poiLatLng,
        map: null,
        icon: image,
        // title: poiArray[i].title,
        html: contentString
    });

    google.maps.event.addListener(poiMarker, 'dblclick', function() {
      copyToClipboard(poiMarker);
    });

    google.maps.event.addListener(poiMarker, 'click', function(e) {
      map.setZoom(7);
      map.setCenter(e.latLng);
    });

    google.maps.event.addListener(poiMarker, 'mouseover', function() {
      // where I have added .html to the marker object.
      infowindow.setContent(this.html);
      infowindow.open(map, this);
    });

    overlay.push(poiMarker);
  }
}

function showMarkers(type){
  // console.log('showing markers', type);
  var markerArray;
  switch(type){
    case "mobs":
      markerArray = mobs;
      break;
    case "banks":
      markerArray = banks;
      break;
    case "crafts":
      markerArray = crafts;
      break;
    case "binds":
      markerArray = binds;
      break;
    case "portals":
      markerArray = portals;
      break;
    case 'holdings':
      markerArray = holdings;
        break;
    case 'villages':
      markerArray = villages;
      break;
    case 'chests':
      markerArray = chests;
      break;
  }
  var bounds = new google.maps.LatLngBounds();
  for(var i = 0; i < markerArray.length; i++){
    markerArray[i].setMap(map);
    bounds.extend(markerArray[i].getPosition());
    map.fitBounds(bounds);
  }
}

function hideMarkers(type){
  // console.log('hiding markers', type);
  var markerArray;
  switch(type){
    case "mobs":
      markerArray = mobs;
      break;
    case "banks":
      markerArray = banks;
      break;
    case "crafts":
      markerArray = crafts;
      break;
    case "binds":
      markerArray = binds;
      break;
    case "portals":
      markerArray = portals;
      break;
    case 'holdings':
      markerArray = holdings;
      break;
    case 'villages':
      markerArray = villages;
      break;
    case 'chests':
      markerArray = chests;
      break;
  }
  for(var i = 0; i < markerArray.length; i++){
    markerArray[i].setMap(null);
  }
}

function checkToggles(){
  jQuery.each(jQuery('#map-legend a'), function(){
    if(jQuery(this).hasClass('active')){
      switch(jQuery(this).attr('id')){
        case 'mob-btn':
          showMarkers('mobs');
          break;
        case 'bank-btn':
          showMarkers('banks');
          break;
        case 'craft-btn':
          showMarkers('crafts');
          break;
        case 'bind-btn':
          showMarkers('binds');
          break;
        case 'portal-btn':
          showMarkers('portals');
          break;
        case 'holding-btn':
          showMarkers('holdings');
          break;
        case 'village-btn':
          showMarkers('villages');
          break;
        case 'chest-btn':
          showMarkers('chests');
          break;
      }
    }
  });
}

// var roads = [
//   new google.maps.LatLng(70.22602804114847,-84.5672607421875),
//   new google.maps.LatLng(70.1403642720717,-84.1937255859375),
//   new google.maps.LatLng(70.13663169260924,-83.7432861328125),
//   new google.maps.LatLng(70.06558465579644,-83.2598876953125),
//   new google.maps.LatLng(69.96796725849451,-82.7655029296875),
//   new google.maps.LatLng(69.96796725849451,-82.7655029296875),
//   new google.maps.LatLng(69.80551647017177,-82.3260498046875),
//   new google.maps.LatLng(69.80551647017177,-82.3260498046875),
//   new google.maps.LatLng(69.64562538650985,-82.2271728515625),
//   new google.maps.LatLng(69.54987728327795,-82.0404052734375),
//   new google.maps.LatLng(69.42282952635378,-82.7545166015625),
//   new google.maps.LatLng(69.37257336614788,-83.4136962890625)
// ]

// function createRoads(){
//   var line = new google.maps.Polyline({
//     path: roads,
//     geodesic: false,
//     strokeColor: '#000000',
//     strokeOpacity: 1,
//     strokeWeight: 3
//   });
//   line.setMap(map);
// }
