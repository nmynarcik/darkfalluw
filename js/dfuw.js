jQuery(function($){
    if($(".accordion").length){
      $('.accordion').accordion();
      $(".accordion").tabs(".pane", {tabs: 'h4', effect: 'slide'});
    }

    $('input[placeholder], textarea[placeholder]').placeholder();

    console.log('HOLLA!');
  });
