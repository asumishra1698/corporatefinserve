jQuery(document).ready(function () {
    setTimeout(function () {
      jQuery("#staticBackdrop").modal("show");
    }, 5000);
  });

  $(window).on("scroll", function () {
    var scrollTop = $(window).scrollTop();
    
    // Use the ID selector to target the specific section
    if (scrollTop > 50) {
      $("#navbarSection").css({
        position: "fixed",
        top: "0",
        width: "100%",
        zIndex: "999"
      });
    } else {
      $("#navbarSection").css({
        position: "relative",
        top: "auto",
        zIndex: "auto"
      });
    }
  }); 