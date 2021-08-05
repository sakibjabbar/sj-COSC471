<?php
	require '../config/config.php';
	if(empty($_SESSION['username']))
		header('Location: login.php');

	if(isset($_POST['register_individuals'])) {
			$errMsg = '';
			// Get data from FROM
			$fullname = $_POST['fullname'];
			$email = $_POST['email'];
			$mobile = $_POST['mobile'];
			$country = $_POST['country'];
			$state = $_POST['state'];
			$city = $_POST['city'];
			$address = $_POST['address'];
			$rent = $_POST['rent'];
			$deposit = $_POST['deposit'];
			$user_id = $_SESSION['id'];	
			$rooms = $_POST['rooms'];
			$vacant = $_POST['vacant'];


			try {
					$stmt = $connect->prepare('INSERT INTO room_rental_registrations (fullname, email, mobile, alternat_mobile, plot_number, rooms, country, state, city, address, landmark, rent, sale, deposit, description, image, accommodation, vacant, user_id) VALUES (:fullname, :email, :mobile, :alternat_mobile, :plot_number, :rooms, :country, :state, :city, :address, :landmark, :rent, :sale, :deposit, :description, :image, :accommodation, :vacant, :user_id)');
					$stmt->execute(array(
						':fullname' => $fullname,
						':email' => $email,
						':mobile' => $mobile,
						':rooms' => $rooms,
						':country' => $country,
						':state' => $state,
						':city' => $city,
						':address' => $address,
						':rent' => $rent,
						':deposit' => $deposit,
						':vacant' => $vacant,
						':user_id' => $user_id
						));				

				header('Location: register.php?action=reg');
				exit;
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
	}


	if(isset($_POST['register_apartment'])) {
			$errMsg = '';
			// Get data from FROM
			$fullname = $_POST['fullname'];
			$email = $_POST['email'];
			$mobile = $_POST['mobile'];
			$country = $_POST['country'];
			$state = $_POST['state'];
			$city = $_POST['city'];
			$address = $_POST['address'];
			$rent = $_POST['rent'];
			$deposit = $_POST['deposit'];
			$user_id = $_SESSION['id'];
			$apartment_name = $_POST['apartment_name'];
				
			try {
				$stmt = $connect->prepare('INSERT INTO room_rental_registrations_apartment (fullname, email, mobile, alternat_mobile, plot_number, apartment_name, ap_number_of_plats, rooms, floor, purpose, own, area, country, state, city, address, landmark, rent, deposit, description, image, accommodation,  vacant, user_id) VALUES (:fullname, :email, :mobile, :alternat_mobile, :plot_number, :apartment_name, :ap_number_of_plats, :rooms, :floor, :purpose, :own, :area, :country, :state, :city, :address, :landmark, :rent, :deposit, :description, :image, :accommodation, :vacant, :user_id)');
				
				foreach ($_POST['ap_number_of_plats'] as $key => $value) {
					# code...					
					$stmt->execute(array(
						':fullname' =>  $_POST['fullname'][$key],
						':email' => $email,
						':mobile' => $mobile,
						':apartment_name' => $apartment_name,
						':rooms' => $_POST['rooms'][$key],
						':area' => $_POST['area'][$key],						
						':country' => $country,
						':state' => $state,
						':city' => $city,
						':address' => $_POST['address'],
						':rent' => $_POST['rent'][$key],
						':deposit' => $_POST['deposit'][$key],
						':vacant' => $_POST['vacant'][$key],
						':user_id' => $user_id
					));
				}				
				header('Location: register.php?action=reg');
				exit;
			}catch(PDOException $e) {
				echo $e->getMessage();
			}
	}

	if(isset($_GET['action']) && $_GET['action'] == 'reg') {
		$errMsg = 'Registration successfull. Thank you';
	}
?>
<?php include '../include/header.php';?>

<?php include '../include/side-nav.php';?>
<section class="wrapper" style="margin-left: 16%;margin-top: -8%;">
	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
	  <li class="nav-item">
	    <a class="nav-link active" data-toggle="tab" href="#home" role="tab">Individual Home Registration</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" data-toggle="tab" href="#profile" role="tab">Apartment Registration</a>
	  </li>
	</ul>

	<div class="tab-content">
	<!-- Single room -->
	  <div class="tab-pane active" id="home" role="tabpanel"><br>
	  		<?php include 'partials/individaul.php';?>
	  </div>

	<!-- Apartment -->
	  <div class="tab-pane" id="profile" role="tabpanel">
	  		<?php include 'partials/apartment.php';?>	  	
	  </div>
	</div>	
</section>
<?php include '../include/footer.php';?>
<script type="text/javascript">
	var rowCount = 1;
	function addMoreRows(frm) {
		rowCount ++;
		var recRow = '<div id="rowCount'+rowCount+'"><div class="row"><div class="col-md-4"><div class="form-group"><br> <a href="javascript:void(0);" onclick="removeRow('+rowCount+');" class="btn btn-danger btn-sm">Delete</a> </div> </div></div><div class="row"> <div class="col-md-4"><div class="form-group"> <label for="fullname">Full Name</label> <input type="fullname" class="form-control" id="fullname" placeholder="Full Name" name="fullname[]" required> </div> </div> <div class="col-md-4"><div class="form-group"> <input type="ap_number_of_plats" class="form-control" id="ap_number_of_plats" placeholder="Flat Number" name="ap_number_of_plats[]" required> </div> </div> <div class="col-md-4"> <div class="form-group"> <label for="rooms">Rooms</label> <input type="rooms" class="form-control" id="rooms" placeholder="2BHK/3BHK/1RK" name="rooms[]" required> </div> </div></div><div class="row"> <div class="col-md-4"> <div class="form-group"> <label for="area">Area</label> <input type="area" class="form-control" id="area" placeholder="Area" name="area[]"> </div> </div> <div class="col-md-4"> <div class="form-group"> <label for="purpose">Purpose</label> <select class="form-control" id="purpose" name="purpose[]"> <option value="Residential">Residential</option> <option value="Commercial">Commercial</option> </select> </div> </div> <div class="col-md-4"> <div class="form-group"> <label for="floor">Floor</label> <select class="form-control" id="floor" name="floor[]"> <option value="Ground Floor">Ground Floor</option> <option value="1st">1st</option> <option value="2nd">2nd</option> <option value="3rd">3rd</option> <option value="4th">4th</option> <option value="5th">5th</option> <option value="6th">6th</option> <option value="7th">7th</option> <option value="8th">8th</option> </select> </div> </div> </div> <div class="row"><div class="col-md-4"> <div class="form-group"> <label for="ownership">Owner/Rented</label> <select class="form-control" id="ownership" name="own[]"> <option value="owner">Owner</option> <option value="rented">Rented</option> </select> </div> </div> <div class="col-md-4"> <div class="form-group"> <label for="rent">Rent</label> <input type="rent" class="form-control" id="rent" placeholder="Rent" name="rent[]"> </div> </div> <div class="col-md-4"> <div class="form-group"> <label for="deposit">Deposit</label> <input type="deposit" class="form-control" id="deposit" placeholder="Deposit" name="deposit[]"> </div> </div>  </div><div class="row"><div class="col-md-4"> <div class="form-group"> <label for="accommodation">Facilities</label> <input type="accommodation" class="form-control" id="accommodation" placeholder="Facilities" name="accommodation[]"> </div> </div> <div class="col-md-4"> <div class="form-group"> <label for="description">Description</label> <input type="description" class="form-control" id="description" placeholder="Description" name="description[]" required> </div> </div> <div class="col-4"> <div class="form-group"> <label for="vacant">Vacant/Occupied</label> <select class="form-control" id="vacant" name="vacant[]"> <option value="1">Vacant</option> <option value="0">Occupied</option> </select> </div> </div> </div></div>'; $('#addedRows').append(recRow);
	}
	function removeRow(removeNum) {
		$('#rowCount'+removeNum).remove();
	}
</script>