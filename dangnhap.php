<?php 
session_start(); 



if (isset($_POST['submit'])) {
	if ($_POST['name']=='' || $_POST['pass']=='') {
		$error= "Vui lòng nhập đầy đủ thông tin!";
	}else{
		$un=$_POST['name'];
		$pw=$_POST['pass'];
		require 'Page/ketnoi.php';
		$stmt = $conn->prepare('SELECT * FROM user WHERE username=:username AND password=:password');
		$stmt->execute(['username'=>$un,'password'=>$pw]);
		$count=$stmt->rowCount();
		if($count>0){
			$stmt = $conn->prepare('SELECT * FROM user WHERE username=:username AND password=:password AND role=:quyen');
			$stmt->execute(['username'=>$un,'password'=>$pw, 'quyen'=>2]);
			$count=$stmt->rowCount();
			if ($count>0) {
				$_SESSION['key']=$un;
				header("Location:Page/Products.php");
			}
			else{
				$error= "Thành viên không có quyền truy cập vào trang này!";
			}
			
		}else{
			$error= "Tên đăng nhập hoặc mật khẩu k đúng!";
		}
	}

	
}
//kiem tra conoi


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>trang đăng nhập</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
	
	<center style="margin-left: 300px;margin-right: 300px; border: solid">
		<h1 style="color: green">PAGE LOGIN</h1>
		<form method="POST" action='dangnhap.php' style="margin-top: 30px;">
			<div class="form-group">
				<label>Username</label>
				<input style="width: auto;" type="text" placeholder="Username" name="name" id="un">
			</div>
			<div class="form-group">
				<label>Password</label>
				<input style="width: auto;" type="password" placeholder="Password" name="pass" id="pw">
			</div>
			<label style="color:red"><?php echo isset($error)?$error:"" ?></label>
			<div style="margin-right: 60px; margin-bottom: 10px">
				<input  type="submit" name="submit" class="btn btn-success" value="Login"> 
				<input  type="submit" name="submit" class="btn btn-success" value="Log out"> 
			</div>
		</form>
	</center>


	
</body>
</html>
