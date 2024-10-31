$(document).ready(function(){
   $('#gpo_size').change(function(){
      var Size = parseInt(this.value);
      switch(Size){
         case 1:$('#gpo_image').attr('src','../wp-content/plugins/google-plus-one/default.png');break;
         case 2:$('#gpo_image').attr('src','../wp-content/plugins/google-plus-one/small.png');break;
         case 3:$('#gpo_image').attr('src','../wp-content/plugins/google-plus-one/medium.png');break;
         case 4:$('#gpo_image').attr('src','../wp-content/plugins/google-plus-one/tall.png');break;
    	 default:$('#gpo_image').attr('src','../wp-content/plugins/google-plus-one/default.png');break;
      }
   });
});