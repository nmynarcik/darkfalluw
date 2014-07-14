//templateDir = var set in header;

(function($){
  window.crafter = {
    skill: '',
    advanced: false,
    mastery: false,
    masteryList: [],
    allItems: [],
    firstDrop: [],
    secDrop: [],
    filteredList: [],
    getData: function(val){
      crafter.reset();
      crafter.skill = $('#trade_select').val();
      switch(val){
        case 'weaponsmithing':
        case 'armorsmithing':
        case 'staffcrafting':
        case 'shieldcrafting':
        case 'smelting':
        case 'tailoring':
        case 'woodcutting':
        case 'weaving':
        case 'tanning':
        case 'bowyer':
          crafter.advanced = true;
          break;
        default:
          crafter.advanced = false;
      }

      $.ajax({
        url: templateDir + '/data/crafting_recipes_' + val + '.json',
      }).done(function(data) {
          console.log('Success', data);
          crafter.allItems = data; //set initial data
          if(crafter.mastery){
            for (var i = 0; i < crafter.allItems.length; i++) {
              if(crafter.allItems[i].Skill.match('Mastery')){
                crafter.masteryList.push(crafter.allItems[i]);
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
      data = (crafter.mastery) ? crafter.masteryList : data; //if mastery, switch to mastery list

      for (var i = 0; i < data.length; i++) {

        // if(crafter.mastery && !data[i].Skill.match('Mastery')){
        //   continue; //mastery is set and item is not mastery; skip it
        // }


        if(crafter.advanced){
          var nameArr = data[i].Name.split(" ");
          var item = nameArr[nameArr.length -1];
          if($.inArray(item, list) === -1) { //check if it exists
            list.push(item);
          }
        }else{
          if($.inArray(data[i].Name, list) === -1) { //check if it exists
            list.push(data[i].Name);
          }
        }

      };
      list.sort();
      console.log('List Sorted');
      crafter.appendList(list,$('#select-two'));
    },
    appendList: function(list,obj){
      var opts = '<option val="">Select One</option>';
      for (var i = 0; i < list.length; i++) {
        opts = opts + '<option value="' + list[i].toLowerCase() + '">' + list[i] + '</option>';
      };
      obj.html(opts);
      obj.fadeIn();
    },
    reset: function(){
      console.log('Crafter Reset');
      crafter.skill = '';
      crafter.advanced = false;
      crafter.masteryList = [];
      crafter.allItems = [];
      crafter.firstDrop = [];
      crafter.secDrop = [];
      crafter.filteredList = [];
      $('#select-three').hide();
    },
    filterList: function(filter){
      console.log('Filtering List');
      crafter.filteredList = [];
      var list = (!crafter.mastery) ? crafter.allItems : crafter.masteryList;
      var toMatch = new RegExp($('#select-two').val(),'gi');
      for (var i = 0; i < list.length; i++) {
        if(list[i].Name.match(toMatch)){
          var nameArr = list[i].Name.split(" ");
          var item = nameArr[0];
          if($.inArray(item, crafter.secDrop) === -1) { //check if it exists
            crafter.secDrop.push(item);
          }
          crafter.filteredList.push(list[i]);
        }
        crafter.secDrop.sort();
        crafter.appendList(crafter.secDrop,$('#select-three'));
      };
    },
    showItem: function(item){
      console.log('Showing Item', item);
      var newEl = $("#item-template").clone()
                                .attr("id",item.id)
                                .fadeIn("slow");
      newEl.find('#thumb').append('<img src="'+item.Icon+'"/>');
      newEl.find('textarea').html(item['Copy Pasta']);
      newEl.find('.well').html('<h3>'+item.Name+'</h3>');
      $('#item-details').html(newEl);
    }
  }

  $('#trade_select').change(function(){
    crafter.getData($(this).val());
  });

  $('#select-two').change(function(){
    if(!crafter.advanced){
        var selection = new RegExp($('#select-two').val(),'gi');
        for (var i = 0; i < crafter.allItems.length; i++) {
          if(crafter.allItems[i].Name.match(selection)){
            crafter.showItem(crafter.allItems[i]);
          }
        };
    }else{
      crafter.filterList($(this).find('option:selected').val());
    }
  });

  $('#select-three').change(function(){
    console.log('Finding Item');
    var selection = new RegExp($('#select-three').val() + '\\s(.*)\\s?' + $('#select-two').val(),'gi');
    if($('#select-three').val() === $('#select-two').val()){
      selection = new RegExp('^'+$('#select-three').val()+'$','i');
    }
    console.log(selection);
    for (var i = 0; i < crafter.filteredList.length; i++) {
      if(crafter.filteredList[i].Name.match(selection)){
        crafter.showItem(crafter.filteredList[i]);
      }
    };
  });

  $('#mastery').change(function(){
    if($(this).attr('checked') == "checked"){
      crafter.mastery = true;
    }else{
      crafter.mastery = false;
    }
    if($('#trade_select').val() != ''){
      crafter.getData($('#trade_select').val());
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
