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
var mobs = [];
var banks = [];
var binds = [];
var crafts = [];
var portals = [];
var chambers = [];

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

  getPOIs();
}

var marker;
var poiArray;

function placeMarker(location) {
  if ( marker ) {
    marker.setPosition(location);
    marker.title = location.lat()+'|'+location.lng();
  } else {
    marker = new google.maps.Marker({
      position: location,
      map: map,
      icon: templateDir+"/images/poi-default.png",
      title: location.lat()+'|'+location.lng()
    });

    google.maps.event.addListener(marker, 'click', function() {
      copyToClipboard(marker);
    });
  }
  // map.setZoom(7);
  // map.setCenter(marker.getPosition());
}

function copyToClipboard (poi) {
  if(marker == poi){
    window.prompt ("Copy to clipboard: Ctrl+C, Enter", marker.title);
  }else{
    window.prompt ("Copy to clipboard: Ctrl+C, Enter", poi.getPosition().lat()+"|"+poi.getPosition().lng());
  }
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
        // console.log(textStatus, errorThrown);
        alert('Problem with Map. Please contact us through the feedback form describing what happened! Thanks!')
      }
    });
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
      case 'bindstones':
        image = templateDir+'/images/poi-bind.png';
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
      case 'chamber':
        image = templateDir+'/images/poi-chamber.png';
        overlay = portals;
        break;
    }

    var poiLoc = poiArray[i]._poi_loc.split('|');

    var poiLatLng = new google.maps.LatLng(poiLoc[0], poiLoc[1]);
    var poiMarker = new google.maps.Marker({
        position: poiLatLng,
        map: null,
        icon: image,
        title: poiArray[i].title
    });

    google.maps.event.addListener(poiMarker, 'click', function() {
      copyToClipboard(poiMarker);
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
      }
    }
  });
}
