<?php
	
	require_once('model/order.php');

	class ajax
	{
		public function update_order_quantity()
		{
			$order = New Order();
			$new_quantity = $_POST['quantity'];
			$query = "UPDATE 
						orders 
					  SET quantity=".$new_quantity." 
					  WHERE id = ".$_POST['id']."";

			$order->do_query($query);
			
			echo "success";
		}
	}

	$ajax = new ajax();
	$ajax->update_order_quantity();
?>