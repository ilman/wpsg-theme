function sg_tinymce_create($sc){
   console.log($sc.button_icon);
   tinymce.create('tinymce.plugins.'+$sc.name, {
      init : function(ed, url) {
         ed.addButton($sc.name, {
            title : $sc.button_title,
            image : $sc.button_icon,
            onclick : function() {
               tb_show($sc.modal_title, '#TB_inline?inlineId='+$sc.name);
               jQuery(window).trigger('resize');                  
               jQuery('#TB_window').bind('sg_insert_shortcode.sg_tinymce', function(event, code) {
                  ed.selection.setContent(code);
               });
            }
         });
      },
      getInfo : function() {
         return {
            longname : "SG Shortcode Generator Framework",
            author : 'Scienceguard',
            version : "1.0"
         };
      }
   });

}

for (var i = 0; i < $sg_sc_array.length; i++) {
   var $sg_sc_i = $sg_sc_array[i];

   sg_tinymce_create($sg_sc_i);
   tinymce.PluginManager.add($sg_sc_i.name, tinymce.plugins[$sg_sc_i.name]);
};

jQuery(document).ready(function($){
   $(window).resize( function() {
      sg_sc_container_resize();
   });
   $('body').on('sg_sc_init', function(){
       sg_sc_container_resize();
   })
   function sg_sc_container_resize() {
      var $window = $('#TB_window'),
      $sg_sc_container = $('.sg-sc-container'),
      $sg_sc_tab_nav = $sg_sc_container.find('.sg-form-tab-nav');
      w = $window.width(),
      h = $window.height();


      if($sg_sc_container.length > 0) {
         $window.find('#TB_ajaxContent').outerWidth(w);
         $window.find('#TB_ajaxContent').outerHeight(h);
         $sg_sc_container.find('.sg-form-container').css({'min-height':h-80});
      }
   }

   //insert shortcode
   $('.sg-insert-shortcode').click(function(){
      var $this = $(this);
      var $sg_sc_sets = $this.closest('.sg-form-tab-item');
      var $sg_sc_input = $sg_sc_sets.find(':input').filter('[name]');
      var $sg_sc_sets_data_code = $sg_sc_sets.find('.data-code');
      var str_shortcode = '';
      if($sg_sc_sets_data_code.length>0){
         str_shortcode = $sg_sc_sets_data_code.data('code');
      }
      else if($sg_sc_sets.data('code')){
         str_shortcode = $sg_sc_sets.data('code');
      }
      str_shortcode = $("<div/>").html(str_shortcode).text();
      
      var $sg_sc_param = str_shortcode.match(/{[a-zA-Z0-9_]+}/g);
      var $str_param = new Array();

      $sg_sc_input.each(function(){
         var $each_this = $(this);
         $.each($sg_sc_param, function(idx,val){
            if(!$each_this.val()){
              return true;
            }

            if($each_this.is(':checkbox')||$each_this.is(':radio')){
               if(!$each_this.is(':checked')){
                  return true;
               }
            }

            if(typeof $str_param[val] == 'undefined'){
               $str_param[val] = '';
            }

            if($each_this.data('param')==val){
               if($each_this.data('param-type')=='content'){
                  $str_param[val] += $each_this.val();
               }
               else{
                  $str_param[val] += ' '+$each_this.attr('data-id')+'="'+$each_this.val()+'"';
               }
            }
         });
      });

      $.each($sg_sc_param, function(idx,val){
         str_shortcode = str_shortcode.replaceAll(val,$.trim($str_param[val]));
      });

      $('#TB_window').trigger('sg_insert_shortcode', str_shortcode);
      tb_remove();
   });

});