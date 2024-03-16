<?php
session_start();
if (!isset($_SESSION['user-admin'])) {
  header('location: ../index.php');
}
include_once 'header.php';
include_once '../connect.php';
$sql = "SELECT * FROM `sections` WHERE `id` = ?";
$result = $connect->prepare($sql);
$result->bindValue(1, $_GET['id']);
$result->execute();
$userInfo = $result->fetch(PDO::FETCH_OBJ);

$sql = "SELECT * FROM users";
$result = $connect->query($sql);
$userInfos = $result->fetchAll(PDO::FETCH_ASSOC);
?>


<!-- content -->
  <div class="title">
    <div class="title-text">ویرایش بخش: <?= $userInfo->name ?></div>
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

      <form action="back/section-edit-check.php" method="POST">
        <div class="lable">نام بخش <span class="errors">*</span></div>
        <input type="text" placeholder="نام را وارد نمایید..." name="name" value="<?= $userInfo->name ?>" autocomplete="off">
        <div class="lable">رئیس بخش <span class="errors">*</span></div>
        <select name="admin">
          <option disabled>رئیس را انتخاب نمایید</option>
          <?php foreach ($userInfos as $user) :
            $name = $user['name'];
            $selectedUser = ($name == $userInfo->admin) ? 'selected' : '';
          ?>
            <option value="<?= $name ?>" <?= $selectedUser ?>>
              <?= $name ?>
            </option>
          <?php endforeach; ?>
        </select>

        <div class="lable">معاون بخش <span class="errors">*</span></div>
        <select name="deputy">
          <option selected disabled>معاون را انتخاب نمایید</option>
          <?php foreach ($userInfos as $user) :
            $name = $user['name'];
            $selectedUser = ($name == $userInfo->deputy) ? 'selected' : '';
          ?>
            <option value="<?= $name ?>" <?= $selectedUser ?>>
              <?= $name ?>
            </option>
          <?php endforeach; ?>
        </select>

        <div class="lable">مدیرت تدریسی بخش <span class="errors">*</span></div>
        <select name="teaching">
          <option selected disabled>مدیر تدریسی را انتخاب نمایید</option>
          <?php foreach ($userInfos as $user) :
            $name = $user['name'];
            $selectedUser = ($name == $userInfo->teaching) ? 'selected' : '';
          ?>
            <option value="<?= $name ?>" <?= $selectedUser ?>>
              <?= $name ?>
            </option>
          <?php endforeach; ?>
        </select>

        <div class="lable">ملاحضات</div>
        <input type="text" placeholder="ملاحضات را وارد نمایید..." value="<?= $userInfo->description ?>" name="description" autocomplete="off">
        <input type="hidden" name="id" value="<?= $userInfo->id ?>">


        <input type="submit" value="ثبت" class="btn btn-color">
      </form>

    </div>
  </div>
<!-- end content -->


<?php
include_once 'footer.php';
?>