<?php
session_start();
if (!isset($_SESSION['department-admin'])) {
    header('location: ../index.php');
}

include_once 'header.php';
include_once '../connect.php';
$sql = "SELECT * FROM users";
$result = $connect->query($sql);
$userInfos = $result->fetchAll(PDO::FETCH_ASSOC);

$sql1 = "SELECT * FROM sections";
$result1 = $connect->query($sql1);
$sectionInfos = $result1->fetchAll(PDO::FETCH_ASSOC);
?>
<!-- content -->
<div class="title">
    <div class="title-text">ثبت فعالیت جدید</div>
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
                        text: 'مشکل در ثبت!',
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


        <form action="back/add-activity-check.php" method="POST">
            <div class="input-group">
            <div class="input-item">
                    <div class="lable">عنوان فعالیت </div>
                    <input type="text" placeholder="عنوان را وارد نمایید..." name="name" autocomplete="off">
                </div>
                <div class="input-item">
                    <div class="lable">تاریخ</div>
                    <input type="hidden" class="form-control d-none dateTime" name="date" autofocus>
                    <input type="text" class="expire" id="dateTime" placeholder="زمان اجرا را وارد نمایید..." autofocus>
                </div>

            </div>

            <div class="lable">توضیحات فعالیت<span class="errors">*</span> </div>
            <textarea name="content" cols="30" rows="10" placeholder="..."></textarea>

            <input type="submit" value="ثبت" class="btn btn-color">
        </form>

    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $(".expire").pDatepicker({
            format: 'YYYY-MM-DD',
            autoClose: true,
            toolbox: {
                calendarSwitch: {
                    enabled: true
                }
            },
            observer: true,
            altField: '.dateTime'
        });
    });
</script>
<!-- end content -->


<?php
include_once 'footer.php';
?>