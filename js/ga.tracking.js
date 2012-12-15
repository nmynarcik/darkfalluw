(function($){

    // add if(_gaq)
    // $('a').click(function(){
    //     var label = ($(this).attr('title') != undefined) ? $(this).attr('title').replace(' ', '') : $(this).text().replace(' ', '');
    //     var cat = 'Buttons/Links';
    //     _gaq.push(['_trackEvent', 'Buttons/Links', 'click', label]);
    //   });

   var pageURL = window.location.pathname;
  var linkText;

  $('a').click(function (e) {
      if ($(this).text() != ""){
            linkText = $(this).text();
      }
      else if (($(this).text() === "") && ($(this).children("img") != "") && ($(this).children("img").attr("alt") != "")) {
            linkText = $(this).children("img").attr("alt");
      }
      else if (($(this).text() === "") && ($(this).children("img") != "") && ($(this).children("img").attr("alt") === "")) {
            linkText = $(this).children("img").attr("src").split("/").pop();
      }
      _gaq.push(['_trackEvent', pageURL, 'click', linkText]);
      if (($(this).attr('target') != '_blank') || ($(this).attr('target') != '#')) {
                e.preventDefault();
                setTimeout('document.location = "' + $(this).attr('href') + '"', 150);
          }
      });
    // $('select').change(function(){
    //   var cat = 'Select';
    //   var label = $(this).val();
    //   var pieces = label.split('/');
    //   var optVal = window.location.pathname;
    //   _gaq.push(['_trackEvent', cat,'click', pieces[pieces.length -  2], optVal]);
    // });

}(jQuery));

