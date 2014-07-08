(function($){

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

    //Dramatically decrease bounce rate
  function removeEvents() {
        document.body.removeEventListener('click', sendInteractionEvent);
        window.removeEventListener('scroll', sendInteractionEvent);
    }

    function sendInteractionEvent() {
        _gaq.push(['_trackEvent', 'Page Interaction', 'event']);
        removeEvents();
    }

    document.body.addEventListener('click', sendInteractionEvent);
    window.addEventListener('scroll', sendInteractionEvent);

}(jQuery));

