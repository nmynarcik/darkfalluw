//templateDir = var set in header;

(function($){
  var crafter = {
    allItems: {},
    getData: function(val){
      $.ajax({
        url: templateDir + '/data/crafting_recipes_' + val + '.json',
      }).done(function(data) {
          console.log('Success', data);
          crafter.allItems = data;
      }, function(){crafter.createList();}).error(function(a,b,c){
          console.log('Error on Item Load: ',arguments);
        });
    },
    createList: function(){
      console.log('BOOYA!',this);
    }
  }

  $('#trade_select').change(function(){
    crafter.getData($(this).find('option:selected').val());
  });
})(jQuery);
