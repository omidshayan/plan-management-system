<?php
session_start();
if (!isset($_SESSION['department-admin'])) {
  header('location: ../index.php');
}
include_once '../connect.php';
$sql1 = "SELECT * FROM sections";
$result1 = $connect->query($sql1);
$sectionInfos = $result1->fetchAll(PDO::FETCH_ASSOC);
include_once 'header.php';
?>

<!-- content -->
<div class="title">
  <div class="title-text">ثبت کارمند جدید</div>
</div>
<br>

<div class="box-content-container">
  <div class="insert">

    <?php if (isset($_GET['inserted'])) : ?>
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

    <form action="back/add-employee-check.php" method="POST" enctype="multipart/form-data">
      <div class="lable">نام و تخلص <span class="errors">*</span></div>
      <input type="text" placeholder="نام و تخلص را وارد نمایید..." name="name" autocomplete="off">
      <div class="lable">وظیفه <span class="errors">*</span></div>
      <select name="role">
        <option selected disabled>وظیفه را انتخاب نمایید</option>
        <option value="2">مدیر تدریسی</option>
        <option value="1">استاد</option>
      </select>
      <div class="lable">بخش مربوطه <span class="errors">*</span></div>
      <select name="position">
        <option selected disabled>انتخاب بخش مربوطه</option>
        <?php foreach ($sectionInfos as $sectionInfo) : ?>
          <option value="<?= $sectionInfo['name'] ?>"><?= $sectionInfo['name'] ?></option>
        <?php endforeach; ?>
      </select>
      <div class="lable">موبایل <span class="errors">*</span></div>
      <input type="text" placeholder="شماره موبایل را وارد نمایید..." name="phone" id="phoneField" autocomplete="off">
      <div class="lable">ایمیل</div>
      <input type="text" placeholder="ایمیل را وارد نمایید..." name="email" autocomplete="off">
      <div class="lable">رمزعبور <span class="errors">*</span></div>
      <input type="password" id="passwordInput" placeholder="رمز عبور را وارد کنید..." name="password">
      <div class="lable">انتخاب عکس</div>
      <input type="file" name="image">

      <input type="submit" value="ثبت" class="btn btn-color">
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

  // copy phone number in password input
  document.getElementById('phoneField').addEventListener('input', function() {
    document.getElementsByName('password')[0].value = this.value;
  });
</script>

<?php
include_once 'footer.php';
?>