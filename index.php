<?php
// Database connection
$con = mysqli_connect("localhost", "root", "", "db_sample");

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Number of results to show on each page
$num_results_on_page = 5;

// Get the total number of records from the database
$total_records_query = mysqli_query($con, "SELECT COUNT(*) as total FROM user");
if (!$total_records_query) {
    die("Error getting total records: " . mysqli_error($con));
}
$total_records = mysqli_fetch_assoc($total_records_query)['total'];

// Calculate the total number of pages
$total_pages = ceil($total_records / $num_results_on_page);

// Check if the page number is specified and check if it's a number, if not, return the default page number, which is 1.
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

// Calculate the starting record for the current page
$start_from = ($page - 1) * $num_results_on_page;

// Fetch records for the current page
$result_query = mysqli_query($con, "SELECT * FROM user ORDER BY UID LIMIT $start_from, $num_results_on_page");

?>
<html>
	<head>
		<title>jQuery Ajax - PHP MySQL - CRUD Application</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"> 
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
		<script>
$(document).ready(function(){
	$("#frm").validate({
       /*  rules: {
                color: "required"
            },
            messages: {
                color: "select atleast one color"
            }, */
			errorPlacement: function(error, element) {
                if (element.attr("type") == "checkbox") {
                    error.insertAfter(element.closest(".check-group"));
                } else {
                    error.insertAfter(element);
                }
            }

        });
	
});</script>
		<style>
			.form-control{
				width:86% !important;
			}
			.container{
				margin-left:30%
			}
			.error{
             color:red;
			}

			</style>
	</head>
	<body>
	<div class="container">
		
		<h3 class='text-left'>jQuery Ajax - PHP MySQL - CRUD Application</h3><hr>
		<div class='row'>
			<div class="col-md-7">
			<div id="successMessage" style="color:green;display:none; text-align:center;font-size:14px;"></div>
			<br><br>
	
				<form id='frm' >
				  <div class="form-group">
					<label>User Name</label>
					<input type="text" class="form-control" name="name" id='name' required placeholder="Enter User Name" required>
					<div class="error" style="color:red;">
				  </div>
				  <div class="form-group">
					<label>Email</label>
					<input type="email" class="form-control" name="email" id='email' required placeholder="Enter Email" required>
					<div class="error" style="color:red;">
				  </div>
				  </div>
				  <div class="form-group">
					<label>Mobile No</label>
					<input type="number" class="form-control"  name="mobile" id='mobile' required placeholder="Enter Mobile Number" required>
					<div class="error" style="color:red;">
				  </div>
				  </div>
				  
				  <input type="hidden" class="form-control" name="uid" id='uid' required value='0' placeholder="">
				  
				  <button type="submit" name="submit" id="but" class="btn btn-success">Add User</button>
				  <button type="button" id="clear" class="btn btn-warning">Clear</button>
				</form> 
			</div>
			<div class="col-md-6">

			<table class="table table-bordered">
  <thead class="btn-primary">
    <tr>

      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Mobile</th>
	  <th scope="col">Edit</th>
	  <th scope="col">Delete</th>
    </tr>
  </thead>
  <tbody>
	
  <?php while ($row = mysqli_fetch_assoc($result_query)): ?>
        <tr  class='<?php echo htmlspecialchars($row["UID"]); ?>'>


            <td><?php echo htmlspecialchars($row["NAME"]); ?></td>
            <td><?php echo htmlspecialchars($row["EMAIL"]); ?></td>
			<td><?php echo htmlspecialchars($row["MOBILE"]); ?></td>
			<td><a href='#' class='btn btn-primary edit' uid=<?php echo htmlspecialchars($row["UID"]); ?>>Edit</a></td>
			<td><a href='#' class='btn btn-danger del' uid=<?php echo htmlspecialchars($row["UID"]); ?>>Delete</a></td>		
            <!-- Add other columns as needed -->
        </tr>
    <?php endwhile; ?>

  </tbody>
