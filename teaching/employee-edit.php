<?php
session_start();
if (!isset($_SESSION['teaching'])) {
  header('location: ../index.php');
}
include_once 'header.php';
include_once '../connect.php';
$sql = "SELECT * FROM `users` WHERE `id` = ?";
$result = $connect->prepare($sql);
$result->bindValue(1, $_GET['id']);
$result->execute();
$userInfo = $result->fetch(PDO::FETCH_OBJ);


$sql1 = "SELECT * FROM sections";
$result1 = $connect->query($sql1);
$sectionInfos = $result1->fetchAll(PDO::FETCH_ASSOC);
?>


<!-- content -->
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
    <?php if (isset($_GET['employee'])) : ?>
      <script>
        $(document).ready(function() {
          Swal.fire({
            icon: 'error',
            title: 'خطا در ثبت',
            text: 'برای این بخش کارمند ثبت شده است!',
            customClass: {
              'swal2-popup': 'black-background'
            }
          });
        });
      </script>
    <?php endif; ?>


    <form action="back/edit-employee-check.php" method="POST" enctype="multipart/form-data">
      <div class="lable">نام و تخلص <span class="errors">*</span></div>
      <input type="text" placeholder="نام و تخلص را وارد نمایید..." name="name" value="<?= $userInfo->name ?>" autocomplete="off">
      <div class="lable">وظیفه <span class="errors">*</span></div>
      <select name="role">
        <option disabled>وظیفه را انتخاب نمایید</option>
        <option value="4" <?= ($userInfo->role == 4) ? 'selected' : '' ?>>رئیس دیپارتمنت</option>
        <option value="3" <?= ($userInfo->role == 3) ? 'selected' : '' ?>>معاون</option>
        <option value="2" <?= ($userInfo->role == 2) ? 'selected' : '' ?>>مدیر تدریسی</option>
        <option value="1" <?= ($userInfo->role == 1) ? 'selected' : '' ?>>استاد</option>
      </select>

      <div class="lable">بخش مربوطه <span class="errors">*</span></div>
      <select name="position">
        <option selected disabled>انتخاب بخش مربوطه</option>
        <?php foreach ($sectionInfos as $sectionInfo) : ?>
          <option value="<?= $sectionInfo['id'] ?>" <?= ($userInfo->position == $sectionInfo['id']) ? 'selected' : '' ?>><?= $sectionInfo['name'] ?></option>
        <?php endforeach; ?>
      </select>

      <div class="lable">موبایل <span class="errors">*</span></div>
      <input type="text" placeholder="شماره موبایل را وارد نمایید..." name="phone" value="<?= $userInfo->phone ?>" autocomplete="off">
      <div class="lable">ایمیل</div>
      <input type="text" placeholder="ایمیل را وارد نمایید..." name="email" value="<?= $userInfo->email ?>" autocomplete="off">
      <div class="lable">رمزعبور <span class="errors">*</span></div>
      <input type="password" id="passwordInput" value="<?= $userInfo->password ?>" placeholder="رمز عبور را وارد کنید..." name="password">

      <?php
      if (isset($userInfo->image)) { ?>
        <img src="admin/<?= $userInfo->image ?>" alt="user profile" class="imgProfile"> <?php } else { ?>
        <img src="../assets/img/avatar.png" alt="user profile" class="imgProfile">

      <?php }
      ?>


      <input type="hidden" name="id" value="<?= $userInfo->id ?>">
      <input type="file" name="image">

      <input type="submit" value="ثبت" class="btn btn-color">
      <div class="center"><a href="employees.php" class="color">برگشت</a></div>
    </form>
  </div>
</div>

<!-- end content -->

<script>
  // show password
  var passwordInput = document.getElementById("passwordInput");
  passwordInput.addEventListener("click", function() {
    if (passwordInput.type === "password") {
      passwordInput.type = "text";
    } else {
      passwordInput.type = "password";
    }
  });
  passwordInput.addEventListener("blur", function() {
    passwordInput.type = "password";
  });
</script>
<?php
include_once 'footer.php';
?>