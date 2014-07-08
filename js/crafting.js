(function($){
  var crafter = {
    getData: function(val){
      console.log('GetData:',val);
    }
  }

  $('#trade_select').change(function(){
    crafter.getData($(this).find('option:selected').val());
  });
})(jQuery);
