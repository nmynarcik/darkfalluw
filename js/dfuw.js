(function($){
    if($(".accordion").length){
      $('.accordion').accordion({ collapsible: true });
      //$(".accordion").tabs(".pane", {tabs: 'h4', effect: 'slide'});
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
          $('#school_selector').change(function(){
            window.location = $(this).val();
          });
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

        $('.bottom .blogfeed .entry-content p, .bottom .eventfeed a, .forumfeed li a, .forumfeed li .descr').ellipsis();

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
                  list += '<li><a href="'+$(this).find('link').text()+'" target="_blank"><span class="title">'+filterText($(this).find('title').text())+'</span></a> <div class="descr">'+filterText($(this).find('description').text())+'</div></li>';
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
              console.log('error: ',arguments, textStatus, errorThrown);
              $('.loading, .loader').stop(true,true).fadeOut();
                setTimeout(function(){
                  home.getForumFallFeed();
                }, 180000);
            }
          });
      }
    }

    var feedback = {
      init: function(){
        $('.your-subject').change(function(){
          if($('.your-subject option:selected').val() == "Add My Clan"){
            $('.feedback .clan-details').slideDown();
          }else{
            $('.feedback .clan-details').slideUp();
          }
        });
      }
    }

    var video = {
      init: function(){
        $('.video h2, .video p').ellipsis();
      }
    }

    var swears = ['fuck','shit','fag',' ass','pussy','pussies','nigger','nigga','bitch','asshole','dick','penis','vagina'];

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
}(jQuery));
