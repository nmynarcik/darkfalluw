jQuery(function($){
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

    var home = {

      init: function(){
        // $.ajax({
        //   url: 'wp-content/themes/darkfalluw/proxy.php?url=http://www.darkfallonline.com/blog/?feed=rss2',
        //   dataType: 'xml',
        //   async: false,
        //   type: 'GET',
        //   success: function(data){
        //       var list = "<ul>";
        //       $(data).find('item').each(function(){
        //         list += '<li>'+$(this).find('title').text()+'</li>';
        //       });
        //       list += '</ul>';
        //     $('.bottom .blogfeed').append(list);
        //   },
        //   error: function(jqXHR, textStatus, errorThrown){
        //     console.log('error: ',arguments, textStatus, errorThrown);
        //   }
        // });

        $('#df-vid').attr('src','http://www.youtube.com/embed/'+$('#featured-list li:first-child a').data('vidId')+'?rel=0');

        $('#featured-list li a').on({
          'click':function(){
            var $id = $(this).data('vidId');
            $('#df-vid').attr('src','http://www.youtube.com/embed/'+$id+'?rel=0');
          }
        });

        $('.bottom .blogfeed ul li, .bottom .eventfeed a').ellipsis();
      }
    }

    var video = {
      init: function(){
        $('.video h2, .video p').ellipsis();
      }
    }

    if($('.post-type-archive-role, .post-type-archive-school, .post-type-archive-spell, .single-school').length)
      schools.init();

    if($('.page-template-archive-video-php').length)
      video.init();

    if($('h2').length)
      $('h2').ellipsis();

    if($('.home').length)
      home.init();
});
