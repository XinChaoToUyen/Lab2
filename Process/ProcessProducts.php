<?php 
if (isset($_GET['type'])) {
	$type=$_GET['type'];
	switch ($type) {
		case 'load':
		Load();
		break;


		case 'them':
		ThemSP();
		break;


		case 'sua':
		$tsp= $_GET["tsp"];
		$gm=$_GET['gm'];
		$gc=$_GET['gc'];
		$sl=$_GET['sl'];
		$id=$_GET['id'];
		$day=NgayNhap($_GET['nn']);
		$tt=$_GET['tinhtrang'];
		$trangthai=(bool)$_GET['tt'];
		$loai=$_GET['idl'];
		require "../Page/ketnoi.php";
		$sql="UPDATE sanpham
		SET TenSP = '$tsp', GiaMoi=$gm, GiaCu=$gm,SoLuong=$sl,NgayNhap='$day',TinhTrang='$tt',TrangThai='$trangthai',IdLoaiSP=$loai
		WHERE Id = ".$id;
		$stmt=$conn->prepare($sql);
		$stmt->execute();
		echo $count =$stmt->rowCount();
		break;
		case 'getid':
		$id=$_GET['id'];
		Getid($id);
		break;
		case 'xoa':
		delete($_GET['id']);
		break;
		case 'tenloai':
		GetTenLoai();
		break;
		case 'phantrang':
		require "../Page/ketnoi.php";
		$sotrangtin=5;
		$trang=$_GET['trang'];
		settype($trang,"integer");
		$from=($trang-1)*$sotrangtin;
		$sql="SELECT Id, Title FROM phantrang
		ORDER BY Id ASC
		LIMIT $from,$sotrangtin";
		$stmt=$conn->prepare($sql);
		$stmt->execute();
		$table=$stmt->fetchAll();
		foreach($table as $row){
			echo '<a href="'.$row['Id'].'">'.$row['Title']."|".'</a>';
		}
		break;
		case 'pagination':
		$page=$_GET['page']; // Số trang mà người dùng đang chọn
		$soTrang=ceil(soHang()/5);
		// echo $soTrang;
		echo '<li class="page-item '.($page==1?"disabled":"").'" style="cursor:pointer;color:blue"><a class="page-link prev">Previous</a></li>';
		for($i=1;$i<=$soTrang;$i++){
			if($page==$i){
				echo '<li style="cursor:pointer" class="page-item active"><a class="page-link pg">'.$i.'</a></li>';
				continue;
			}
			echo '<li style="cursor:pointer" class="page-item"><a class="page-link pg">'.$i.'</a></li>';
		}
		echo '<li class="page-item '.($page==$soTrang?"disabled":"").'" style="cursor:pointer;color:blue"><a class="page-link next">Next</a></li>';
		break;
		case 'sapxep':
		break;
		case 'search':
		Search();
		break;
		default:
		# code...
		break;
	}
}
function soHang(){
	require "../Page/ketnoi.php";
	$sql="SELECT * FROM sanpham";
	$stmt=$conn->prepare($sql);
	$stmt->execute();
	$count=$stmt->rowCount();
	return $count;
}
// chuỗi sang int
function NgayNhap($nn="2019-08-01"){
	$str=str_replace("-","",$nn);
	$int=(int)$str;
	return $int;
}
NgayNhap();
function Load(){
	// require "../css/css.php";
	require "../Page/ketnoi.php";
	$page=$_GET['page'];
	$pos=($page-1)*5;
	$sql="SELECT * FROM sanpham ORDER BY Id DESC LIMIT $pos,5";
	// echo $sql;
	$stmt=$conn->prepare($sql);
	$stmt->execute();
	$table=$stmt->fetchAll();
	// var_dump($table);
	$stt=$pos+1;
	foreach ($table as $row) {
		echo "<tr>";
		// echo "<td>".$row["Id"]."</td>";
		echo "<td>".($stt++)."</td>";
		echo "<td>".$row["TenSP"]."</td>";
		echo "<td>".number_format($row["GiaMoi"])."</td>";
		echo "<td>".number_format($row["GiaCu"])."</td>";
		echo "<td>".$row["SoLuong"]."</td>";
		echo "<td>".XuLyNgay($row["NgayNhap"])."</td>";
		echo "<td>".TenTinhTrang($row["TinhTrang"])."</td>";
		echo "<td>".GetIdTrangThai($row["TrangThai"])."</td>";
		echo "<td>".TenLoaiSP($row["IdLoaiSP"])."</td>";
		echo '<td><button type="button" data-id='.$row["Id"].' class="btn btn-warning" id="btnsua">Sửa</button>';
		echo '<button type="button" data-id='.$row["Id"].' class="btn btn-danger btn-delete" id="btndelete" value="'.$row["Id"].'">Xóa</button></td>';
		echo "</tr>";	
	}
}
function delete($id){
	require "../Page/ketnoi.php";
	$SQL = "DELETE FROM sanpham WHERE Id = ".$id;
	$stmt=$conn->prepare($SQL);
	$stmt->execute();
}
function XuLyNgay($ngayI){
	$ngayS=$ngayI."";

	$nam=substr($ngayS,0,4);
	$thang=substr($ngayS,4,2);
	$ngay=substr($ngayS,6,2);
	return $ngay."/".$thang."/".$nam;
}
function TenLoaiSP($id){
	require "../Page/ketnoi.php";
	$stmt=$conn->prepare("SELECT TenLoai FROM loaisp where Id=$id");
	$stmt->execute();
	$rs=$stmt->fetchAll();
	return $rs[0][0];
}
function TenTinhTrang($tt){
	if($tt==1){
		return "New";
	}
	else if($tt==0){
		return "Default";
	}
	else{
		return "Hot";
	}
}
function TrangThai($tt){
	if($tt==0){
		return "Ẩn";
	}else{
		return "Hiện";
	}
}
function GetTenLoai(){
	require "../Page/ketnoi.php";
	$stmt=$conn->prepare("SELECT * FROM loaisp");
	$stmt->execute();
	$rs=$stmt->fetchAll();
	// var_dump($rs);
	foreach ($rs as $row) {
		echo '<option value="'.$row['Id'].'">'.$row['TenLoai'].'</option>';
	}
}
function Getid($id){
	require "../Page/ketnoi.php";
	$stmt=$conn->prepare("SELECT * FROM sanpham WHERE Id=:id");
	$stmt->execute(["id"=>$id]);
	$rs=$stmt->fetch(PDO::FETCH_ASSOC);
	$count=$stmt->rowCount();
	if($count>0){
		echo json_encode(array('data'=>$rs));
	}
}
function Search(){
	$sr=$_GET['sr'];
	require "../Page/ketnoi.php";
	$sql="SELECT * FROM sanpham WHERE TenSP LIKE '%$sr%' OR 
	Id LIKE '%$sr%' OR 
	GiaMoi LIKE '%$sr%' OR 
	GiaCu LIKE '%$sr%' OR 
	SoLuong LIKE '%$sr%' OR 
	NgayNhap LIKE '%$sr%' OR 
	TinhTrang LIKE '%$sr%' OR 
	TrangThai LIKE '%$sr%'";
	// echo $sql;
	$stmt=$conn->prepare($sql);
	$stmt->execute();
	$table=$stmt->fetchAll();
	$stt=1;
	foreach ($table as $row) {
		echo "<tr>";
		// echo "<td>".$row["Id"]."</td>";
		echo "<td>".($stt++)."</td>";
		echo "<td>".$row["TenSP"]."</td>";
		echo "<td>".number_format($row["GiaMoi"])."</td>";
		echo "<td>".number_format($row["GiaCu"])."</td>";
		echo "<td>".$row["SoLuong"]."</td>";
		echo "<td>".XuLyNgay($row["NgayNhap"])."</td>";
		echo "<td>".TenTinhTrang($row["TinhTrang"])."</td>";
		echo "<td>".TrangThai($row["TrangThai"])."</td>";
		echo "<td>".TenLoaiSP($row["IdLoaiSP"])."</td>";
		echo '<td><button type="button" data-id='.$row["Id"].' class="btn btn-warning" id="btnsua">Sửa</button>';
		echo '<button type="button" data-id='.$row["Id"].' class="btn btn-danger btn-delete" id="btndelete" value="'.$row["Id"].'">Xóa</button></td>';
		echo "</tr>";
		
	}

}
function GetIdTinhTrang($sr){
	if($sr=="default"){
		return 0;
	}
	else if($sr=="hot")
	{
		return 2;
	}
	else
	{
		return 1;
	}
}
function GetIdTrangThai($sr){
	if($sr=="0"){
		return Ẩn;
	}
	return Hiện;
	
}
function ThemSP(){
require "../Page/ketnoi.php";
// echo $_POST['tsp']."=".$_POST['gc']."=".$_POST['gm']."=".$_POST['sl']."=".$_POST['nn']."=".$_POST['tinhtrang']."=".$_POST['trangthai']."=".$_POST['slloai'];
$stmt=$conn->prepare("INSERT INTO sanpham(TenSP,GiaCu,GiaMoi,SoLuong,NgayNhap,TinhTrang,TrangThai,IdLoaiSP) VALUES (:tsp,:gc,:gm,:sl,:nn,:tt,:trangthai,:tenloai)");
$stmt->execute([
	'tsp'=>$_POST['tsp'],
	'gc'=>$_POST['gc'],
	'gm'=>$_POST['gm'],
	'sl'=>$_POST['sl'],
	'nn'=>DateI($_POST['nn']),
	'tt'=>$_POST['tinhtrang'],
	'trangthai'=>(bool)$_POST['trangthai'],
	'tenloai'=>$_POST['slloai'],
]);
$count=$stmt->rowCount();
echo $count;
}
// 2009-09-19 nhập vào-. xuất ra là 09/19/2019
function DateI($dateS){
	return (int)str_replace('-','',$dateS);
}
