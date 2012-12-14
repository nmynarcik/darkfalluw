(function($){

    // add if(_gaq)
    $('a').click(function(){
        var label = ($(this).attr('title') != undefined) ? $(this).attr('title').replace(' ', '') : $(this).text().replace(' ', '');
        var cat = 'Buttons/Links';
        var optVal = window.location.pathname;
        _gaq.push(['_trackEvent', cat, 'click', label, optVal]);
      });

    $('select').change(function(){
      var cat = $(this).attr('id');
      var label = $(this).val();
      var pieces = label.split('/');
      var optVal = window.location.pathname;
      _gaq.push(['_trackEvent', cat,'click', pieces[pieces.length -  2], optVal]);
    });

}(jQuery));

