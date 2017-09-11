$(function() {
  $("#datepicker").datepicker({
    dateFormat: "dd.mm.yy",
  });
  $("#datepicker").datepicker("setDate", new Date());
  $('#ui-datepicker-div').hide();

});
