<?php
	require_once('model/product.php');
	require_once('model/cart.php');
	require_once('model/order.php');
	require_once('model/transport_type.php');

	session_start();
	$_SESSION['balance'] = '100';

	class Main 
	{
		public $data = array();

		public function index()
		{
			$product = new Product();
			$this->data['products'] = $product->get_all('','products','id,name,price,avg_rating');

			$cart = new Cart();
			$this->data['cart_status'] = $cart->get('','cart', 'id, cart_status');

			$transport_type = new TransportType();
			$this->data['transport_types'] = $transport_type->get_all('','transport_type','name, price, id');

			$order = New Order();	
			$query = "SELECT 
						p.id, p.name, o.quantity,p.price,p.price * o.quantity as total
					  from products p 
					  LEFT JOIN orders o 
					  ON o.product_id = p.id
					  where o.quantity != 0";

			$this->data['orders'] = $order->do_query($query, true);

			if ($_POST){
				$product_id = $_POST['product_id'];
				$product_order = $order->get('product_id='.$product_id,'orders','id,quantity');

				if(count($product_order) > 0){
					$new_quantity = $product_order['quantity'] + 1;
					$query = "UPDATE 
								orders 
							  SET quantity=".$new_quantity." 
							  WHERE id = ".$product_order['id']."";

				}else{
					$query = "INSERT INTO 
								orders (product_id, quantity)
							  VALUES (".$product_id.", 1)";
				}
				$order->do_query($query);

				$page = $_SERVER['PHP_SELF'];
				$sec = "1";
				header("Refresh: $sec; url=$page");

				$this->data['message'] = 'successfully added to cart!';
			}

			require 'views/layouts/header.php';
			require 'views/home.php';
			require 'views/layouts/footer.php';
		}
	}

	$main = new Main();
	$main->index();
?>
