<?php
session_start();
if (!isset($_SESSION['deputy'])) {
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
    <div class="title-text">ثبت پلن جدید</div>
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


        <form action="back/add-plan-check.php" method="POST">
            <div class="input-group">
                <div class="input-item">
                    <div class="lable">زمان اجرا</div>
                    <input type="hidden" class="form-control d-none dateTime" name="execution_time" autofocus>
                    <input type="text" class="expire" id="dateTime" placeholder="زمان اجرا را وارد نمایید..." autofocus>
                </div>
                <div class="input-item">
                    <div class="lable">بودجه <span class="info">(افغانی)</span> </div>
                    <input type="text" placeholder="بودجه را وارد نمایید..." name="budget" autocomplete="off">
                </div>
            </div>

            <div class="lable">عنوان پلن <span class="errors">*</span> </div>

            <input type="text" placeholder="عنوان را وارد نمایید..." name="name" autocomplete="off">

            <div class="lable">هدف <span class="errors">*</span></div>
            <input type="text" placeholder="هدف را وارد نمایید..." name="target" autocomplete="off">

            <div class="lable">فعالیت <span class="errors">*</span></div>
            <input type="text" placeholder="فعالیت را وارد نمایید..." name="activiti" autocomplete="off">

            <div class="lable">مسئول اجرا <span class="errors">*</span></div>
            <select name="implementation">
                <option selected disabled>مسئول اجرا را انتخاب نمایید</option>
                <?php foreach ($userInfos as $userInfo) : ?>
                    <option value="<?= $userInfo['id'] ?>"><?= $userInfo['name'] ?></option>
                <?php endforeach; ?>
            </select>


            <div class="lable">پیگیری توسط <span class="errors">*</span></div>
            <select name="track">
                <option selected disabled>مسئول پیگیری را انتخاب نمایید</option>
                <?php foreach ($sectionInfos as $sectionInfo) : ?>
                    <option value="<?= $sectionInfo['id'] ?>"><?= $sectionInfo['name'] ?></option>
                <?php endforeach; ?>
            </select>
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