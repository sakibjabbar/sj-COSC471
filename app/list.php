<?php
	require '../config/config.php';
	if(empty($_SESSION['username']))
		header('Location: login.php');	

		try {
			if($_SESSION['role'] == 'admin'){
				$stmt = $connect->prepare('SELECT * FROM room_rental_registrations_apartment');
				$stmt->execute();
				$data1 = $stmt->fetchAll (PDO::FETCH_ASSOC);

				$stmt = $connect->prepare('SELECT * FROM room_rental_registrations');
				$stmt->execute();
				$data2 = $stmt->fetchAll (PDO::FETCH_ASSOC);

				$data = array_merge($data1,$data2);
			}

			if($_SESSION['role'] == 'user'){
				$stmt = $connect->prepare('SELECT * FROM room_rental_registrations_apartment WHERE :user_id = user_id ');
				$stmt->execute(array(
					':user_id' => $_SESSION['id']
				));
				$data1 = $stmt->fetchAll (PDO::FETCH_ASSOC);

				$stmt = $connect->prepare('SELECT * FROM room_rental_registrations WHERE :user_id = user_id ');
				$stmt->execute(array(
					':user_id' => $_SESSION['id']
				));
				$data2 = $stmt->fetchAll (PDO::FETCH_ASSOC);

				$data = array_merge($data1,$data2);
			}
		}catch(PDOException $e) {
			$errMsg = $e->getMessage();
		}	
		// print_r($data1);	
		// echo "<br><br><br>";
		// print_r($data2);
		// echo "<br><br><br>";	
		// print_r($data);	
?>
<?php include '../include/header.php';?>

	<section style="padding-left:0px;">
		<?php include '../include/side-nav.php';?>
	</section>

<section class="wrapper" style="margin-left: 16%;margin-top: -23%;">
	<div class="container">
		<div class="row">
			<div class="col-12">
			<?php
				if(isset($errMsg)){
					echo '<div style="color:#FF0000;text-align:center;font-size:17px;">'.$errMsg.'</div>';
				}
			?>
			<h2>List of Apartment Details</h2>
				<?php 
					foreach ($data as $key => $value) {						
						echo '<div class="card card-inverse card-info mb-3" style="padding:1%;">					
								  <div class="card-block">';
								  	echo '<a class="btn btn-warning float-right" href="update.php?id='.$value['id'].'&act=';if(!empty($value['own'])){ echo "ap"; }else{ echo "indi"; } echo '">Edit</a>';
									 echo 	'<div class="row">
											<div class="col-4">
											<h4 class="text-center">Owner Details</h4>';
											 	echo '<p><b>Owner Name: </b>'.$value['fullname'].'</p>';
											 	echo '<p><b>Mobile Number: </b>'.$value['mobile'].'</p>';
											 	echo '<p><b>Email: </b>'.$value['email'].'</p>';
											 	echo '<p><b>Country: </b>'.$value['country'].'</p><p><b> State: </b>'.$value['state'].'</p><p><b> City: </b>'.$value['city'].'</p>';
											 	echo '<p><b>Address: </b>'.$value['address'].'</p>';

										echo '</div>
											<div class="col-5">
											<h4 class="text-center">Room Details</h4>';

												if(isset($value['rent'])){
													echo '<p><b>Rent: </b>'.$value['rent'].'</p>';
												}										
												
													if(isset($value['apartment_name']))
														echo '<div class="alert alert-success" role="alert"><p><b>Apartment Name: </b>'.$value['apartment_name'].'</p></div>';

													if(isset($value['ap_number_of_plats']))
														echo '<div class="alert alert-success" role="alert"><p><b>Flat Number: </b>'.$value['ap_number_of_plats'].'</p></div>';
												if(isset($value['own'])){
													echo '<p><b>Available Area: </b>'.$value['area'].'</p>';
													echo '<p><b>Floor: </b>'.$value['floor'].'</p>';
													echo '<p><b>Owner/Rented: </b>'.$value['own'].'</p>';
													echo '<p><b>Purpose: </b>'.$value['purpose'].'</p>';
												}
												echo '<p><b>Available Rooms: </b>'.$value['rooms'].'</p>';
											
												if($value['vacant'] == 0){ 
													echo '<div class="alert alert-danger" role="alert"><p><b>Occupied</b></p></div>';
												}else{
													echo '<div class="alert alert-success" role="alert"><p><b>Vacant</b></p></div>';
												} 

										echo '</div>

											
										</div>				      
								   </div>
								</div>';
					}
				?>				
			</div>
		</div>
	</div>	
</section>
<?php include '../include/footer.php';?>