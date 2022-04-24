
jQuery(document).ready( function($) {
  
//    $('.wcd-gallery-image').featherlightGallery({
//        gallery: {
//            fadeIn: 300,
//    		fadeOut: 300
//        },
//            openSpeed: 300,
//            closeSpeed: 300
//    });
//    
//    var p = $(".wcd-horizontal-gallery").portfolio();
//    p.init();
//    
//    $(function () {
//	$('.beforeafter').qbeforeafter({defaultgap:50, leftgap:0, rightgap:0, caption: true, reveal: 0.5});
//    });
//    
//    $(".panorama").panorama_viewer({
//    repeat: false,
//    direction: "horizontal",
//    animationTime: 700,
//    easing: "ease-out",
//    overlay: true
//    });
//    
//     $(".panorama.false").panorama_viewer({
//    repeat: false,
//    direction: "horizontal",
//    animationTime: 700,
//    easing: "ease-out",
//    overlay: true
//    });
//    
//    $(".panorama.horizontal.false").panorama_viewer({
//    repeat: false,
//    direction: "horizontal",
//    animationTime: 700,
//    easing: "ease-out",
//    overlay: true
//    });
//    
//    $(".panorama.true").panorama_viewer({
//    repeat: true,
//    direction: "horizontal",
//    animationTime: 700,
//    easing: "ease-out",
//    overlay: true
//    });
//    
//     $(".panorama.horizontal").panorama_viewer({
//    repeat: false,
//    direction: "horizontal",
//    animationTime: 700,
//    easing: "ease-out",
//    overlay: true
//    });
//    
//    $(".panorama.horizontal.true").panorama_viewer({
//    repeat: true,
//    direction: "horizontal",
//    animationTime: 700,
//    easing: "ease-out",
//    overlay: true
//    });
//
//    $(".panorama.vertical").panorama_viewer({
//    repeat: false,
//    direction: "vertical",
//    animationTime: 700,
//    easing: "ease-out",
//    overlay: true
//    });
//    
//     $(".panorama.vertical.false").panorama_viewer({
//    repeat: false,
//    direction: "vertical",
//    animationTime: 700,
//    easing: "ease-out",
//    overlay: true
//    });
//    
//    $(".panorama.vertical.true").panorama_viewer({
//    repeat: true,
//    direction: "vertical",
//    animationTime: 700,
//    easing: "ease-out",
//    overlay: true
//    });
//	
//	$('.print').click(function() {
//		var container = $(this).attr('rel');
//		$('#' + container).printArea();
//		return false;
//	});   
//
//    $('.print-item').draggable({ snap: true });
//    $('.recycle').droppable({
//        hoverClass: "ui-state-active",
//        over: function(event, ui) {
//            ui.draggable.remove();
//        }
//    });
//    
//    $("#gallery").unitegallery({
//       tiles_type:"justified"
//	});
//    
//    $( ".wcd-horizontal-image" ).css( "height", $( ".wcd-horizontal-gallery" ) .height() + "px" );  

    
});

jQuery(window).load( function() {

//    jQuery('.wcd-masonry').masonry({
//    "itemSelector": ".wcd-masonry-gallery",
//    "columnWidth": ".grid-sizer",
//    });
    
//    jQuery(".print-gallery-image").on('click', function(){
//    	jQuery(this).toggleClass("checked");
//    });
    //jQuery(".print-gallery-image").addClass("checked");
    
   
   jQuery( "a.printBtn" ).attr( "href", "javascript:void( 0 )" ).click( function(){
       jQuery( ".printable" ).print();
         return( false );
    });

});