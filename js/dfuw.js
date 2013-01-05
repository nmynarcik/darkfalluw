(function($){
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
    }

    var clans = {
      init: function(){
        $("#clans-list").tablesorter({
          widgets: ['zebra']
        });

        $('#server_select').change(function(){
          window.location = '../'+$(this).val();
        });
      }
    }

    var home = {

      init: function(){

        $('#df-vid').attr('src','http://www.youtube.com/embed/'+$('#featured-list li:first-child a').data('vidId')+'?rel=0&autoplay=0&iv_load_policy=3&modestbranding=1&wmode=opaque');

        $('#featured-list li a').on({
          'click':function(){
            var $id = $(this).data('vidId');
            $('#df-vid').attr('src','http://www.youtube.com/embed/'+$id+'?rel=0&autoplay=1&iv_load_policy=3&modestbranding=1&wmode=opaque');
          }
        });

        $('.bottom .blogfeed a, .bottom .eventfeed a, .forumfeed li a, .forumfeed li .descr').ellipsis();

        home.getForumFallFeed();
      },

      getForumFallFeed: function(){
        $('.load-wrapper').stop(true,true).fadeIn('fast');
        $.ajax({
            url: 'wp-content/themes/darkfalluw/proxy.php?url=http://forums.darkfallonline.com/external.php?type=RSS2', //DF Forums
            dataType: 'xml',
            async: false,
            type: 'GET',
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
              $('.bottom .forumfeed').append(list);
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
    }

    var server_status = {
      getStatus: function(){
        $.ajax({
          url: templateDir+'/serverstatus.php',
          dataType: 'json',
          success: function(data){
            $('#server-status').find('span i').removeClass('up down');
              for (var key in data) {
                if (data.hasOwnProperty(key)) {
                  $('#server-status').find('.'+key).find('i').addClass(data[key]);
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
    }

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
    }

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
        }
    }

    var video = {
      init: function(){
        $('.video h2, .video p').ellipsis();
      }
    }

    var swears = ['fuck','shit','fag',' ass','puss','nigg','bitch','asshole','dick','penis','vagina'];

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
}(jQuery));
