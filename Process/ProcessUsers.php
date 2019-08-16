<?php 
if(isset($_GET['type'])){
	$type=$_GET['type'];
	switch ($type) {
		case 'loaduser':
		Loaduser();
		break;
		case 'them':
		$un=$_GET['un'];
		$pw=$_GET['pw'];
		$role=$_GET['role'];
		require "../Page/ketnoi.php";
		$sql="INSERT INTO user(username,password,role) VALUES ('$un',$pw,$role)";
		// echo $sql;
		$stmt=$conn->prepare($sql);
		$stmt->execute();
		$count=$stmt->rowCount();
		echo $count;
		
		break;
		case 'pagigation':
		$page=$_GET['page'];//so trang nguoi dung dang chon de click vao
		$sotrang=ceil(soHang()/5);//lam trang len tong so trang
		for($i=1;$i<=$soTrang;$i++){
			if($page==$i){
				echo '<li class="page-item active"><a class="page-link pg">'.$i.'</a></li>';
				continue;
			}
			echo '<li class="page-item"><a class="page-link pg">'.$i.'</a></li>;
		}


		break;

		break;
		case 'sua':
		
		break;
		
		default:
			# code...
		break;
	}
}
function Loaduser(){
	require "../Page/ketnoi.php";
	$stmt=$conn->prepare('SELECT * FROM user ORDER BY id DESC');
	$stmt->execute();
	$table=$stmt->fetchAll();
	$stt=1;
	foreach ($table as $row) {
		echo "<tr>";
		echo "<td>".($stt++)."</td>";
		echo "<td>".$row['username']."</td>";
		echo "<td>".$row['password']."</td>";
		echo "<td>".Getrole($row['role'])."</td>";
		echo '<td><button type="button" data-id='.$row["id"].' class="btn btn-warning" id="btnsua">Sửa</button>';
		echo '<button type="button" data-id='.$row["id"].' class="btn btn-danger btn-delete" id="btndelete" value="'.$row["id"].'">Xóa</button></td>';
		echo "</tr>";
	}
}
function Getrole($role){
	// 1-thành viên, 2-admin
	if($role==1){
		return "Thành viên";
	}else{
		return "Admin";
	}

}
function soHang(){
	require "../Page/ketnoi.php";
	$sql='SELECT * FROM user';
	$stmt=$conn->prepare($sql);
	$stmt->execute();
	$count=$stmt->rowCount();
	return $count;
}


?>