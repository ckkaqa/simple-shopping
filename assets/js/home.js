$(document).ready(function(){
	$(".balance_container").hide();

	$('.change_quantity').on('click', function(){
		var input = $(this).parent().parent().find('input');
		var product_id = input.data('id');
		var quantity = input.val();
		var type = $(this).data('type');
		var product_price = input.data('price');
		var pre_current_payment = $("#current_payment_container").text();
		var new_total=0;

		if(type == 'plus'){
    		new_total = parseFloat(pre_current_payment) + parseFloat(product_price);
			input.val(parseInt(quantity)+1);
		}else{
			new_total = parseFloat(pre_current_payment) - parseFloat(product_price);
			input.val(parseInt(quantity)-1);
		}

		var new_quantity = input.val();

		if(new_quantity == 0){
			input.parent().parent().parent().remove();
		}

		request = $.ajax({
	        url: "ajax_post.php",
	        type: "post",
	        data: {'quantity': new_quantity, 'id': product_id},
	        success: function()
	        {
	        	$("#current_payment_container").text(new_total);
	        }
	    });

	});

	$("#sel1").on('change', function(){
		var addl = $("#transport_addl").val();

		total_container = $("#current_payment_container");
		transport_cost = $(this).val() == 1 ? 0 : 5;

		if(parseFloat(addl) > 0){
			console.log('its here');
			new_total = parseFloat(total_container.text()) - parseFloat(addl);
			total_container.text(new_total);
			$("#transport_addl").val(0);
		}else{
			new_total = parseFloat(total_container.text()) + parseFloat(transport_cost);
			total_container.text(new_total);
			$("#transport_addl").val(transport_cost);
		}

	});

	$(".pay_order").on('click', function(){
		if($("#sel1").val() != 0){
			var current = $("#current_payment_container").text();
			var balance = $("input.balance").val();

			var val = $("#sel1").val();
			var transport_deduct = val == 1 ? 0 : 5;
			var now = parseFloat(balance)-parseFloat(current)-transport_deduct;

			if(current > parseFloat(balance)){
				alert('Insufficient funds!');
			}else{
				request = $.ajax({
			        url: "ajax_pay.php",
			        type: "post",
			        data: {payment: current},
			        success: function()
			        {
			        	location.reload(true);
			        }
			    });

				// var now = parseFloat(balance)-parseFloat(current)-transport_deduct;
				// $(".balance_container").show();
				// $("#remaining_balance").text((now).toFixed(2));
			}
		}else{
			alert("You have to select transport type");
		}
	});

	$(".click_rate").on('click', function(){
		var input = $(this).find('input');
		var val = input.val();
		var product_id = input.data('id');

		request = $.ajax({
	        url: "ajax_rating.php",
	        type: "post",
	        data: {'rating': val, 'id': product_id},
	        success: function()
	        {
	        	location.reload(true);
	        }
	    });

	});

});