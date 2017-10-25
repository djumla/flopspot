$(function() {
  /**
   * The class selected will change the current chosen thumbs opacity.
   */

  $('#flex-thumbs input[type=radio]').change(function() {
    var currentLabel = $(this).parent();
    $('#flex-thumbs label').removeClass("selected");
    currentLabel.addClass("selected");
  });
});
