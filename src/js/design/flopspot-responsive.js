$(function() {
  function setHeightEqualWidth() {
    $('#thumbs-container label').each(function(index, value) {
      $(this).height($(this).width());
    });
  }

  function setHeightEqualWidthOnResize() {
    $(window).resize(setHeightEqualWidth);
  }

  setHeightEqualWidth();
  setHeightEqualWidthOnResize();
});
