function rainbow(numOfSteps, step)
{
  var r, g, b;
  var h = step / numOfSteps;
  var i = ~~ (h * 6);
  var f = h * 6 - i;
  var q = 1 - f;
  switch(i % 6)
  {
    case 0:
      r = 1, g = f, b = 0;
      break;
    case 1:
      r = q, g = 1, b = 0;
      break;
    case 2:
      r = 0, g = 1, b = f;
      break;
    case 3:
      r = 0, g = q, b = 1;
      break;
    case 4:
      r = f, g = 0, b = 1;
      break;
    case 5:
      r = 1, g = 0, b = q;
      break;
  }
  var c = "#" + ("00" + (~~ (r * 255)).toString(16)).slice(-2) + ("00" + (~~ (g * 255)).toString(16)).slice(-2) + ("00" + (~~ (b * 255)).toString(16)).slice(-2);
  return(c);
}

function ImageFormatter(row, cell, value, columnDef, dataContext)
{
  return "<img src='" + value + "' style='max-width:100%;max-height:100%' />";
}

function DescriptionFormatter(row, cell, value, columnDef, dataContext)
{
  return "CTRL+C Here";
}

function CheckmarkFormatterStr(row, cell, value, columnDef, dataContext)
{
  return parseInt(value) ? "<img src='"+templateDir+"/images/slickgrid/tick.png'>" : "";
}

function QuantityFormatter(row, cell, value, columnDef, dataContext)
{
  if(parseInt(value) > 1)
  {
    return "<div style='font-weight:bold;'>" + value + "</div>"
  }

  return value
}

var classCount = 0;
function getRandomClass(){
  switch(classCount){
    case 0:
      classCount++;
      return 'item1';
      break;
    case 1:
      classCount++;
      return 'item2';
      break;
    case 2:
      classCount = 0;
      return 'item3';
      break;
  }
}

function AdditionalFormatter(row, cell, value, columnDef, dataContext)
{
  var ingredients = value.split("; ");

  // for(var i = 0; i < ingredients.length; i++)
  // {
  //   var RGB = rainbow(ingredients.length, i);
  //   A = '0.333333';
  //   RGBA = '(' + parseInt(RGB.substring(1, 3), 16) + ',' + parseInt(RGB.substring(3, 5), 16) + ',' + parseInt(RGB.substring(5, 7), 16) + ',' + A + ')';
  //   ingredients[i] = "<span style=\"color: white; background: rgba" + RGBA + "\">" + ingredients[i] + "</span> ";
  // }

  for(var i = 0; i < ingredients.length; i++){
    ingredients[i] = "<span class='"+getRandomClass()+"'>"+ingredients[i]+"</span>";
  }

  var ret = ingredients.join("");
  return ret
}

jQuery.noConflict();
(function($){
  // console.log('crafting init');

  $('select#trade_select').change(function(){
      // createTable($(this).val());
      window.location.hash = $(this).val();
  });

  $(window).on('hashchange', function() {
    var csv = window.location.hash.substr(1);
    createTable(csv);
    $('select#trade_select').val(csv);
  });

  setTimeout(function(){
    if(window.location.hash === ''){
      window.location.hash = 'alchemy';
      $('select#trade_select').val('alchemy');
    }else{
      var csv = window.location.hash.substr(1);
      createTable(csv);
      $('select#trade_select').val(csv);
    }
  },2000);

})(jQuery);

