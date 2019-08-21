
<div class="modal fade" id="modalAU" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="txtadd">Insert User</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="formsp">
			<div class="modal-body">
				
					<div class="form-group">
						<div class="inputid">
							<label class="col-form-label">Id</label>
							<input type="text" class="form-control" name ="id" id="id">
						</div>
						
						
						<label class="col-form-label">Tên sản phẩm</label>
						<input type="text" class="form-control" name ="tsp" id="tsp">

						
						
						<label class="col-form-label">Giá mới</label>
						<input type="number" class="form-control" name ="gm" id="gm">

						
						
						<label class="col-form-label">Giá cũ</label>
						<input type="number" class="form-control" name ="gc" id="gc">


						<label class="col-form-label">Số lượng</label>
						<input type="number" class="form-control" name ="sl" id="sl">

						
						<label class="col-form-label">Ngày nhập</label>
						<!-- value="2009-09-19" hiện trên modal là: 19/09/2019--> 
						<input type="date" class="form-control" name="nn" id="nn">

						
						<label  class="col-form-label">Tình trạng</label>
						<select class="form-control" name="tinhtrang" id="tt">
							<option value="0" selected>Default</option>
							<option value="1">New</option>
							<option value="2">Hot</option>
						</select>

						<label for="recipient-name" class="col-form-label">Trạng thái</label>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="trangthai" value="0" id="trangthai">
							<label class="form-check-label">Ẩn</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="trangthai" value="1">
							<label class="form-check-label">Hiện</label>
						</div>
						<br>
						<label for="message-text" class="col-form-label">Loại sản phẩm</label>
						<select class="custom-select mr-sm-2 selecloaisp" name="slloai">
							<!-- <option selected>Loại Sản Phẩm</option>
							<option value="1">Bánh</option>
							<option value="2">Kẹo</option>
							<option value="3">Gạo</option> -->
						</select>
					</div>
				
			</div>
			<div class="modal-footer">
				<button type="button" id="btnInsert" class="btn btn-success">Thêm</button>
				<button type="button" id="btnUpdate" class="btn btn-warning">Sửa</button>
				<button type="button" id="btnClose" class="btn btn-dark">Thoát</button>
			</div>
			</form>
		</div>
	</div>
</div>
<!-- delete -->

<div class="modal fade" id="modalD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<h2>Delete</h2>
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="up">Bạn có chắc chắn xóa không?</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" id="btnco" class="btn btn-danger" data-dismiss="modal">Có</button>
			<button type="button" id="btnko" class="btn btn-success">Không</button>
		</div>
	</div>
</div>

