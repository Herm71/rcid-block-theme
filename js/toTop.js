
document.addEventListener('DOMContentLoaded', function () {
  var offset = 100;
  var speed = 250;
  var duration = 500;
  var topButton = document.querySelector('.topbutton');

  function handleScroll() {
    if (window.scrollY < offset) {
      topButton.style.opacity = 0;
    } else {
      topButton.style.opacity = 1;
    }
  }

  function scrollToTop() {
    var scrollStep = -window.scrollY / (speed / 15);
    var scrollInterval = setInterval(function () {
      if (window.scrollY !== 0) {
        window.scrollBy(0, scrollStep);
      } else {
        clearInterval(scrollInterval);
      }
    }, 15);
  }

  window.addEventListener('scroll', handleScroll);

  topButton.addEventListener('click', function () {
    scrollToTop();
  });
});
