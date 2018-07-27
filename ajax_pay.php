<?php
	
	require_once('model/order.php');

	session_start();
	
	class AjaxPay
	{
		public function pay()
		{
			$order = New Order();
			$query = "UPDATE 
						orders 
					  SET is_paid=1";

			$order->do_query($query);

			if(isset($_SESSION['balance']))
			{
				$_SESSION['balance'] = $_SESSION['balance'] - $_POST['payment'];
			}

			echo $_SESSION['balance'];
		}
	}

	$ajax = new AjaxPay();
	$ajax->pay();


?>