function createTable(csv){
  var cb = new Date().getTime();
  jQuery.get(templateDir+'/data/crafting_recipes_'+csv+'.csv?cb='+cb, function (data)
  {
    var columnFilters = {};
    var alchemyGrid;
    var headers = data.split('\n')[0].replace(/[\n\r]/g,'').split(',');

    var columns = [];

    for(var i=1; i<headers.length;i++){
      var headerObj = {
        id: headers[i].toLowerCase().replace(' ',''),
        name: headers[i],
        field: headers[i],
        sortable: true,
        width: 150,
        editor: Slick.Editors.Text,
        headerCssClass: headers[i].toLowerCase().replace(' ','')
      }
      switch(headerObj.id){
        case 'copypasta':
          headerObj.formatter = DescriptionFormatter;
          break;
        case 'icon':
          headerObj.formatter = ImageFormatter;
          headerObj.width = 64;
          break;
        case 'quantity':
          headerObj.formatter = QuantityFormatter;
          headerObj.width = 75;
          break;
        case 'emptybottle':
          headerObj.formatter = CheckmarkFormatterStr;
          headerObj.width = 75;
          break;
        case 'additional':
          headerObj.formatter = AdditionalFormatter;
          headerObj.width = 300;
          break;
        case 'minlevel':
        case 'maxlevel':
        case 'gold':
        case 'ironingot':
        case 'leather':
        case 'wood':
        case 'potato':
        case 'onion':
        case 'carrot':
        case 'meat':
        case 'spices':
        case 'bass':
        case 'cod':
        case 'blackpowder':
        case 'steedgrass':
        case 'inferioranima':
        case 'cloth':
        case 'shipmodule':
        case 'ironore':
        case 'sulfur':
        case 'rawhide':
        case 'nacre':
        case 'cotton':
        case 'mandrake':
        case 'timber':
        case 'resin':
          headerObj.width = 50;
          break;
      }
      columns.push(headerObj);
    }

    // console.log(columns);


    var options = {
      enableCellNavigation: true,
      enableColumnReorder: true,
      multiColumnSort: false,
      headerRowHeight: 30,
      explicitInitialization: true,
      showHeaderRow: true,
      rowHeight: 64
    };

    var result = jQuery.csv.toObjects(data)

    craftingDataView = new Slick.Data.DataView();
    craftingDataView.beginUpdate();
    craftingDataView.setItems(result);
    craftingDataView.setFilter(filter);
    craftingDataView.endUpdate();

    var craftingGrid = new Slick.Grid("#craftingGrid", craftingDataView, columns, options);

    function filter(item)
    {
      for(var columnId in columnFilters)
      {
        if(columnId !== undefined && columnFilters[columnId] !== "")
        {
          var c = craftingGrid.getColumns()[craftingGrid.getColumnIndex(columnId)];

          var filterTxt = columnFilters[columnId].toLowerCase();

          var isGT = false;
          if(filterTxt.charAt(0) == ">")
          {
            isGT = true;
            filterTxt = filterTxt.substring(1);
          }

          var isLT = false;
          if(filterTxt.charAt(0) == "<")
          {
            isLT = true;
            filterTxt = filterTxt.substring(1);
          }

          var isNumber = false;
          if(isFinite(item[c.field]))
            isNumber = true;

          if(!isNumber && item[c.field].toLowerCase().indexOf(columnFilters[columnId].toLowerCase()) == -1)
            return false;
          else if(isNumber && isGT && parseFloat(filterTxt) >= parseFloat(item[c.field].toLowerCase()))
            return false;
          else if(isNumber && isLT && parseFloat(filterTxt) <= parseFloat(item[c.field].toLowerCase()))
            return false;
          else if(isNumber && !isGT && !isLT && item[c.field].toLowerCase() != filterTxt)
            return false;
        }
      }
      return true;
    }

    craftingDataView.onRowCountChanged.subscribe(function (e, args)
    {
      craftingGrid.updateRowCount();
      craftingGrid.render();
    });

    craftingDataView.onRowsChanged.subscribe(function (e, args)
    {
      craftingGrid.invalidateRows(args.rows);
      craftingGrid.render();
    });

    var currentSortCmp = null;
    craftingGrid.onSort.subscribe(function (e, args)
    {
      var field = args.sortCol.field;
      var sign = args.sortAsc ? 1 : -1;
      var prevSortCmp = currentSortCmp;

      currentSortCmp = function (dataRow1, dataRow2)
      {
        var value1 = dataRow1[field],
          value2 = dataRow2[field];

        if(value1 == value2 && prevSortCmp) return prevSortCmp(dataRow1, dataRow2);

        if(!isFinite(value1) || !isFinite(value2)) return(value1 == value2 ? 0 : (value1 > value2 ? 1 : -1)) * sign;
        else return(parseFloat(value1) == parseFloat(value2) ? 0 : (parseFloat(value1) > parseFloat(value2) ? 1 : -1)) * sign;
      };

      craftingDataView.sort(currentSortCmp);
      craftingGrid.invalidate();
      craftingGrid.render();
    });

    jQuery(craftingGrid.getHeaderRow()).delegate(":input", "change keyup", function (e)
    {
      var columnId = jQuery(this).data("columnId");
      if(columnId != null)
      {
        columnFilters[columnId] = jQuery.trim(jQuery(this).val());
        craftingDataView.refresh();
      }
    });

    craftingGrid.onHeaderRowCellRendered.subscribe(function (e, args)
    {
      if(args.column.id != "icon" && args.column.id != "copypasta")
      {
        jQuery(args.node).empty();
        jQuery("<input class='filter' type='text'>")
          .data("columnId", args.column.id)
          .val(columnFilters[args.column.id])
          .appendTo(args.node);
      }
    });

    craftingGrid.init();
    craftingGrid.setSelectionModel(new Slick.CellSelectionModel());
    craftingGrid.registerPlugin(new Slick.AutoTooltips());
    craftingGrid.getCanvasNode().focus();
    craftingGrid.registerPlugin(new Slick.CellExternalCopyManager());

    jQuery('input.filter').attr('placeholder','Filter');
  });
}
