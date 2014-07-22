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
    item: {},
    itemCount: 1,
    style: 'militant',
    getData: function(val){
      crafter.reset();
      crafter.skill = $('#trade_select').val();
      switch(val){
        case 'weaponsmithing':
        case 'armorsmithing':
        // case 'staffcrafting':
        // case 'shieldcrafting':
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
        dataType: 'json'
      }).success(function(data) {
          console.log('Success', data);
          crafter.allItems = data; //set initial data
          console.log('Success', crafter.allItems);
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
          alert('Error Loading Items: ',arguments);
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
      crafter.secDrop = [];
      var list = (!crafter.mastery) ? crafter.allItems : crafter.masteryList;
      var toMatch = new RegExp('\\b'+$('#select-two').val(),'gi');
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
      crafter.item = item;
      var newEl = $("#item-template").clone()
                                .attr("id",item.id)
                                .fadeIn("slow");
      newEl.find('#thumb').append('<img src="'+templateDir+'/data/icons/'+item.Icon+'" width="64" height="64"/>');

      var details = '<h3><span class="theName">'+item.Name+'</span></h3><p>';
      details = details + '<strong>Skill:</strong> '+item.Skill+'<br>';
      details = details + '<strong>Min Level:</strong> '+item["Min Level"]+'<br>';
      details = details + '<strong>Max Level:</strong> '+item["Max Level"]+'<br>';
      details = details + '<ul class="ingredients">';
      for(var prop in item.Recipe){
          details = details + '<li><strong>' + prop + ':</strong> ' + item.Recipe[prop] + '</li>';
      }
      details = details + '</ul></p>';
      newEl.find('.ingredients .details').html(details);

      newEl.find('.recipe .well').html(crafter.calculate(item));

      newEl.find('#item-count').val(crafter.itemCount);

      $('#item-details').removeClass()
                                  .addClass(item.Skill.toLowerCase())
                                  .html(newEl);

      crafter.changeStyle();
    },
    calculate: function(item){
      // var currentName = (crafter.item.Name != $('.theName:first').text() && $('.theName:first').text() != '') ? $('.theName:first').text() : crafter.item.Name;
      var currentName = item.Name;
      var count = $('#item-count').val();
      var html = '<strong>'+ crafter.itemCount +'</strong> <span class="theName"> ' + currentName + '</span>: ';
      for(var prop in crafter.item.Recipe){
        html = html + count*crafter.item.Recipe[prop] + ' ' + prop;
        if(Object.keys(crafter.item.Recipe)[Object.keys(crafter.item.Recipe).length - 1] != prop){
          html = html + ', ';
        }
      }
      return html;
    },
    changeStyle: function(){
      var theName = $('.theName:first').text();
      var pieces = theName.split(' ');
      for(var i = 0; i < pieces.length; i++){
        if(pieces[i].toLowerCase() == 'militant' || pieces[i].toLowerCase() == 'stoic' || pieces[i].toLowerCase() == 'barbaric'){
          pieces[i] = crafter.style;
        }
      }
      var newName = pieces.join(' ');
      $('.theName').text(newName);

      var theThumb = $('#item-details').find('#thumb img').attr('src');
      theThumb = theThumb.replace('militant',crafter.style).replace('barbaric',crafter.style).replace('stoic',crafter.style);
      $('#item-details').find('#thumb img').attr('src',theThumb);

      $('#item-details .btn-group .btn').removeClass('active');
      $('#item-details .btn[data-style="' + crafter.style + '"]').addClass('active');
    }
  }

  $('#trade_select').change(function(){
    crafter.getData($(this).val());
  });

  $('#select-two').change(function(){
    if(!crafter.advanced){
        var selection = new RegExp('\\b' + $('#select-two').val(),'gi');
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
    var selection = new RegExp($('#select-three').val() + '\\s(.*)\\s?\\b' + $('#select-two').val(),'gi');
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

  $('#item-count').live('change',function(){
    crafter.itemCount = $(this).val();
    $('#item-details .recipe .well').html(crafter.calculate(crafter.item));
    crafter.changeStyle();
  });

  $('.btn.styleSwitch').live('click',function(){
    crafter.style = $(this).data('style');
    crafter.changeStyle();
  });

  $('.recipe .well').live('click',function(){
    window.prompt('Copy Recipe',$(this).text());
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
