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
        alert('Problem with Map. Please contact us through the feedback form describing what happened! Thanks!');
      }
    });
  if(userPOI !== ""){
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
  for(var j = 0; j < poiArray.length; j++){
    // console.log(poiArray[i].title);
    if(poiArray[j].title == null){
      //do nothing
    }else{
      var n =poiArray[j].title.toLowerCase().match(text.toLowerCase());
      if(n != null){
        searchArray.push(poiArray[j]);
      }
    }
  }
  showSearchResults(searchArray);
}

function showSearchResults(arr){
  console.log('showing results');
   searchResults = [];

   if(arr.length === 0){
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
      copyToClipboard(this);
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
  for(var k = 0; k < searchResults.length; k++){
    searchResults[k].setMap(map);
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
        if(poiArray[i]._poi_level === ""){
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

    google.maps.event.addListener(poiMarker, 'click', function() {
      copyToClipboard(this);
    });

    // google.maps.event.addListener(poiMarker, 'click', function(e) {
    //   map.setZoom(7);
    //   map.setCenter(e.latLng);
    // });

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
;(function($){

  if($.browser.msie){
    $('html').addClass('msie');
  }else if($.browser.mozilla){
    $('html').addClass('mozilla');
  }else if($.browser.chrome){
    $('html').addClass('chrome');
  }

    if($(".accordion").length){
      $('.accordion').accordion({ collapsible: true });
      // console.log('ACCORDION!');
      //$(".accordion").tabs(".pane", {tabs: 'h4', effect: 'slide'});
    }

    if($('#expand-all').length){
      $('#expand-all').click(function(){
            if($('#expand-all span').text() == "Expand All"){
              $('.accordion .pane').show();
              $('#expand-all span').text('Collapse All');
              $('#expand-all i').removeClass('icon-plus-sign').addClass('icon-minus-sign');
            }else{
              $('.accordion-header').removeClass('current');
              $('#expand-all span').text('Expand All');
              $('#expand-all i').removeClass('icon-minus-sign').addClass('icon-plus-sign');
              $('.accordion').accordion('destroy').accordion({ collapsible: true });
            }
          });
    }

    //$('input[placeholder], textarea[placeholder]').placeholder();

    if($('#expand-all').length){
      $('.accordion-header').click(function(e){
        // e.preventDefault();
        var _this = $(this);
        if($('#expand-all i').hasClass('icon-minus-sign')){
          $('#expand-all span').text('Expand All');
          $('#expand-all i').removeClass('icon-minus-sign').addClass('icon-plus-sign');
          $('.accordion').accordion('destroy').accordion({ collapsible: true });
        }
      });
    }

    var schools = {
      init: function(){
         $('#school_selector').change(function(){
            window.location = $(this).val();
          });

         if($('#content.air').length){
            $('.excl-legend span').text('Earth');
         }
         if($('#content.earth').length){
            $('.excl-legend span').text('Air');
         }
         if($('#content.pain').length){
            $('.excl-legend span').text('Life');
         }
         if($('#content.life').length){
            $('.excl-legend span').text('Pain');
         }
         if($('#content.law').length){
            $('.excl-legend span').text('Chaos');
         }
         if($('#content.chaos').length){
            $('.excl-legend span').text('Law');
         }
         if($('#content.brawler').length){
            $('.excl-legend span').text('Blackguard');
         }
         if($('#content.blackguard').length){
            $('.excl-legend span').text('Brawler');
         }
         if($('#content.deadeye').length){
            $('.excl-legend span').text('Duelist');
         }
         if($('#content.duelist').length){
            $('.excl-legend span').text('Deadeye');
         }
         if($('#content.baresark').length){
            $('.excl-legend span').text('Champion');
         }
         if($('#content.champion').length){
            $('.excl-legend span').text('Baresark');
         }
         if($('#content.battle-brand').length){
            $('.excl-legend span').text('Slayer');
         }
         if($('#content.slayer').length){
            $('.excl-legend span').text('Battle Brand');
         }
         if($('#content.fire').length){
            $('.excl-legend span').text('Water');
         }
         if($('#content.water').length){
            $('.excl-legend span').text('Fire');
         }
      }
    };

    var clans = {
      init: function(){
        $("#clans-list").tablesorter({
          widgets: ['zebra']
        });

        $('#server_select').change(function(){
          window.location = '../'+$(this).val();
        });
      }
    };

    var home = {

      init: function(){
        home.twitchLiveStreams();

          $('#df-vid').attr('src','http://www.youtube.com/embed/'+$('#featured-list li:first-child a').data('vidId')+'?rel=0&autoplay=0&iv_load_policy=3&modestbranding=1&wmode=opaque');

        $('#featured-list li a').on({
          'click':function(){
            var $id = $(this).data('vidId');
            $('#df-vid').attr('src','http://www.youtube.com/embed/'+$id+'?rel=0&autoplay=1&iv_load_policy=3&modestbranding=1&wmode=opaque');
            $('#twitch-player').hide();
          }
        });

        home.getForumFallFeed();
        $('.blogfeed a.post').ellipsis();
      },

      showTwitchChannel: function(list){
        // console.log('SHOW TWITCH CHANNEL FOR MAIN VIDEO');
        var streamer = list.streams[0].channel.display_name;
        // console.log('das streamer: ',streamer);
        // $('#df-vid').attr('src', 'http://www.twitch.tv/widgets/live_embed_player.swf?channel='+streamer);
        $('.entry-content').prepend('<object id="twitch-player" type="application/x-shockwave-flash" height="371" width="659" id="live_embed_player_flash" data="http://www.twitch.tv/widgets/live_embed_player.swf?channel='+streamer+'" bgcolor="#000000"><param name="allowFullScreen" value="true" /><param name="allowScriptAccess" value="always" /><param name="allowNetworking" value="false" /><param name="movie" value="http://www.twitch.tv/widgets/live_embed_player.swf" /><param name="flashvars" value="hostname=www.twitch.tv&channel='+streamer+'&auto_play=true&start_volume=25" /></object>');
        var newText = $('#twitch-live').html();
        newText = newText.replace('{NAME}',streamer.toUpperCase());
        $('#twitch-live').data('streamer',streamer).html(newText).show();
        $('#twitch-live').click(function(){
          // $('#df-vid').attr('src', 'http://www.twitch.tv/widgets/live_embed_player.swf?channel='+$(this).data('streamer'));
          $('#twitch-player').show();
          $('#df-vid').attr('src', '');
          return false;
        });
      },

      twitchLiveStreams: function(){
          Twitch.init({clientId: '207ndj3uuk5rmh6sdazihsx8aw53mm4'}, function(error, status) {
            // console.log('Twitch Initiated!');
            Twitch.api({method: 'streams', params: {game:'Darkfall Unholy Wars', limit:3} }, function(error, list) {
              if(list.streams.length > 0) {
                window.dfuwTwitchList = list;
                home.showTwitchChannel(list);
              }
            });
          });
      },

      getForumFallFeed: function(){
        $('.load-wrapper').stop(true,true).fadeIn('fast');
        $.ajax({
            url: templateDir+'/proxy.php?url=http://forums.darkfallonline.com/external.php?type=RSS2', //DF Forums
            dataType: 'xml',
            async: false,
            type: 'GET',
            timeout: 60000,
            success: function(data){
                var list = "<ul>";
                $(data).find('item').each(function(i){
                  if(i > 4)
                    return false;
                  list += '<li><a href="'+$(this).find('link').text()+'" target="_blank" rel="nofollow"><span class="title">'+filterText($(this).find('title').text())+'</span></a> <div class="descr">'+filterText($(this).find('description').text())+'</div></li>';
                });
                list += '</ul>';
                if($('.bottom .forumfeed ul').length){
                  $('.bottom .forumfeed ul').remove();
                }
                if(list == "<ul></ul>"){
                  list = "<ul><li><strong>Forums currently offline!</strong></li></ul>";
                  $('.bottom .forumfeed').append(list);
                }else{
                  $('.bottom .forumfeed').append(list);
                  $('.forumfeed li a, .forumfeed li .descr').ellipsis();
                }
              $('.load-wrapper').stop(true,true).fadeOut();

              setTimeout(function(){
                home.getForumFallFeed();
              }, 180000);
            },
            error: function(jqXHR, textStatus, errorThrown){
              // console.log('error: ',arguments, textStatus, errorThrown);
              $('.loading, .loader').stop(true,true).fadeOut();
                setTimeout(function(){
                  home.getForumFallFeed();
                }, 180000);
            }
          });
      }
    };

    var server_status = {
      getStatus: function(){
        $.ajax({
          url: templateDir+'/serverstatus.php',
          dataType: 'json',
          timeout: 60000,
          success: function(data){
            if(data['@attributes'].Result == 'SUCCESS'){

              $('#server-status').find('span i').removeClass('up down');

              var obj = data.Servers.ServerStatus;

              for(var i = 0; i < obj.length; i++){
                // console.log(obj[i]['@attributes']);
                var region = obj[i]['@attributes'].ID.toLowerCase();
                $('#server-status').find('.'+region).find('i').addClass(obj[i]['@attributes'].Status.toLowerCase());
              }
            }
          },
          error: function(jqXHR, textStatus, errorThrown){
            // console.log(textStatus, errorThrown);
            $('#server-status').find('span i').removeClass('up down');
          }
        });
        setTimeout(function(){
          server_status.getStatus();
        },120000);
      }
    };

    var feedback = {
      init: function(){
        $('.your-subject').change(function(){
          if($('.your-subject option:selected').val() == "Add My Clan"){
            $('.feedback .clan-details').slideDown();
            $('.feedback .event-details').slideUp();
          }else if($('.your-subject option:selected').val() == "Add My Event"){
            $('.feedback .clan-details').slideUp();
            $('.feedback .event-details').slideDown();
          }else{
            $('.feedback .clan-details').slideUp();
            $('.feedback .event-details').slideUp();
          }
        });
      }
    };

    var map_legend = {
      init:  function(){
        // console.log('adding listeners');
          // fullscreen bind
          $('#fs-btn').click(function(){
            if(!fullscreen){
              $('#map-container').appendTo('body');
              $('#fs-btn').addClass('active');
              $('body').scrollTop(0);
              fullscreen = true;
              map_initialize();
              checkToggles();
              if(marker)
                marker.setMap(map);
            }else{
              $('#map-container').appendTo('.entry-content');
              $('#fs-btn').removeClass('active');
              fullscreen = false;
              map_initialize();
              checkToggles();
              if(marker)
                marker.setMap(map);
            }
          });

            // mob bind
            $('#mob-btn').click(function(){
              if(!showMobs){
                $('#mob-btn').addClass('active');
                showMobs = true;
                showMarkers('mobs');
              }else{
                $('#mob-btn').removeClass('active');
                showMobs = false;
                hideMarkers('mobs');
              }
            });

            // bank bind
            $('#bank-btn').click(function(){
              if(!showBanks){
                $('#bank-btn').addClass('active');
                showBanks = true;
                showMarkers('banks');
              }else{
                $('#bank-btn').removeClass('active');
                showBanks = false;
                hideMarkers('banks');
              }
            });

            // chest bind
            $('#chest-btn').click(function(){
              if(!showBanks){
                $('#chest-btn').addClass('active');
                showBanks = true;
                showMarkers('chests');
              }else{
                $('#chest-btn').removeClass('active');
                showBanks = false;
                hideMarkers('chests');
              }
            });

             // craft bind
            $('#craft-btn').click(function(){
              if(!showCrafts){
                $('#craft-btn').addClass('active');
                showCrafts = true;
                showMarkers('crafts');
              }else{
                $('#craft-btn').removeClass('active');
                showCrafts = false;
                hideMarkers('crafts');
              }
            });

             // bind bind
            $('#bind-btn').click(function(){
              if(!showBinds){
                $('#bind-btn').addClass('active');
                showBinds = true;
                showMarkers('binds');
              }else{
                $('#bind-btn').removeClass('active');
                showBinds = false;
                hideMarkers('binds');
              }
            });

             // portal bind
            $('#portal-btn').click(function(){
              if(!showPortals){
                $('#portal-btn').addClass('active');
                showPortals = true;
                showMarkers('portals');
              }else{
                $('#portal-btn').removeClass('active');
                showPortals = false;
                hideMarkers('portals');
              }
            });

             // holding bind
            $('#holding-btn').click(function(){
              if(!showHoldings){
                $('#holding-btn').addClass('active');
                showHoldings = true;
                showMarkers('holdings');
              }else{
                $('#holding-btn').removeClass('active');
                showHoldings = false;
                hideMarkers('holdings');
              }
            });

            // village bind
            $('#village-btn').click(function(){
              if(!showVillages){
                $('#village-btn').addClass('active');
                showVillages = true;
                showMarkers('villages');
              }else{
                $('#village-btn').removeClass('active');
                showVillages = false;
                hideMarkers('villages');
              }
            });

            //Map Search Bind
            $('#searchmap').click(function(){
              // console.log($('#mapsearch-text').val());
              searchPOIs($('#mapsearch-text').val());
            });

            $('#mapsearch-text').keypress(function(e) {
                if(e.which == 13) {
                    searchPOIs($('#mapsearch-text').val());
                }
            });
        }
    };

    var video = {
      init: function(){
        $('.video h2, .video p').ellipsis();
      }
    };

    var swears = ['fuck','shit','fag',' ass','puss','nigg','bitch','asshole','dick','penis','vagina','cunt'];

    function filterText(text){
      var rgx = new RegExp(swears.join("|"), "gi");
      return text.replace(rgx, "****");
    }

    if($('.post-type-archive-role, .post-type-archive-school, .post-type-archive-spell, .single-school').length)
      schools.init();

    if($('.page-template-archive-video-php').length)
      video.init();

    if($('h2').length)
      $('h2').ellipsis();

    if($('.home').length)
      home.init();

    if($('.clans').length)
      clans.init();

    if($('.feedback').length)
      feedback.init();

    if($('#branding').length)
      server_status.getStatus();

    if($('#map_canvas').length){
      map_initialize(); // in agon.map.js
      map_legend.init();
    }

    if($('.misc-game-info').length){
      $('table').tablesorter({
          widgets: ['zebra']
        });
    }

    $('.gad').each(function(index){
      if($(this).height() === 0){
        $(this).addClass('blocked');
        // $('body').prepend('<div id="anti-ads">You are currently disabling ads. To help support this site, please consider allowing ads to show.<i class="icon-remove icon-white"></i></div>');
        if($(this).data('adType') == 'long') {
          $(this).html('<a href="http://www.gamefanshop.com/partner-IamRedSeal/" target="_blank"><img src="http://www.gamefanshop.com/StoreFiles/Styles/vip/banner1.jpg" alt="gamefanshop partner banner" /></a>');
        }else if($(this).data('adType') == 'square'){
          $(this).html('<a href="http://www.gamefanshop.com/partner-IamRedSeal/" target="_blank"><img src="http://www.gamefanshop.com/StoreFiles/Styles/vip/banner2t.jpg" width="180" alt="gamefanshop partner banner" /></a>');
          // setTimeout(function(){
          //   $('#anti-ads').slideDown();
          // }, 5000);
          // $('#anti-ads').bind('click', function(){
          //   $(this).slideUp();
          // });
        }
      }
    });
}(jQuery));
;//templateDir = var set in header;

(function($){
  window.crafter = {
    skill: '',
    advanced: false,
    mastery: false,
    masteryList: [],
    allItems: [],
    firstDrop: [],
    secDrop: [],
    filteredList: [],
    item: {},
    itemCount: 1,
    style: 'militant',
    getData: function(val){
      crafter.reset();
      crafter.skill = $('#trade_select').val();
      switch(val){
        case 'weaponsmithing':
        //case 'armorsmithing':
        // case 'staffcrafting':
        // case 'shieldcrafting':
        //case 'smelting':
        // case 'tailoring':
        //case 'woodcutting':
        //case 'weaving':
        //case 'tanning':
        //case 'bowyer':
          crafter.advanced = true;
          break;
        default:
          crafter.advanced = false;
      }

      $.ajax({
        url: templateDir + '/data/crafting_recipes_' + val + '.json',
        dataType: 'json'
      }).success(function(data) {
          //console.log('Success', data);
          crafter.allItems = data; //set initial data
          //console.log('Success', crafter.allItems);
          if(crafter.mastery){
            for (var i = 0; i < crafter.allItems.length; i++) {
              if(crafter.allItems[i].Skill.match('Mastery')){
                crafter.masteryList.push(crafter.allItems[i]);
              }
            }
          }
      }, function(){ //callback
        crafter.createList(crafter.firstDrop,crafter.allItems); //create list; (array to fill, data)
      }).error(function(a,b,c){
          alert('Error Loading Items: ',arguments);
        });
    },
    createList: function(list,data){
      //console.log('Creating List');
      data = (crafter.mastery) ? crafter.masteryList : data; //if mastery, switch to mastery list

      for (var i = 0; i < data.length; i++) {

        // if(crafter.mastery && !data[i].Skill.match('Mastery')){
        //   continue; //mastery is set and item is not mastery; skip it
        // }


        if(crafter.advanced){
          var nameArr = data[i].Name.split(" ");
          var item = nameArr[nameArr.length -1];
          if($.inArray(item, list) === -1) { //check if it exists
            list.push(item);
          }
        }else{
          if($.inArray(data[i].Name, list) === -1) { //check if it exists
            list.push(data[i].Name);
          }
        }

      }
      list.sort();
      //console.log('List Sorted');
      crafter.appendList(list,$('#select-two'));
    },
    appendList: function(list,obj){
      var opts = '';
      for (var i = 0; i < list.length; i++) {
        opts = opts + '<option value="' + list[i].toLowerCase() + '">' + list[i] + '</option>';
      }
      obj.html(opts);
      obj.parent().fadeIn().find('input').focus();
    },
    reset: function(){
      //console.log('Crafter Reset');
      crafter.skill = '';
      crafter.advanced = false;
      crafter.masteryList = [];
      crafter.allItems = [];
      crafter.firstDrop = [];
      crafter.secDrop = [];
      crafter.filteredList = [];
      $('#select-three').parent().hide();
      $('#item-details .template').fadeOut('',function(){
        $(this).remove();
      });
    },
    filterList: function(filter){
      //console.log('Filtering List');
      crafter.filteredList = [];
      crafter.secDrop = [];
      var list = (!crafter.mastery) ? crafter.allItems : crafter.masteryList;
      var toMatch = new RegExp('\\b'+$('#select-two').val(),'gi');
      for (var i = 0; i < list.length; i++) {
        if(list[i].Name.match(toMatch)){
          var nameArr = list[i].Name.split(" ");
          var item = nameArr[0];
          if($.inArray(item, crafter.secDrop) === -1) { //check if it exists
            crafter.secDrop.push(item);
          }
          crafter.filteredList.push(list[i]);
        }
        crafter.secDrop.sort();
        crafter.appendList(crafter.secDrop,$('#select-three'));
      }
    },
    showItem: function(item){
      //console.log('Showing Item', item);
      crafter.item = item;
      var newEl = $("#item-template").clone()
                                .attr("id",item.id)
                                .fadeIn("slow");
      newEl.find('#thumb').append('<img src="'+templateDir+'/data/icons/'+item.Icon+'" width="64" height="64"/>');

      var details = '<h3><span class="theName">'+item.Name+'</span></h3><p>';
      details = details + '<strong>Skill:</strong> '+item.Skill+'<br>';
      details = details + '<strong>Min Level:</strong> '+item["Min Level"]+'<br>';
      details = details + '<strong>Max Level:</strong> '+item["Max Level"]+'<br>';
      details = details + '<strong>Quantity:</strong> '+item.Quantity+'<br>';
      details = details + '<ul class="ingredients">';
      for(var prop in item.Recipe){
          details = details + '<li><strong>' + prop + ':</strong> ' + item.Recipe[prop] + '</li>';
      }
      details = details + '</ul></p>';
      newEl.find('.ingredients .details').html(details);

      newEl.find('.recipe .well').html(crafter.calculate(item));

      newEl.find('#item-count').val(crafter.itemCount);

      $('#item-details').removeClass()
                                  .addClass(item.Skill.toLowerCase())
                                  .html(newEl);

      crafter.changeStyle();
    },
    calculate: function(item){
      // var currentName = (crafter.item.Name != $('.theName:first').text() && $('.theName:first').text() != '') ? $('.theName:first').text() : crafter.item.Name;
      var currentName = item.Name;
      var count = $('#item-count').val();
      var html = '<strong>'+ item.Quantity*crafter.itemCount +'</strong> <span class="theName"> ' + currentName + '</span>: ';
      for(var prop in crafter.item.Recipe){
        html = html + count*crafter.item.Recipe[prop] + ' ' + prop;
        if(Object.keys(crafter.item.Recipe)[Object.keys(crafter.item.Recipe).length - 1] != prop){
          html = html + ', ';
        }
      }
      return html;
    },
    changeStyle: function(){
      var theName = $('.theName:first').text();
      var pieces = theName.split(' ');
      for(var i = 0; i < pieces.length; i++){
        if(pieces[i].toLowerCase() == 'militant' || pieces[i].toLowerCase() == 'stoic' || pieces[i].toLowerCase() == 'barbaric'){
          pieces[i] = crafter.style;
        }
      }
      var newName = pieces.join(' ');
      $('.theName').text(newName);

      var theThumb = $('#item-details').find('#thumb img').attr('src');
      theThumb = theThumb.replace('militant',crafter.style).replace('barbaric',crafter.style).replace('stoic',crafter.style);
      $('#item-details').find('#thumb img').attr('src',theThumb);

      $('#item-details .btn-group .btn').removeClass('active');
      $('#item-details .btn[data-style="' + crafter.style + '"]').addClass('active');
    }
  };

  $('#trade_select').change(function(){
    crafter.getData($(this).val());
  });

  $('#select-two').change(function(){
    if(!crafter.advanced){
        var selection = new RegExp('\\b' + $('#select-two').val(),'gi');
        for (var i = 0; i < crafter.allItems.length; i++) {
          if(crafter.allItems[i].Name.match(selection)){
            crafter.showItem(crafter.allItems[i]);
          }
        }
    }else{
      crafter.filterList($(this).find('option:selected').val());
    }
  });

  $('#select-three').change(function(){
    //console.log('Finding Item');
    var selection = new RegExp($('#select-three').val() + '\\s(.*)\\s?\\b' + $('#select-two').val(),'gi');
    if($('#select-three').val() === $('#select-two').val()){
      selection = new RegExp('^'+$('#select-three').val()+'$','i');
    }
    //console.log(selection);
    for (var i = 0; i < crafter.filteredList.length; i++) {
      if(crafter.filteredList[i].Name.match(selection)){
        crafter.showItem(crafter.filteredList[i]);
      }
    }
  });

  $('#mastery').change(function(){
    if($(this).attr('checked') == "checked"){
      crafter.mastery = true;
    }else{
      crafter.mastery = false;
    }
    if($('#trade_select').val() !== ''){
      crafter.getData($('#trade_select').val());
    }
  });

  $('#item-count').live('change',function(){
    crafter.itemCount = $(this).val();
    $('#item-details .recipe .well').html(crafter.calculate(crafter.item));
    crafter.changeStyle();
  });

  $('.btn.styleSwitch').live('click',function(){
    crafter.style = $(this).data('style');
    crafter.changeStyle();
  });

  $('.recipe .well').live('click',function(){
    window.prompt('Copy Recipe',$(this).text());
  });
})(jQuery);


/*********** Utilities **********/

// check if an element exists in array using a comparer function
// comparer : function(currentElement)
Array.prototype.inArray = function(comparer) {
    for(var i=0; i < this.length; i++) {
        if(comparer(this[i])) return true;
    }
    return false;
};

// adds an element to the array if it does not already exist using a comparer
// function
Array.prototype.pushIfNotExist = function(element, comparer) {
    if (!this.inArray(comparer)) {
        this.push(element);
    }
};


/********** Combobox Stuff ***********/

(function( $ ) {
    $.widget( "custom.combobox", {
      _create: function() {
        this.wrapper = $( "<span>" )
          .addClass( "custom-combobox" )
          .insertAfter( this.element );

        this.element.hide();
        this._createAutocomplete();
        this._createShowAllButton();
      },

      _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
          value = selected.val() ? selected.text() : "";

        this.input = $( "<input>" )
          .appendTo( this.wrapper )
          .val( value )
          .attr( "title", "" )
          .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
          .autocomplete({
            delay: 0,
            minLength: 0,
            source: $.proxy( this, "_source" )
          })
          .tooltip({
            tooltipClass: "ui-state-highlight"
          });

        this._on( this.input, {
          autocompleteselect: function( event, ui ) {
            ui.item.option.selected = true;
            this._trigger( "select", event, {
              item: ui.item.option
            });
          },

          autocompletechange: "_removeIfInvalid"
        });
      },

      _createShowAllButton: function() {
        var input = this.input,
          wasOpen = false;

        $( "<div>" )
          .attr( "tabIndex", -1 )
          .attr( "title", "Show All Items" )
          // .tooltip()
          .appendTo( this.wrapper )
          .button({
            icons: {
              primary: "ui-icon-triangle-1-s"
            },
            text: false
          })
          .removeClass( "ui-corner-all" )
          .addClass( "custom-combobox-toggle ui-corner-right" )
          .mousedown(function() {
            wasOpen = input.autocomplete( "widget" ).is( ":visible" );
          })
          .click(function() {
            input.focus();

            // Close if already visible
            if ( wasOpen ) {
              return;
            }

            // Pass empty string as value to search for, displaying all results
            input.autocomplete( "search", "" );
          });
      },

      _source: function( request, response ) {
        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
        response( this.element.children( "option" ).map(function() {
          var text = $( this ).text();
          if ( this.value && ( !request.term || matcher.test(text) ) )
            return {
              label: text,
              value: text,
              option: this
            };
        }) );
      },

      _removeIfInvalid: function( event, ui ) {

        // Selected an item, nothing to do
        if ( ui.item ) {
          return;
        }

        // Search for a match (case-insensitive)
        var value = this.input.val(),
          valueLowerCase = value.toLowerCase(),
          valid = false;
        this.element.children( "option" ).each(function() {
          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
            this.selected = valid = true;
            return false;
          }
        });

        // Found a match, nothing to do
        if ( valid ) {
          return;
        }

        // Remove invalid value
        this.input
          .val( "" )
          .attr( "title", value + " didn't match any item" )
          .tooltip( "open" );
        this.element.val( "" );
        this._delay(function() {
          this.input.tooltip( "close" ).attr( "title", "" );
        }, 2500 );
        this.input.autocomplete( "instance" ).term = "";
      },

      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });
  })( jQuery );

  (function($) {
      $("#trade_select").combobox({
            select: function (event, ui) {
                crafter.getData(this.value);
                $('.selection-box:first').find('input').val('').focus();
            }
        });

      $("#select-two").combobox({
            select: function (event, ui) {
                if(!crafter.advanced){
                    var selection = new RegExp('^\\b' + RegExp.escape(this.value),'gi');
                    // console.log('RegEx: '+ selection);
                    for (var i = 0; i < crafter.allItems.length; i++) {
                      if(crafter.allItems[i].Name.match(selection)){
                        crafter.showItem(crafter.allItems[i]);
                      }
                    }
                }else{
                  crafter.filterList(this.value);
                }
                $('.selection-box:last').find('input').val('').focus();
            }
        });

      $("#select-three").combobox({
            select: function (event, ui) {
                //console.log('Finding Item');
                var selection = new RegExp(this.value + '\\s(.*)\\s?\\b' + $('#select-two').val(),'gi');
                if(this.value === $('#select-two').val()){
                  selection = new RegExp('^'+this.value+'$','i');
                }
                //console.log(selection);
                for (var i = 0; i < crafter.filteredList.length; i++) {
                  if(crafter.filteredList[i].Name.match(selection)){
                    crafter.showItem(crafter.filteredList[i]);
                  }
                }
            }
        });

    // $( "#toggle" ).click(function() {
    //   $( "#combobox" ).toggle();
    // });
  })(jQuery);

RegExp.escape= function(s) {
  return s.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
};
