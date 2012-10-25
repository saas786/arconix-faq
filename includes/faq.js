jQuery(document).ready( function() {
    //Hide (Collapse) the toggle containers on load
    jQuery(".arconix-faq-content").hide();
    //Switch the "Open" and "Close" state per click
    jQuery(".arconix-faq-title").toggle(function(){
        jQuery(this).addClass("active");
        }, function () {
        jQuery(this).removeClass("active");
    });
    //Slide up and down on click
    jQuery(".arconix-faq-title").click(function(){
        jQuery(this).next(".arconix-faq-content").slideToggle();
    });    
    // Expand/Collapse all the FAQ items
    jQuery(".arconix-faq-button").click(function () {
      jQuery("div.arconix-faq-content").each(function(){
        jQuery(this).slideToggle();
      });
    });

});