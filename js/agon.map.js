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
    div.style.backgroundColor = '#1B2D33';
    div.style.backgroundImage = 'url(' + baseURL + ')';
    return div;
};

CustomMapType.prototype.name = "Custom";
CustomMapType.prototype.alt = "Tile Coordinate Map Type";
var map;
var CustomMapType = new CustomMapType();
var fullscreen = false;
var mobs = [];
var banks = [];
var binds = [];
var crafts = [];

function map_initialize() {

  var mapOptions = {
      minZoom: 3,
    maxZoom: 7,
    isPng: true,
      mapTypeControl: false,
      streetViewControl: false,
        center: new google.maps.LatLng(73,-109),
      zoom: 3,
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

  // createMarkers();
}

var marker;

function placeMarker(location) {
  if ( marker ) {
    marker.setPosition(location);
  } else {
    marker = new google.maps.Marker({
      position: location,
      map: map,
      icon: templateDir+"/images/poi-default.png",
      title: 'lat: '+location.lat()+' lng: '+location.lng()
    });
  }
  map.setMapTypeId('custom');
}

function createMarkers(){
  console.log(poiArray);
  var image = 'poi-default.png';
  var overlay = null;

  for(var i = 0; i < poiArray.length; i++){
    switch(poiArray[i].type){
      case 'banks':
        image = templateDir+'/images/poi-bank.png';
        break;
      case 'mob':
        image = templateDir+'/images/poi-mob.png';
        overlay = mobs;
        break;
      case 'bindstones':
        image = templateDir+'/images/poi-bind.png';
        break;
      case 'craft':
        image = templateDir+'/images/poi-craft.png';
        break;
    }

    var poiLatLng = new google.maps.LatLng(poiArray[i].x, poiArray[i].y);
    var poiMarker = new google.maps.Marker({
        position: poiLatLng,
        map: map,
        icon: image,
        title: poiArray[i].name
    });
    overlay.push(poiMarker);
  }
}

var poiArray = [
    {
      'type':'mob',
      'name':'mob 1',
      x:73,
      y:-109
    },
    {
      'type':'mob',
      'name':'mob 2',
      x:150,
      y:-300
    },
    {
      'type':'mob',
      'name':'mob 3',
      x:400,
      y:-150
    }
]
