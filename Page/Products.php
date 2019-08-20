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
		//Thêm
		// Hiển thị modal thêm lên
		$('#btnadd').click(function() {
			$('#modalAU').modal('show');
			$('.inputid').hide();
			$('#btnUpdate').hide();
			$('#txtadd').text("Thêm sản phẩm");
		});
		//Thêm ở modal
		$('#btnInsert').click(function() {
			var formData=new FormData($('#formsp')[0]);
			$.ajax({
				url: '../Process/ProcessProducts.php?type=them',
				type: 'post',
				data: formData,
				contentType: false,
				processData: false,
				success: function(data) {
					$('#modalAU').modal('hide');
					Load();
					alert(data);
				}
			});
		});

		// alert(doingay());
		// Thoat trong modal
		$('#btnClose').click(function() {
			$('#modalAU').modal('hide');
		});
		// Sua trong table - Ủy nhiệm hàm
		$(document).on('click', '#btnsua', function() {
			var id = $(this).data('id'); // data-id=10
			$('#add').text("Sửa Sản Phẩm");
			$('#btnInsert').hide();
			$('#btnUpdate').show();
			$('.inputid').show();
			$('#id').attr("readonly", "readonly");
			$('#modalAU').modal('show');
			// alert();
			//Hiển thị thông tin dữ liệu lên modal
			$.ajax({
				url: '../Process/ProcessProducts.php',
				type: 'get',
				data: {
					type: 'getid',
					id: id
				},
				dataType: 'JSON',
				success: function(data) {
					console.log(data);
					// data=JSON.parse(data);
					$('#id').val(data.Id);
					$('#tsp').val(data.TenSP);
					$('#gm').val(data.GiaMoi);
					$('#gc').val(data.GiaCu);
					$('#sl').val(data.SoLuong);
					// alert(data['SoLuong']);
					var ngay = GanNgay(data['NgayNhap']); // YYYY-MM-DD
					$('#nn').val(ngay);
					$('#tinhtrang').val(data['TinhTrang']);
					var rd = data['TrangThai'];
					if (rd == "1") {
						$("input[name='trangthai'][value='1']").prop('checked', true);
						$("input[name='trangthai'][value='(data['TrangThai'])']").removeAttr("checked");

					} else {
						$("input[name='trangthai'][value='0']").prop('checked', true);
						$("input[name='trangthai'][value='(data['TrangThai'])']").removeAttr("checked");
					}
					$('.selecloaisp').val(data['IdLoaiSP']);
				}
			});
		});
		$(document).on('click', '#btndelete', function() {
			var id = $(this).data('id'); // data-id=10
			// Hien modal xoa len
			$('#modalD').modal('show');
			$.ajax({
				url: '../Process/ProcessProducts.php?type=xoa&id=' + id,
				success: function(data) {
					// alert("Xóa xong rồi uyên!!!");
					$('#btnco').click(function() {
						load();
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
		// sửa trong modal upload lên bảng

		$("#btn-edit").on('click', function() {
			alert();
			// e.preventDefault();
			var str = $("#form-edit").serialize();
			console.log(str);
			$.ajax({
				url: '../Process/ProcessProducts.php',
				type: 'get',
				data: str,
				dataType: 'JSON',
				success: function(data) {
					$('#modalAU').modal('hide');
					Load();
				}
			});
		});

		$('#btnUpdate').click(function() {
			var id = $('#id').val();
			var tsp = $('#tsp').val();
			var gm = $('#gm').val();
			var gc = $('#gc').val();
			var sl = $('#sl').val();
			var ngay = $('#nn').val(); //2019-08-09 -> "20190809" -> 20190809
			var tinhtrang = $('#tinhtrang').val();
			var tt = $("input[name='trangthai']:checked").val();
			var idl = $('.selecloaisp').val();

			// alert(tsp+gm+gc+sl+ngay+tinhtrang+tt+idl);
			$.ajax({
				url: '../Process/ProcessProducts.php',
				type: 'get',
				data: {
					type: 'sua',
					id: id,
					tsp: tsp,
					gm: gm,
					gc: gc,
					sl: sl,
					nn: ngay,
					tinhtrang: tinhtrang,
					tt: tt,
					idl: idl
				},
				// dataType:'JSON',
				success: function(data) {
					$('#modalAU').modal('hide');
					Load();
				}
			});
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
		// Chuyển ngày kiểu int sang chuỗi YYYY-MM-DD
		function GanNgay($ngayI) {
			$ngayS = $ngayI + "";
			$nam = $ngayS.substr(0, 4);
			$thang = $ngayS.substr(4, 2);
			$ngay = $ngayS.substr(6, 2);
			return $nam + "-" + $thang + "-" + $ngay;
		}
	})

	// });
</script>