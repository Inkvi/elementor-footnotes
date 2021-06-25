( function( $ ) {     
    // Make sure you run this code under Elementor.
    $( window ).on( 'elementor/frontend/init', function() {    
      $(document).ready(function(){
        jQuery.bigfoot({
          anchorPattern: /fnblue[:\-_\d]/gi,
          scope: ".blue-footnote-container",
          footnoteParentClass: "footnoteParentClass",
          numberResetSelector: "body",
          buttonMarkup: "<div class='bigfoot-footnote__container'> <button class=\"bigfoot-footnote__button blue\" id=\"{{SUP:data-footnote-backlink-ref}}\" data-footnote-number=\"{{FOOTNOTENUM}}\" data-footnote-identifier=\"{{FOOTNOTEID}}\" alt=\"See Footnote {{FOOTNOTENUM}}\" rel=\"footnote\" data-bigfoot-footnote=\"{{FOOTNOTECONTENT}}\"> <svg class=\"bigfoot-footnote__button__circle\" viewbox=\"0 0 6 6\" preserveAspectRatio=\"xMinYMin\"><circle r=\"3\" cx=\"3\" cy=\"3\" fill=\"white\"></circle></svg> <svg class=\"bigfoot-footnote__button__circle\" viewbox=\"0 0 6 6\" preserveAspectRatio=\"xMinYMin\"><circle r=\"3\" cx=\"3\" cy=\"3\" fill=\"white\"></circle></svg> <svg class=\"bigfoot-footnote__button__circle\" viewbox=\"0 0 6 6\" preserveAspectRatio=\"xMinYMin\"><circle r=\"3\" cx=\"3\" cy=\"3\" fill=\"white\"></circle></svg> </button></div>",          
        });	
        
        
        jQuery.bigfoot({
          anchorPattern: /fnyellow[:\-_\d]/gi,
          scope: ".yellow-footnote-container",					
          footnoteParentClass: "footnoteParentClass",          
          numberResetSelector: "body",		
          buttonMarkup: "<div class='bigfoot-footnote__container'> <button class=\"bigfoot-footnote__button yellow\" id=\"{{SUP:data-footnote-backlink-ref}}\" data-footnote-number=\"{{FOOTNOTENUM}}\" data-footnote-identifier=\"{{FOOTNOTEID}}\" alt=\"See Footnote {{FOOTNOTENUM}}\" rel=\"footnote\" data-bigfoot-footnote=\"{{FOOTNOTECONTENT}}\"> <svg class=\"bigfoot-footnote__button__circle\" viewbox=\"0 0 6 6\" preserveAspectRatio=\"xMinYMin\"><circle r=\"3\" cx=\"3\" cy=\"3\" fill=\"white\"></circle></svg> <svg class=\"bigfoot-footnote__button__circle\" viewbox=\"0 0 6 6\" preserveAspectRatio=\"xMinYMin\"><circle r=\"3\" cx=\"3\" cy=\"3\" fill=\"white\"></circle></svg> <svg class=\"bigfoot-footnote__button__circle\" viewbox=\"0 0 6 6\" preserveAspectRatio=\"xMinYMin\"><circle r=\"3\" cx=\"3\" cy=\"3\" fill=\"white\"></circle></svg> </button></div>",
        });	
        
          jQuery.bigfoot({
          anchorPattern: /fngrey[:\-_\d]/gi,		
          scope: ".grey-footnote-container",			
          numberResetSelector: "body",
          footnoteParentClass: "footnoteParentClass",          
          buttonMarkup: "<div class='bigfoot-footnote__container'> <button class=\"bigfoot-footnote__button grey\" id=\"{{SUP:data-footnote-backlink-ref}}\" data-footnote-number=\"{{FOOTNOTENUM}}\" data-footnote-identifier=\"{{FOOTNOTEID}}\" alt=\"See Footnote {{FOOTNOTENUM}}\" rel=\"footnote\" data-bigfoot-footnote=\"{{FOOTNOTECONTENT}}\"> <svg class=\"bigfoot-footnote__button__circle\" viewbox=\"0 0 6 6\" preserveAspectRatio=\"xMinYMin\"><circle r=\"3\" cx=\"3\" cy=\"3\" fill=\"white\"></circle></svg> <svg class=\"bigfoot-footnote__button__circle\" viewbox=\"0 0 6 6\" preserveAspectRatio=\"xMinYMin\"><circle r=\"3\" cx=\"3\" cy=\"3\" fill=\"white\"></circle></svg> <svg class=\"bigfoot-footnote__button__circle\" viewbox=\"0 0 6 6\" preserveAspectRatio=\"xMinYMin\"><circle r=\"3\" cx=\"3\" cy=\"3\" fill=\"white\"></circle></svg> </button></div>"
          });	  
      });
            
    } );
  } )( jQuery );