</table>

			<nav aria-label="...">
			<?php if (ceil($total_records / $num_results_on_page) > 0): ?>
    <ul class="pagination">
        <?php if ($page > 1): ?>
            <li class="prev"><a href="?page=<?php echo $page-1 ?>">Prev</a></li>
        <?php endif; ?>

        <?php if ($page > 3): ?>
            <li class="start"><a href="?page=1">1</a></li>
            <li class="dots">...</li>
        <?php endif; ?>

        <?php for ($i = max(1, $page - 2); $i <= min($page + 2, ceil($total_records / $num_results_on_page)); $i++): ?>
            <li class="<?php echo ($i == $page) ? 'currentpage' : 'page'; ?>"><a href="?page=<?php echo $i ?>"><?php echo $i ?></a></li>
        <?php endfor; ?>

        <?php if ($page < ceil($total_records / $num_results_on_page) - 2): ?>
            <li class="dots">...</li>
            <li class="end"><a href="?page=<?php echo ceil($total_records / $num_results_on_page) ?>"><?php echo ceil($total_records / $num_results_on_page) ?></a></li>
        <?php endif; ?>

        <?php if ($page < ceil($total_records / $num_results_on_page)): ?>
            <li class="next"><a href="?page=<?php echo $page+1 ?>">Next</a></li>
        <?php endif; ?>
    </ul>
<?php endif; ?>
</nav>

			
			</div>
		</div>
	</div>	
	<script>
		$(document).ready(function(){

			function empty() {
    if (document.getElementById("name").value == "") {
        document.getElementById("name").innerHTML = "Enter at least one character to the password field";
        return false;
    }
    if (document.getElementById("confirm_password").value != document.getElementById("password").value) {
        document.getElementById("cpwmessage").innerHTML = "Please check your password and try again";
        return false;
    };
}


			
			//Clear all the Fields
			$("#clear").click(function(){
				$("#name").val("");
				$("#email").val("");
				$("#mobile").val("");
				$("#uid").val("0");
				$("#but").text("Add User");
			});
			
			//Insert and update using jQuery ajax
			$("#but").click(function(e){
				e.preventDefault();

				





				var btn=$(this);
				var uid=$("#uid").val();
				//alert(uid);
				
				//Check All Fields are filled
				var required=true;
				$("#frm").find("[required]").each(function(){
					if($(this).val()==""){
				alert($(this).attr("placeholder"));
				
						//$('.error').text('Username cannot be empty');
						$(this).focus();
						required=false;
						return false;
					}
				});
				if(required){
					//alert(required+"This is ajax_action_call");
					$.ajax({
						type:'POST',
						url:'ajax_action.php',
						data:$("#frm").serialize(),

					
						beforeSend:function(){
							$(btn).text("Wait...");
						},
						success:function(res){


				






							
							var uid=$("#uid").val();
							if(uid=="0"){
					
                    // Display success message
                    $("#successMessage").html("Form submitted successfully!").show();

                    // You can hide the message after a certain time if needed
                    setTimeout(function(){
                        $("#successMessage").hide();
                    }, 5000); // 5000 milliseconds (5 seconds) in this example
            
								$("#table").find("tbody").append(res);

							}else{



								//location.reload();
								$("#table").find("."+uid).html(res);
							}
							
							$("#clear").click();
							$("#but").text("Add User");
						}
					});
				}
			});
			
			//Delete row using jQuery ajax
			$("body").on("click",".del",function(e){
				e.preventDefault();
				var uid=$(this).attr("uid");
				var btn=$(this);
				if(confirm("Are You Sure ? ")){
					$.ajax({
						type:'POST',
						url:'ajax_delete.php',
						data:{id:uid},
						beforeSend:function(){
							$(btn).text("Deleting...");
						},
						success:function(res){
							if(res){
								btn.closest("tr").remove();
							}
						}
					});
				}
			});
			
			//fill all fields from table values
			$("body").on("click",".edit",function(e){
				e.preventDefault();
				var uid=$(this).attr("uid");
				$("#uid").val(uid);
				var row=$(this);
				var name=row.closest("tr").find("td:eq(0)").text();
				$("#name").val(name);
				var email=row.closest("tr").find("td:eq(1)").text();
				$("#email").val(email);
				var mobile=row.closest("tr").find("td:eq(2)").text();
				$("#mobile").val(mobile);
				$("#but").text("Update User");
			});
		});
	</script>
	</body>
</html>
