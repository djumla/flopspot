$(function() {
  $('#thumbs-container input[type=radio]').change(function() {
    var currentLabel = $(this).parent();
    $('#thumbs-container label').removeClass("selected");
    currentLabel.addClass("selected");
  });
});
