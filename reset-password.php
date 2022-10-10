<?php
    if (!isset($_SESSION)) {
        session_start();
    }
	
if (isset($_SESSION['idUser'])) {
	header("Location: /");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Quên mật khẩu - Thế Giới Khăn Ướt | EcoWipes</title>
	<?php require_once 'library.php'; ?>
	<style>
		.loading-gif {
			background-image: url("assets/imgs/icon/loading.gif");
			background-position: left;
			background-repeat: no-repeat;
			background-size: contain;
			float: left;
			width: 24px;
			height: 24px;
			margin-right: 10px;
			display: none;
		}
	</style>
</head>

<body>
	<?php require_once 'header.php' ?>

	<main class="main pages">
		<div class="page-content pt-50 pb-150">
			<div class="container">
				<div class="row">
					<div class="col-xl-6 col-lg-6 col-md-12 m-auto">
						<div class="login_wrap widget-taber-content background-white">
							<div class="padding_eight_all bg-white">
								<div class="heading_s1">
									<img class="border-radius-15" src="assets/imgs/page/forgot_password.svg" alt>
									<h2 class="mb-15 mt-15">Quên mật khẩu đúng hông?</h2>
									<p class="mb-30">Hãy nhập địa chỉ email mà bạn đã đăng ký tài khoản.</p>
								</div>
								<form method="post" id="reset-password">
									<div class="form-group">
										<input type="text" required name="email" id="email" placeholder="Địa chỉ email">
									</div>
									<div class="form-group">
										<button type="submit" class="btn btn-heading btn-block hover-up" id="btn-resetpassword"><span class="loading-gif"></span>Lấy lại mật khẩu<span></span></button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
</body>
<?php require_once 'footer.php' ?>
<?php require_once 'script.php' ?>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
	$("#reset-password").submit(function(e) {
		e.preventDefault();
		var email = $('#email').val();

		$('.loading-gif').css("display", "block");
		$('#btn-resetpassword').prop('disabled', true);
		$.ajax({
				method: "POST",
				url: "processSendEmailResetPassword",
				data: "email=" + email,
				// dataType:"json",
			})
			.done(function(data) {
				if (data == true) {
					Swal.fire({
						html: "<strong>Yêu cầu tạo lại mật khẩu thành công</strong><br> <div class='mt-10' style='font-size:16px;'>Vui lòng kiểm tra hộp thư của bạn!<div>",
						icon: "success",
					});
				} else {
					Swal.fire({
						html: "<strong>Yêu cầu tạo lại mật khẩu không thành công</strong><br>",
						icon: "error",
					});
				}
				$('.loading-gif').css("display", "none");
				$('#btn-resetpassword').prop('disabled', false);
			});
	});
</script>

</html>