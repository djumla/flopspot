$(function() {
  function setHeightEqualWidth() {
    $('#flex-thumbs label').each(function(index, value) {
      $(this).height($(this).width());
    });
  }

  setHeightEqualWidth();
  $(window).resize(setHeightEqualWidth);
});
