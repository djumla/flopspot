$(function() {
  $("#train-number").autocomplete({
    source: function(request, response) {
      var max = 6;
      var j = 0;

      $.ajax({
        url: "http://localhost:8000/trainName",
        dataType: "json",
        success: function(data) {
          response($.map(data, function(c) {
            if (j < max && c.name.toLowerCase().indexOf(request.term.toLowerCase()) != -1) {
              j++;
              return {
                label: c.name
              };
            } else {
              return null;
            }
          }));
        }
      });
    },
    select: function(event, ui) {
      $("#train-number").val(ui.item.value);
    }
  });
});
