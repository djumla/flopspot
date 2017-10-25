$(function() {
  function setHeightEqualWidth() {
    $('#flex-thumbs label').each(function(index, value) {
      $(this).height($(this).width());
    });
  }

  function addHeight() {
    var height = $('#tweets').height() / 5;
    var footerHeight = $('#service').height();

    $('#service').height(footerHeight + height);
  }

  //addHeight();
  setHeightEqualWidth();
  $(window).resize(setHeightEqualWidth);
});
