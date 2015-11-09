jQuery(document).ready(function($){

	var $window = $(window);

	/*----choices search form-----*/
	(function(){
		var $form = $('.ea-search-form');
		var temp_array;
		var price_for_sale_html = '';
		var price_to_rent_html = '';

		var no_min_html = '<option value="">-No Minimum-</option>';
		var no_max_html = '<option value="">-No Maximum-</option>';

		temp_array = choices_price['to-rent'];
		$.each(temp_array, function(index, value){
			price_to_rent_html += '<option value="'+value+'">&pound;'+value+'</option>';
		})

		temp_array = choices_price['for-sale'];
		$.each(temp_array, function(index, value){
			price_for_sale_html += '<option value="'+value+'">&pound;'+value+'</option>';
		})


		$form.on('click','input.radio-inline', function(){
			var $this = $(this);
			var $this_form = $this.closest('form');
			var this_val = $this.val();

			var $this_minprice = $this_form.find('#min');
			var $this_maxprice = $this_form.find('#max');

			if(this_val=='for-sale'){
				$this_minprice.html(no_min_html + price_for_sale_html);
				$this_maxprice.html(no_max_html + price_for_sale_html);
			}
			else{
				$this_minprice.html(no_min_html + price_to_rent_html);
				$this_maxprice.html(no_max_html + price_to_rent_html);
			}
		});
	})();

	
});