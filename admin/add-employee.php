<?php
session_start();
if (!isset($_SESSION['user-admin'])) {
  header('location: ../index.php');
}
include_once 'sidebar.php';
?>

<!-- content -->
<div class="content">
  <div class="title">
    <div class="title-text">ثبت کارمند جدید</div>
  </div>
  <br>

  <div class="box-content-container">
    <div class="insert">
      <?php if (isset($_GET['inserted'])) {
        echo '<span class="success">عملیات با موفقیت انجام شد</span>';
      } ?>
      <?php if (isset($_GET['error'])) {
        echo '<span class="errors">مشکل در ثبت کارمند جدید</span>';
      } ?>
      <?php if (isset($_GET['repead'])) {
        echo '<span class="errors">شماره موبایل تکراری است</span>';
      } ?>
      <?php if (isset($_GET['empty'])) {
        echo '<span class="errors">لطفا قسمت های ستاره دار را وارد نمایید</span>';
      } ?>

      <form action="back/add-employee-check.php" method="POST" enctype="multipart/form-data">
        <div class="lable">نام و تخلص</div>
        <input type="text" placeholder="نام و تخلص را وارد نمایید..." name="name" autocomplete="off">
        <div class="lable">وظیفه</div>
        <select name="role">
          <option selected disabled>وظیفه را انتخاب نمایید</option>
          <option value="2">رئیس دیپارتمنت</option>
          <option value="3">استاد</option>
        </select>
        <div class="lable">موبایل</div>
        <input type="text" placeholder="شماره موبایل را وارد نمایید..." name="phone" id="phoneField" autocomplete="off">
        <div class="lable">ایمیل</div>
        <input type="text" placeholder="ایمیل را وارد نمایید..." name="email" autocomplete="off">
        <div class="lable">رمزعبور</div>
        <input type="password" id="passwordInput" placeholder="رمز عبور را وارد کنید..." name="password">
        <div class="lable">انتخاب عکس</div>
        <input type="file" name="image">

        <input type="submit" value="ثبت" class="btn">
      </form>

    </div>
  </div>

</div>
<!-- end content -->


<?php
include_once 'footer.php';
?>