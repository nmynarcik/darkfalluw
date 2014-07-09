//templateDir = var set in header;

(function($){
  window.crafter = {
    skill: '',
    mastery: false,
    allItems: {},
    firstDrop: [],
    secDrop: [],
    filteredList: [],
    getData: function(val){
      crafter.reset();
      $.ajax({
        url: templateDir + '/data/crafting_recipes_' + val + '.json',
      }).done(function(data) {
          console.log('Success', data);
          crafter.allItems = data; //set initial data
          crafter.mastery = $('#mastery').attr('checked') == 'checked';
          if(crafter.mastery){
            for (var i = 0; i < crafter.allItems.length; i++) {
              if(crafter.allItems[i]['Min Level'] >= 100){
                crafter.filteredList.push(crafter.allItems[i]);
              }
            };
          }
      }, function(){ //callback
        crafter.createList(crafter.firstDrop,crafter.allItems); //create list; (array to fill, data)
      }).error(function(a,b,c){
          console.log('Error on Item Load: ',arguments);
        });
    },
    createList: function(list,data){
      console.log('Creating List');
      if(crafter.filteredList.length > 0){
        data = crafter.filteredList;
      }
      for (var i = 0; i < data.length; i++) {
        var nameArr = data[i].Name.split(" ");
        var item = nameArr[nameArr.length -1];
        if($.inArray(item, list) === -1) { //check if it exists
          list.push(item);
        }
      };
      list.sort();
      crafter.appendList(list,$('#select-two'));
      console.log('List Sorted');
    },
    appendList: function(list,obj){
      var opts = '<option val="">Select One</option>';
      for (var i = 0; i < list.length; i++) {
        opts = opts + '<option value=" ' + list[i].toLowerCase() + ' ">' + list[i] + '</option>';
      };
      obj.html(opts);
      obj.fadeIn();
    },
    reset: function(){
      console.log('Crafter Reset');
      crafter.allItems = {};
      crafter.firstDrop = [];
      crafter.secDrop = [];
      crafter.filteredList = [];
    },
    filterList: function(filter){
      var list = (!crafter.mastery) ? crafter.allItems : crafter.filteredList;
    },
    showItem: function(){
      var selection = new RegEx($('#select-two').val() + '\\s(.*)\\s?' + $('#select-three').val(),'gi');
    }
  }

  $('#trade_select').change(function(){
    crafter.skill = $(this).find('option:selected').val();
    crafter.getData(crafter.skill);
  });

  $('#select-two').change(function(){
    switch(crafter.skill){
      case 'cooking':
        crafter.showItem();
        break;
      default:
        crafter.filterList($(this).find('option:selected').val());
    }
  });
})(jQuery);


/*********** Utilities **********/

// check if an element exists in array using a comparer function
// comparer : function(currentElement)
Array.prototype.inArray = function(comparer) {
    for(var i=0; i < this.length; i++) {
        if(comparer(this[i])) return true;
    }
    return false;
};

// adds an element to the array if it does not already exist using a comparer
// function
Array.prototype.pushIfNotExist = function(element, comparer) {
    if (!this.inArray(comparer)) {
        this.push(element);
    }
};
