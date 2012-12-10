jQuery(function(){

     var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-19670756-11']);
    _gaq.push(['_trackPageview']);

    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();


    (function (tos) {
      window.setInterval(function () {
        tos = (function (t) {
          return t[0] == 50 ? (parseInt(t[1]) + 1) + ':00' : (t[1] || '0') + ':' + (parseInt(t[0]) + 10);
        })(tos.split(':').reverse());
        window.pageTracker ? pageTracker._trackEvent('Time', 'Log', tos) : _gaq.push(['_trackEvent', 'Time', 'Log', tos]);
      }, 10000);
    })('00');

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

});

