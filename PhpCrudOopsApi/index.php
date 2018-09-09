<!DOCTYPE html>
<html>
<head>
	<title>PHP Crud operations</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
		<br>
		<center><h3>Crud Operations</h3></center>
		<br>
		<div align="right">
			<button type="button" name="add_button" id="add_button" class="btn btn-primary btn-md">Add</button>
		</div>
		
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Name</th>
						<th>Email</th>
						<th>Mobile Number</th>
						<th>Edit</th>
						<th>Delete</th>
					</tr>
				</thead>
				<tbody>
					
				</tbody>
			</table>
		</div>
	</div>
</body>
	<div id="add_edit_modal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="add_edit_form" method="post">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
           				<h4 class="modal-title">Add Data</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label>Enter your name:</label>
							<input type="text" name="username" id="username" class="form-control" placeholder="Enter your name">
						</div>
						<div class="form-group">
							<label>Enter Email Id:</label>
							<input type="text" name="email" id="email" class="form-control" placeholder="Enter Email Id">
						</div>
						<div class="form-group">
							<label>Enter Mobile Number</label>
							<input type="tel" name="mobile" id="mobile" class="form-control" placeholder="Enter Mobile Number">
						</div>
					</div>
					<div class="modal-footer">
						<input type="hidden" name="action" id="action">
						<input type="hidden" name="hidden_id" id="hidden_id">
						<input type="submit" name="button_action" id="button_action" class="btn btn-primary" value="Insert">
						<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</html>

<script type="text/javascript">
	$(document).ready(function(){
		fetch_data();
		$('#action').val('Insert');
		function fetch_data(){
			var action = "Fetch";
			$.ajax({
				
				url:"action.php",
				type:"POST",
				data:{action:action},
				success:function(data){
					// console.log(data);
					$('tbody').html(data);
				}
			});
		}

		$('#add_button').click(function(){
			$('#action').val('Insert');
			$('#button_action').val('Add');
			$('.modal-title').text('Add Data')
			$('#add_edit_modal').modal('show');
		});

		$('#add_edit_form').on('submit',function(event){
			event.preventDefault();
			var name = $('#username').val();
			var email = $('#email').val();
			var mobile_num = $('#mobile').val();
			var filter = /^\b[A-Z0-9_%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
			var formData = $(this).serialize();

			if (name == ''){
				alert("Enter your name");
			}
			else if (!name.match('^[a-zA-Z][a-zA-Z ]*$')){
				alert("That's not a name");
			}
			else if (email == ''){
				alert("Enter your email");
			}
			else if (!filter.test(email)){
				alert('Invalid Email');
			}
			else if (mobile_num == ''){
				alert("Enter your mobile number");
			}
			else if ($.isNumeric(mobile_num) == false){
				alert("Invalid mobile number, Type number");
			}
			else if (mobile_num.length != 10){
				alert('Mobile number should be of exact 10 digits');
			}
			else if (!mobile_num.match('^[6-9][0-9]{9}')){
				alert("Number should start with 6,7,8 or 9 only");
			}

			else{
				$.ajax({

					url:"action.php",
					type:"POST",
					data:formData,
					contentType:"application/x-www-form-urlencoded",
					success:function(data){
						fetch_data();
						alert(data);
						$('#add_edit_form')[0].reset();
						$('#add_edit_modal').modal('hide');
				
					}
				});
			}
		});

		$(document).on('click','.update',function(){
			var user_id = $(this).attr('id');
			var action = "Fetch_single";
			$.ajax({

				url:"action.php",
				type:"POST",
				data:{user_id:user_id, action:action},
				dataType:"json",
	
				success:function(data){
					console.log(data);
					$('#hidden_id').val(user_id);
					$('#username').val(data.username);
					$('#email').val(data.email);
					$('#mobile').val(data.mobile_num);
					$('#action').val('Update');
					$('#button_action').val('Update');
					$('.modal-title').text('Edit Data');
					$('#add_edit_modal').modal('show');
				}

			});
		});

		$(document).on('click','.delete',function(){
			var id = $(this).attr("id");
			var action = "Delete";
			if(confirm("Are you sure, You want to delete ?")){
				$.ajax({

					url:"action.php",
					method:"POST",
					data:{id:id, action:action},
					success:function(data){
						fetch_data();
						alert(data);
					}
				});
			}
		});

	});
</script>