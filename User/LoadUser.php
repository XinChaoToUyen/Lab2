<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Load Users</title>
	<?php require "../css/css.php" ?>
</head>
<body>
	<table class="table">
		<thead class="thead-dark">
			<tr>
				<th scope="col">Id</th>
				<th scope="col">Username</th>
				<th scope="col">Password</th>
				<th scope="col">Role</th>
				<th scope="col"><span class="btn btn-success" id="btnadd">Thêm</span></th>	
			</tr>
		</thead>
		<tbody id="data">
			
		</tbody>
	</table>
	//Phan trang cho nguoi dung
	<nav>
		<ul class="pagination" id="pagination"></ul>
	</nav>
	<?php require "../Modal/modaluser.php" ?>
	
</body>
</html>
<?php require "../script/script.php" ?>
<script type="text/javascript">
	$(document).ready(function(){
		function Loaduser(){
			$.ajax({
				url:'../Process/ProcessUsers.php',
				type:'get',
				data:{type:"loaduser"},
				success:function(data){
					$('#data').html(data);
				}

			});
		}
		Loaduser();
		// Pagination();
		//ham lay dc so trang va phan trang
		// function Pagination(){
		// 	$.ajax({
		// 		url:'../Process/ProcessUsers.php',
		// 		type:'get',
		// 		data:{type:"pagination",page:page},
		// 		success:function(data){
		// 			$('#pagination').html(data);
		// 		}
		// 	})
		// }
		//Hiện modal và thêm trong bảng
		$('#btnadd').click(function(){
			$('#add').text("Thêm người dùng");
			$('#btnUpdate').hide();
			$('#btnInsert').show();
			$('.inputid').hide();
			$('#modalAU').modal('show');
		});
		//Lấy dữ liệu trên modal và nhấn btntheem
		$('#btnInsert').click(function(){
			var un=$('#un').val();
			var pw=$('#pw').val();
			var role=$('#role').val();
			$.ajax({
				url:'..//Process/ProcessUsers.php',
				type:'get',
				data:{type:'them',un:un,pw:pw,role:role},
				success:function(data){
					if(data=="1"){
						$('#modalAU').modal('hide');
						Load();

					}
				}

			});

		});

	});
</script>