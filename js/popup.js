PF_Content_Popup = {};

(function($){

$(document).ready(function(){
	
	$('a[data-popup]').each(function(){
		var ppID = $(this).data('popup');
		var popup_content = PF_Content_Popup.popup_content[ppID];
		
		if( typeof popup_content != "undefined" ){
			$(this).click(function(){
				// TODO: create popup with content
				
				log(popup_content);
				
				return false;
			});
		}else{
			$(this).remove();
		}
		
	});
	
});	

})(this.jQuery);