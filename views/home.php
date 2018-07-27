<div class = "container-fluid">
	<div class = "row">
		<div class = "col-md-2"></div>
		<div class = "col-md-8">
			<?php if(isset($this->data['message'])) : ?>
				<div class="alert alert-success">
				  <strong>Success!</strong> <?=$this->data['message'];?>
				</div>
			<?php endif; ?>
			<div class="alert alert-warning">
			  <strong>Note:</strong> You currently have $<?=$_SESSION['balance'];?> in your account!
			</div>

			<table class="table table-striped">
			    <thead>
			      <tr>
			        <th>Product</th>
			        <th>Rating</th>
			        <th>avg rate</th>
			        <th>Price</th>
			        <th>Action</th>
			      </tr>
			    </thead>
			    <tbody>
			    	<?php if(count($this->data['products']) > 0) : ?>
			    		<?php foreach ($this->data['products'] as $product):?>
					      <tr>
					        <td class = "text-center">
					        	<img class="product-img-center-block product-img img img-responsive" src="assets/img/<?=$product['thumbnail_name']; ?>" alt="<?=$product['thumbnail_name']; ?>">
					        	<?=$product['name']?>
					        	</td>
					        <td class = "cell-center">
					        	<div class="btn-group col-md-8 col-sm-5 col-xs-5" data-toggle="buttons">
				                    <label class="btn btn-default click_rate">
				                      <input data-id = "<?=$product['id']?>" type="radio" name="educationalValue" id="edValueRdo1" value="1">1</label>
				                    <label class="btn btn-default click_rate">
				                      <input data-id = "<?=$product['id']?>" type="radio" name="educationalValue" id="edValueRdo2" value="2">2</label>
				                    <label class="btn btn-default click_rate">
				                      <input data-id = "<?=$product['id']?>" type="radio" name="educationalValue" id="edValueRdo3" value="3">3</label>
				                    <label class="btn btn-default click_rate">
				                      <input data-id = "<?=$product['id']?>" type="radio" name="educationalValue" id="edValueRdo4" value="4">4</label>
				                    <label class="btn btn-default click_rate">
				                      <input data-id = "<?=$product['id']?>" type="radio" name="educationalValue" id="edValueRdo5" value="5">5</label>
				                </div>
					        </td>
					        <td class = "cell-center">
					        	<?php if(session_id() == $product['session_id']):?>
					        		<?=round($product['avg_rating'],2);?>
					        	<?php else: ?>
					        		0
					        	<?php endif;?>
					        </td>
					        <td class = "cell-center">$<?=$product['price']?></td>
					        <td class = "cell-center">
					        	<form method = "post" action = "index.php">
					        		<input type="hidden" name="product_id" value = "<?=$product['id']?>"/>
					        		<button data-id = "<?=$product['id']?>" class = "btn btn-sm btn-success add_cart">Add to cart</button>	
					        	</form>
					        </td>
					      </tr>
				      	<?php endforeach; ?>
			  		<?php endif; ?>
			    </tbody>
			</table>
		</div>
		<div class = "col-md-2"></div>
	</div>

	<div class = "row">
		<div class = "col-md-2"></div>
		<div class = "col-md-8">
			<!-- Trigger the modal with a button -->
			<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">View Cart</button>

			<!-- Modal -->
			<div id="myModal" class="modal fade" role="dialog">
				<div class="modal-dialog">

			    	<!-- Modal content-->
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>

				        <h4 class="modal-title">Cart Status: <?=$this->data['cart_status']['cart_status'] ? '<span class = "text-success">active</span>' : '<span class = "text-danger">inactive</span>' ?> || Balance: $<?=$_SESSION['balance'];?></h4>
				        <input class = "balance" type="hidden" name="balance" value = "<?=$_SESSION['balance'];?>">
				      </div>
				      <div class="modal-body">
				    	<table class="table table-striped">
						    <thead>
						      <tr>
						        <th>Product Name</th>
						        <th>Price</th>
						        <th>Action</th>
						      </tr>
						    </thead>
						    <tbody>
						    	<?php $total_payment = 0; ?>
						    	<?php if($this->data['orders']) : ?>
						    		<?php foreach ($this->data['orders'] as $product):?>
						    		  <?php $total_payment = $total_payment + $product['total']; ?>
								      <tr>
								        <td>
								        	<img class="product-img-center-block product-img img img-responsive" src="assets/img/<?=$product['thumbnail_name']; ?>" alt="<?=$product['thumbnail_name']; ?>">
								        	<?=$product['name']?>
								        </td>
								        <td class = "cell-center">$<?=$product['price']?></td>
								        <td class = "cell-center">

								        	<div class="input-group col-md-4">
									          <span class="input-group-btn">
									              <button type="button" class="btn btn-danger btn-number change_quantity" data-type="minus" data-field="quant[<?=$product['id']?>]">
									                <span class="glyphicon glyphicon-minus"></span>
									              </button>
									          </span>
									          <input type="text" name="quant[<?=$product['id']?>]" class="form-control input-number" value="<?=$product['quantity']?>" min="1" max="100" data-id="<?=$product['id']?>" data-price = "<?=$product['price']?>" disabled>
									          <span class="input-group-btn">
									              <button type="button" class="btn btn-success btn-number change_quantity" data-type="plus" data-field="quant[<?=$product['id']?>]">
									                  <span class="glyphicon glyphicon-plus"></span>
									              </button>
									          </span>
									     	</div>

								        </td>
								      </tr>
							      	<?php endforeach; ?>
						  		<?php endif; ?>
						    </tbody>
						</table>

						<div class="form-group">
						  <label for="sel1">Select list:</label>
						  <input id = "transport_addl" type="hidden" name="transport_addl" value = "0" />
						  <select class="form-control" id="sel1">
						    <option value = "0">Select One</option>
							    <?php if(count($this->data['transport_types']) > 0) :?>
							    	<?php foreach ($this->data['transport_types'] as $type):?>
							    		<option value = "<?=$type['id']?>"><?=$type['name']?> - $<?=$type['price']?></option>
							    	<?php endforeach; ?>
							    <?php endif; ?>
						  </select>
						  <button class = "pay_order btn btn-sm btn-secondary">Pay!</button>
						  Total cost: $<span id = "current_payment_container"><?=$total_payment; ?></span>
						  <div class="alert alert-success balance_container">
							  <strong>Your new balance: </strong>$ <span id ="remaining_balance"></span>
						  </div>

						</div>

				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				      </div>
				    </div>

				</div>
			</div>	
		</div><!-- end col md 8-->

		<div class = "col-md-2"></div>

	</div><!-- end row -->
</div>
