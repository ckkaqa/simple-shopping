<?php
	
	require_once('model/order.php');

	session_start();

	class ajax
	{
		public function update_order_quantity()
		{
			$order = New Order();
			$new_quantity = $_POST['quantity'];
			$session_id = session_id();

			$query = "UPDATE 
						orders 
					  SET quantity=".$new_quantity." 
					  WHERE product_id = ".$_POST['id']."
					  AND is_paid = 0
					  AND session_id = '$session_id'";

			$order->do_query($query);
			
			$total_query = "select SUM(per_unit_price*quantity) as total from orders where session_id = '$session_id' limit 1";

			$total = $order->do_query($total_query, true);

			if($total){
				foreach ($total as $tots) {
					echo $tots['total'];

				}
			}else{
				echo 0;
			}
		}
	}

	$ajax = new ajax();
	$ajax->update_order_quantity();
?>