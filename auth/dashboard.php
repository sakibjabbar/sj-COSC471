<?php
	require '../config/config.php';
	if(empty($_SESSION['username']))
		header('Location: login.php');

	if($_SESSION['role'] == 'admin'){
		$stmt = $connect->prepare('SELECT count(*) as register_user FROM users');
		$stmt->execute();
		$count = $stmt->fetch(PDO::FETCH_ASSOC);


		$stmt = $connect->prepare('SELECT count(*) as total_rent FROM room_rental_registrations');
		$stmt->execute();
		$total_rent = $stmt->fetch(PDO::FETCH_ASSOC);

		$stmt = $connect->prepare('SELECT count(*) as total_rent_apartment FROM room_rental_registrations_apartment');
		$stmt->execute();
		$total_rent_apartment = $stmt->fetch(PDO::FETCH_ASSOC);
	}

	$stmt = $connect->prepare('SELECT count(*) as total_auth_user_rent FROM room_rental_registrations WHERE user_id = :user_id');
	$stmt->execute(array(
		':user_id' => $_SESSION['id']
		));
	$total_auth_user_rent = $stmt->fetch(PDO::FETCH_ASSOC);

	$stmt = $connect->prepare('SELECT count(*) as total_auth_user_rent_ap FROM room_rental_registrations_apartment WHERE user_id = :user_id');
	$stmt->execute(array(
		':user_id' => $_SESSION['id']
		));
	$total_auth_user_rent_ap = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<?php include '../include/header.php';?>	

<?php include '../include/side-nav.php';?>
	<section class="wrapper" style="margin-left: 20%;margin-top: -5%;">
		<!-- <div class="container"> -->
			<!-- <div class="row"> -->
				<div class="col-md-12">
					<h1>Dashboard</h1>
					<div class="row">						
						<?php 
							if($_SESSION['role'] == 'admin'){ 
								echo '<div class="col-md-3">';
								echo '<a href="../app/users.php"><div class="alert alert-warning" role="alert">';
								echo '<b>List of users: <span class="badge badge-pill badge-success">'.$count['register_user'].'</span></b>';
								echo '</div></a>';
								echo '</div>';
							} 
						?>
						<?php 
							if($_SESSION['role'] == 'admin'){ 
								echo '<div class="col-md-3">';
								echo '<a href="../app/list.php"><div class="alert alert-warning" role="alert">';
								echo '<b>Units for Rent: <span class="badge badge-pill badge-success">'.(intval($total_rent['total_rent'])+intval($total_rent_apartment['total_rent_apartment'])).'</span></b>';
								echo '</div></a>';
								echo '</div>';
							} 
						?>
						<?php 
							if($_SESSION['role'] == 'user'){ 
								echo '<div class="col-md-3">';
								echo '<a href="../app/list.php"><div class="alert alert-warning" role="alert">';
								echo '<b>Registered Rooms: <span class="badge badge-pill badge-success">'.$total_auth_user_rent['total_auth_user_rent'].'</span></b>';
								echo '</div></a>';
								echo '</div>';
							} 
						?>
					</div>
				</div>
			<!-- </div> -->
		<!-- </div> -->
	</section>
<?php include '../include/footer.php';?>