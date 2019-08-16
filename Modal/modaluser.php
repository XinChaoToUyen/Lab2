<div class="modal fade" id="modalAU" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="add">Insert User</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form>
					<div class="form-group">
						<div class="inputid">
							<label class="col-form-label">Id</label>
							<input type="text" class="form-control" id="id">
						</div>
						
						
						<label class="col-form-label">Username</label>
						<input type="text" class="form-control" id="un">
						<label class="col-form-label">Password</label>
						<input type="Password" class="form-control" id="pw">
						<label  class="col-form-label">Role</label>
						<select class="form-control" id="role">
							<option value="1" selected>Thành viên</option>
							<option value="2">Admin</option>
						</select>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" id="btnInsert" class="btn btn-success">Thêm</button>
					<button type="button" id="btnUpdate" class="btn btn-warning">Sửa</button>
					<button type="button" id="btnClose" class="btn btn-dark">Thoát</button>
					
				</div>
			</div>
		</div>
	</div>

</div>