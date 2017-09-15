$(function() {
  $("#entrance").autocomplete({
    source: function(request, response) {
      var max = 6;
      var j = 0;

      $.ajax({
        url: "http://localhost:8000/stations",
        dataType: "json",
        success: function(data) {
          response($.map(data, function(c) {
            if (j < max && c.station.toLowerCase().indexOf(request.term.toLowerCase()) != -1) {
              j++;
              return {
                label: c.station
              };
            } else {
              return null;
            }
          }));
        }
      });
    },
    select: function(event, ui) {
      $("#entrance").val(ui.item.value);
    }
  });

  $("#exit").autocomplete({
    source: function(request, response) {
      var max = 6;
      var j = 0;

      $.ajax({
        url: "http://localhost:8000/stations",
        dataType: "json",
        success: function(data) {
          response($.map(data, function(c) {
            if (j < max && c.station.toLowerCase().indexOf(request.term.toLowerCase()) != -1) {
              j++;
              return {
                label: c.station
              };
            } else {
              return null;
            }
          }));
        }
      });
    },
    select: function(event, ui) {
      $("#exit").val(ui.item.value);
    }
  });
});
