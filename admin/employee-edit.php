<?php
session_start();
if (!isset($_SESSION['user-admin'])) {
  header('location: ../index.php');
}
include_once 'sidebar.php';
include_once '../connect.php';
$sql = "SELECT * FROM `users` WHERE `id` = ?";
$result = $connect->prepare($sql);
$result->bindValue(1, $_GET['id']);
$result->execute();
$userInfo = $result->fetch(PDO::FETCH_OBJ);
?>


<!-- content -->
<div class="content">
  <div class="title">
    <div class="title-text">ویرایش کارمند: <?= $userInfo->name ?></div>
  </div>
  <br>

  <div class="box-content-container">
    <div class="insert">
    <?php if (isset($_GET['editing'])) : ?>
        <script>
          $(document).ready(function() {
            Swal.fire({
              icon: 'success',
              text: 'عملیات با موفقیت انجام شد!',
              customClass: {
                'swal2-popup': 'black-background'
              }
            });
          });
        </script>
      <?php endif; ?>
      <?php if (isset($_GET['error'])) : ?>
        <script>
          $(document).ready(function() {
            Swal.fire({
              icon: 'error',
              title: 'خطا در ثبت',
              text: 'مشکلی در ثبت پیش آمده!',
              customClass: {
                'swal2-popup': 'black-background'
              }
            });
          });
        </script>
      <?php endif; ?>
      <?php if (isset($_GET['repeat'])) : ?>
        <script>
          $(document).ready(function() {
            Swal.fire({
              icon: 'error',
              title: 'خطا در ثبت',
              text: 'شماره موبایل تکراری است!',
              customClass: {
                'swal2-popup': 'black-background'
              }
            });
          });
        </script>
      <?php endif; ?>
      <?php if (isset($_GET['empty'])) : ?>
        <script>
          $(document).ready(function() {
            Swal.fire({
              icon: 'error',
              title: 'خطا در ثبت',
              text: 'لطفا قسمت های ضروری را وارد نمایید!',
              customClass: {
                'swal2-popup': 'black-background'
              }
            });
          });
        </script>
      <?php endif; ?>

      <form action="back/edit-employee-check.php" method="POST" enctype="multipart/form-data">
        <div class="lable">نام و تخلص</div>
        <input type="text" placeholder="نام و تخلص را وارد نمایید..." name="name" value="<?= $userInfo->name ?>" autocomplete="off">
        <div class="lable">وظیفه</div>
        <select name="role">
          <option disabled>وظیفه را انتخاب نمایید</option>
          <option value="2" <?= ($userInfo->role == 2) ? 'selected' : '' ?>>رئیس دیپارتمنت</option>
          <option value="3" <?= ($userInfo->role == 3) ? 'selected' : '' ?>>استاد</option>
        </select>
        <div class="lable">موبایل</div>
        <input type="text" placeholder="شماره موبایل را وارد نمایید..." name="phone" value="<?= $userInfo->phone ?>" autocomplete="off">
        <div class="lable">ایمیل</div>
        <input type="text" placeholder="ایمیل را وارد نمایید..." name="email" value="<?= $userInfo->email ?>" autocomplete="off">
        <div class="lable">رمزعبور</div>
        <input type="password" id="passwordInput" value="<?= $userInfo->password ?>" placeholder="رمز عبور را وارد کنید..." name="password">
        <img src="admin/<?= $userInfo->image ?>" alt="user profile" class="imgProfile">
        <input type="hidden" name="id" value="<?= $userInfo->id ?>">
        <input type="file" name="image">

        <input type="submit" value="ثبت" class="btn">
        <div class="center"><a href="employees.php" class="color">برگشت</a></div>
      </form>
    </div>
  </div>

</div>
<!-- end content -->


<?php
include_once 'footer.php';
?>