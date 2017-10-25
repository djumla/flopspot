$(function() {
  // Without that function, the height of all thumbs would be too low to acutally see the full image.
  function setHeightEqualWidth() {
    $('#flex-thumbs label').each(function(index, value) {
      $(this).height($(this).width());
    });
  }

  setHeightEqualWidth();

  $(window).resize(setHeightEqualWidth);
});
