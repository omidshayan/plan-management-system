<?php
session_start();
if (!isset($_SESSION['user-admin'])) {
    header('location: ../index.php');
}
include_once '../connect.php';
$sql1 = "SELECT * FROM sections";
$result1 = $connect->query($sql1);
$sectionInfos = $result1->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM users";
$result = $connect->query($sql);
$users = $result->fetchAll(PDO::FETCH_ASSOC);
include_once 'header.php';
?>

<!-- content -->
<div class="title">
    <div class="title-text">ارسال پیام جدید</div>
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

        <form action="back/send-message-check.php" method="POST">
            <div class="send-message">
                <input type="radio" id="employee" name="options" value="employee" class="radio">
                <label for="employee">ارسال پیام به کارمند</label><br>
            </div>
            <select name="user_id">
                <option selected disabled>یک کارمند را انتخاب نمایید</option>
                <?php foreach ($users as $user) : ?>
                    <option value="<?= $user['id'] ?>"><?= $user['name'] ?></option>
                <?php endforeach; ?>
            </select>

            <div class="send-message">
                <input type="radio" id="section" name="options" value="option1" class="radio">
                <label for="section">ارسال پیام به بخش</label><br>
            </div>
            <select name="section_id">
                <option selected disabled>یک بخش را انتخاب نمایید</option>
                <?php foreach ($sectionInfos as $sectionInfo) : ?>
                    <option value="<?= $sectionInfo['id'] ?>"><?= $sectionInfo['name'] ?></option>
                <?php endforeach; ?>
            </select>

            <div class="lable">عنوان پیام <span class="errors">*</span></div>
            <input type="text" placeholder="عنوان را وارد نمایید..." name="title" autocomplete="off" required>

            <div class="lable">متن پیام<span class="errors">*</span></div>
            <textarea rows="" name="content" required></textarea>
            <input type="submit" value="ثبت" class="btn btn-color">
        </form>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var employeeRadio = document.getElementById('employee');
                var sectionRadio = document.getElementById('section');
                var userSelect = document.querySelector('select[name="user_id"]');
                var sectionSelect = document.querySelector('select[name="section_id"]');

                // فعال کردن و غیرفعال کردن تگ‌های select
                function toggleSelects() {
                    userSelect.disabled = !employeeRadio.checked;
                    sectionSelect.disabled = !sectionRadio.checked;
                }

                // اجرای تابع toggleSelects هنگامی که یکی از رادیو باتن‌ها انتخاب می‌شود
                employeeRadio.addEventListener('change', toggleSelects);
                sectionRadio.addEventListener('change', toggleSelects);

                // فراخوانی تابع برای بررسی وضعیت اولیه
                toggleSelects();
            });
        </script>


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