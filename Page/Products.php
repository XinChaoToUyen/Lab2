<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<?php
	require "../css/css.php";
	session_start();
	if (!isset($_SESSION['key'])) {
		header("Location: ../dangnhap.php");
	}
	?>
	<style>
		input[name="search"] {
			width: 130px;
			box-sizing: border-box;
			border: 2px solid #ccc;
			border-radius: 4px;
			font-size: 16px;
			background-color: white;
			background-image: url('../Process/searchicon.png');
			background-position: 10px 10px;
			background-repeat: no-repeat;
			padding: 12px 20px 12px 40px;
			-webkit-transition: width 0.4s ease-in-out;
			transition: width 0.4s ease-in-out;
		}

		input[name="search"]:focus {
			width: 100%;
		}
	</style>
</head>

<body>
	<h2 style="color: red">Xin chào <?php echo $_SESSION['key'] ?></h2>
	<input type="text" name="search" placeholder="Search.." id="search">
	<table class="table">
		<thead class="thead-dark">
			<tr>
				<th scope="col">STT</th>
				<th scope="col">Tên SP</th>
				<th scope="col">Giá mới</th>
				<th scope="col">Giá cũ</th>
				<th scope="col">Số lượng</th>
				<th scope="col">Ngày nhập</th>
				<th scope="col">Tình trạng</th>
				<th scope="col">Trạng thái</th>
				<th scope="col">ID Loại SP</th>
				<th scope="col"><span class="btn btn-success" id="btnadd">Thêm</span></th>
			</tr>
		</thead>
		<tbody id="data">
		</tbody>
	</table>
	<nav>
		<ul class="pagination" id="pagination">
		</ul>
	</nav>
	</div>
	<?php require "../Modal/modalproduct.php" ?>
</body>

</html>
<?php
require "../script/script.php";
?>
<script type="text/javascript">
	$(document).ready(function() {
		var page = 1;
		$(document).on("click", ".pagination li .pg", function() {
			var kq = Number($(this).text());
			page = kq;
			Load();
		})
		$(document).on("click", ".pagination li .prev", function() {
			page--;
			Load();
		})
		$(document).on("click", ".pagination li .next", function() {
			page++;
			Load();
		});

		function Load() {
			$.ajax({
				url: '../Process/ProcessProducts.php',
				type: 'get',
				data: {
					type: "load",
					page: page
				},
				success: function(data) {
					// alert(data);
					$("#data").html(data);
				}
			});
			Panigation();
		}
		Load();

		function Panigation() {
			$.ajax({
				url: '../Process/ProcessProducts.php',
				type: 'get',
				data: {
					type: "pagination",
					page: page
				},
				success: function(data) {
					// alert(data);
					$("#pagination").html(data);
				}
			});
		}
		//search
		$('#search').keyup(function() {
			var sr = $(this).val();
			// console.log(sr);
			$.ajax({
				url: '../Process/ProcessProducts.php',
				type: 'get',
				data: {
					type: 'search',
					sr: sr
				},
				success: function(data) {
					$("#data").html(data);
				}
			});
		});

		// Hiển thị modal thêm lên
		$('#btnadd').click(function() {
			$('#modalAU').modal('show');
			$('.inputid').hide();
			$('#btnUpdate').hide();
			$('#txtadd').text("Thêm sản phẩm");
		});
		//Thêm ở modal
		$('#btnInsert').click(function() {
			var formData = new FormData($('#formsp')[0]);
			$.ajax({
				url: '../Process/ProcessProducts.php?type=them',
				type: 'post',
				data: formData,
				contentType: false,
				processData: false,
				success: function(data) {
					$('#modalAU').modal('hide');
					Load();
					// alert(data);
				}
			});
		});
		// Thoat trong modal
		$('#btnClose').click(function() {
			$('#modalAU').modal('hide');
		});
		$(document).on('click', '#btndelete', function() {
			var id = $(this).data('id'); // data-id=10
			// Hien modal xoa len
			$('#modalD').modal('show');
			$.ajax({
				url: '../Process/ProcessProducts.php?type=xoa&id=' + id,
				success: function(data) {
					// alert("Xóa xong rồi uyên!!!");
					$('#btnco').click(function(data) {
						$('#modalD').modal('hide');
						Load();
					})
				}
			});
		});
		$.ajax({
			url: '../Process/ProcessProducts.php',
			type: 'get',
			data: {
				type: 'tenloai'
			},
			success: function(data) {
				$('.selecloaisp').html(data);
			}
		});
		// phantrang
		$.ajax({
			url: '../Process/ProcessProducts.php',
			type: 'get',
			data: {
				type: "phantrang",
				trang: 1
			},
			success: function(data) {}
		});
		// ủy nhiệm hàm cho btnsua
		$(document).on("click", "#btnsua", function() {
			var id = $(this).data('id');
			// alert(id);
			$('#modalAU').modal('show');
			$('#txtadd').text("Update product");
			$('#btnInsert').hide();
			$.ajax({
				url: '../Process/ProcessProducts.php',
				type: 'get',
				data: {
					type: 'getid',
					id: id
				},
				success: function(data) {
					var b = JSON.parse(data);
					// console.log(DataStr(b['NgayNhap']));
					$('#id').val(b['Id']);
					$('#tsp').val(b['TenSP']);
					$('#gm').val(b['GiaMoi']);
					$('#gc').val(b['GiaCu']);
					$('#sl').val(b['SoLuong']);
					$('#nn').val(DataStr(b['NgayNhap']));
					$('#tt').val(b['TinhTrang']);
					//    console.log(b['TrangThai']);
					if(b["TrangThai"]=="1"){
						$('input[name="trangthai"][value="1"]').attr('checked','true');
						$('input[name="trangthai"][value="0"]').removeAttr('checked','true');
					}else{
						$('input[name="trangthai"][value="0"]').attr('checked','true');
						$('input[name="trangthai"][value="1"]').removeAttr('checked','true');


					}
					
					// console.log(b['IdLoaiSP']);
					$('.selecloaisp').val(b['IdLoaiSP']);

				}

			});
			$('#btnUpdate').click(function(){
				var formdata=new FormData($('#formsp')[0]);
				formdata.append('id',$('#id').val());
				$.ajax({
					url:'../Process/ProcessProducts.php?type=sua',
					type:'post',
					data:formdata,
					contentType: false,
					processData: false,
					success:function(data){
						$('#modalAU').modal('hide');
						Load();

					}

				});

			});
		});

		function DataStr($dateI) {
			var dateStr = $dateI + "";
			var nam = dateStr.substr(0, 4);
			var thang = dateStr.substr(4, 2);
			var ngay = dateStr.substr(6, 2);
			return nam + '-' + thang + '-' + ngay;
		}

		function TenTinhTrang($idTen) {
			if ($idTen == 0) {
				return "Default";
			} else if ($idTen == 1) {
				return "New";
			} else {
				return "Hot";
			}
		}

	})
</script>