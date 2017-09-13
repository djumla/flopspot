$(function() {
  $.get("http://localhost:8000/stations", function(data) {
    console.log(data);
    $.each(data, function(index, value) {
      console.log(value.station);
    })
  });
});
