<?php
session_start();
if (!isset($_SESSION['teacher'])) {
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

$sql2 = "SELECT * FROM `plans` WHERE `id` = ?";
$result2 = $connect->prepare($sql2);
$result2->bindValue(1, $_GET['id']);
$result2->execute();
$plan = $result2->fetch(PDO::FETCH_OBJ);
$shamsi_month = jdate('F', $plan->execution_time, '', 'Asia/Kabul', 'fa');
?>

<!-- content -->
    <div class="title">
        <div class="title-text">ویرایش پلان: <?= $plan->name ?></div>
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

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const checkbox = document.getElementById('checkboxInput');
                    const dateTimeInput = document.getElementById('dateTime');

                    // تابعی که وضعیت تیک باکس را بررسی و وضعیت فیلدهای مربوطه را تغییر می‌دهد
                    function toggleDateTimeInput() {
                        if (checkbox.checked) {
                            dateTimeInput.removeAttribute('disabled');
                            dateTimeInput.classList.remove('grayed-out');
                        } else {
                            dateTimeInput.setAttribute('disabled', 'disabled');
                            dateTimeInput.classList.add('grayed-out');
                        }
                    }

                    // اولین بار هم تابع را فراخوانی می‌کنیم تا وضعیت اولیه تنظیم شود
                    toggleDateTimeInput();

                    // رویداد change بر روی تیک باکس برای تغییر وضعیت فیلدها
                    checkbox.addEventListener('change', toggleDateTimeInput);
                });
            </script>


            <form action="back/plan-edit-check.php" method="POST">
                <span class="time-title">زمان اجرا: ماه <?= $shamsi_month ?></span>
                <div class="input-group">
                    <div class="input-item">
                        <div class="lable ral">
                            <input type="checkbox" class="checkbox" id="checkboxInput" name="checkbox">
                            <label for="checkboxInput"><span class="time-change">تغییر زمان اجرا</span></label>
                        </div>
                        <input type="hidden" class="form-control d-none dateTime" name="execution_time" autofocus>
                        <input type="text" class="expire" id="dateTime" value="<?= $plan->execution_time ?>" placeholder="زمان اجرا را وارد نمایید..." disabled autofocus>
                    </div>
                    <div class="input-item">
                        <div class="lable">بودجه <span class="info">(افغانی)</span> </div>
                        <input type="text" placeholder="بودجه را وارد نمایید..." name="budget" value="<?= $plan->budget ?>" autocomplete="off">
                    </div>
                </div>

                <div class="lable">عنوان پلان <span class="errors">*</span></div>
                <input type="text" placeholder="عنوان را وارد نمایید..." name="name" value="<?= $plan->name ?>" autocomplete="off">

                <div class="lable">هدف <span class="errors">*</span></div>
                <input type="text" placeholder="هدف را وارد نمایید..." name="target" value="<?= $plan->target ?>" autocomplete="off">

                <div class="lable">فعالیت <span class="errors">*</span></div>
                <input type="text" placeholder="فعالیت را وارد نمایید..." name="activiti" value="<?= $plan->activity ?>" autocomplete="off">

                <div class="lable">مسئول اجرا <span class="errors">*</span></div>
                <select name="implementation">
                    <option disabled>مسئول پیگیری را انتخاب نمایید</option>
                    <?php foreach ($userInfos as $user) :
                        $name = $user['id'];
                        $selectedUser = ($name == $plan->implementation) ? 'selected' : '';
                    ?>
                        <option value="<?= $name ?>" <?= $selectedUser ?>>
                            <?= $user['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <div class="lable">پیگیری توسط <span class="errors">*</span></div>
                <select name="track">
                    <option disabled>پیگیری را انتخاب نمایید</option>
                    <?php foreach ($sectionInfos as $section) :
                        $name = $section['id'];
                        $selectedUser = ($name == $plan->track) ? 'selected' : '';
                    ?>
                        <option value="<?= $name ?>" <?= $selectedUser ?>>
                            <?= $section['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="hidden" name="id" value="<?= $plan->id ?>">
                <input type="submit" value="ثبت" class="btn btn-color bb">
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