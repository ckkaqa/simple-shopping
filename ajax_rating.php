<?php
	
	require_once('model/product_rating.php');
	require_once('model/product.php');

	class AjaxRating
	{
		public function add_rating()
		{
			$product_rating = new ProductRating();

			$query = "INSERT INTO 
					product_rating (product_id, rating)
				  VALUES (".$_POST['id'].", ".$_POST['rating'].")";

			$product_rating->do_query($query);

			$product_ratings = $product_rating->get_all('product_id='.$_POST['id'], 'product_rating', 'rating');
			$total_rating = 0;
			$total_rates = 0;
			if(count($product_ratings) > 0){
				foreach ($product_ratings as $rate) {
					$total_rating = $total_rating + $rate['rating'];
					$total_rates++;
				}
			}

			$avg_product_rate = $total_rating/$total_rates;

			$product = New Product();
			$query = "UPDATE 
						products 
					  SET avg_rating=".$avg_product_rate." 
					  WHERE id = ".$_POST['id']."";

			$product->do_query($query);
			
			echo "success";
		}	
	}

	$ajax = new AjaxRating();
	$ajax->add_rating();


?>