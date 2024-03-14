<?php
session_start();
if (!isset($_SESSION['user-admin'])) {
    header('location: ../index.php');
}
include_once 'sidebar.php';
?>

<!-- <script>
    $(document).ready(function() {
        $('.close-icon').hide();
        $('#search').keyup(function(e) {
            $('.close-icon').show();
            checkSearchInput();
            var search = $('#search').val();
            var resItems = $('.res').find('.search-item');

            function checkSearchInput() {
                var searchValue = $('#search').val().trim();
                if (searchValue === '') {
                    $('.result-search').removeClass('active');
                } else {
                    $('.result-search').addClass('active');
                }
            }

            var currentSelectedItem = $('.res').find('.selected');

            if (e.keyCode === 38) {
                if (currentSelectedItem.length) {
                    var prevItem = currentSelectedItem.removeClass('selected').prev('.search-item');
                    if (prevItem.length) {
                        prevItem.addClass('selected');
                    } else {
                        resItems.last().addClass('selected');
                    }
                } else {
                    resItems.last().addClass('selected');
                }
            } else if (e.keyCode === 40) {
                if (currentSelectedItem.length) {
                    var nextItem = currentSelectedItem.removeClass('selected').next('.search-item');
                    if (nextItem.length) {
                        nextItem.addClass('selected');
                    } else {
                        resItems.first().addClass('selected');
                    }
                } else {
                    resItems.first().addClass('selected');
                }
            } else if (e.keyCode === 13) {
                if (currentSelectedItem.length) {
                    var selectedItemText = currentSelectedItem.text();
                    var selectedItemId = currentSelectedItem.data('id');

                    $('#search').val(selectedItemText);
                    $('.res').html('');
                    var url = 'plan-details.php?id=';
                    window.location.href = url + selectedItemId;
                }
            } else {
                if (search != "") {
                    $.ajax({
                        url: 'back/live-search.php',
                        type: 'get',
                        data: {
                            'search': search
                        },
                        success: function(data) {
                            if (data.trim() === '') {
                                $('.res').html('<span class="search-item color no-result">موردی یافت نشد &#128148;&#128555;</span>');
                            } else {
                                $('.res').html(data);
                            }
                        }
                    });
                } else {
                    $('.res').html('');
                }
            }
        });
        $(document).on('click', '.search-item', function(e) {
            e.preventDefault();
            var selectedItemText = $(this).text();
            var selectedItemId = $(this).data('id');
            var url = 'plan-details.php?id=';

            $('#search').val(selectedItemText);
            $('.res').html('');
            window.location.href = url + selectedItemId;
        });

        $('.close-icon').click(function() {
            $('#search').val('');
            $('.result-search').removeClass('active');
            $('.close-icon').hide();
        });

    });
</script> -->

<!-- content -->
<div class="content">
    <div class="title">
        <div class="title-text">نمایش پلن ها</div>
    </div>
    <br>
    <!-- <div class="search-box">
        <div class="search-input">
            <span class="close-icon"><i class="fas fa-times color"></i></span>
            <input type="text" name="search" id="search" placeholder="جستجو پلن..." autocomplete="off">
            <ul class="result-search">
                <li class="res search-item color" role="option"></li>
            </ul>
        </div>
    </div> -->
    <div class="content-container">
        <table class="fl-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>هدف</th>
                    <th>فعالیت</th>
                    <th>مسئول اجرا</th>
                    <th>مسئول پیگیری</th>
                    <th>بودجه</th>
                    <th>زمان اجرا</th>
                    <th>ویرایش</th>
                    <th>جزئیات</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include_once '../connect.php';
                $limit = 10;
                $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                $start = ($currentPage - 1) * $limit;
                $sql = "SELECT * FROM plans ORDER BY id DESC LIMIT $start, $limit";
                $result = $connect->query($sql);
                $plans = $result->fetchAll(PDO::FETCH_ASSOC);
                $number = ($currentPage - 1) * $limit + 1;
                foreach ($plans as $plan) { ?>
                    <tr>
                        <td><?= $number ?></td>
                        <td><?= $plan['name'] ?></td>
                        <td><?= $plan['activity'] ?></td>
                        <td><?= $plan['implementation'] ?></td>
                        <td><?= $plan['track'] ?></td>
                        <td><?= $plan['budget'] ?></td>
                        <td><?= $plan['execution_time'] ?></td>
                        <td><a href="plan-edit.php?id=<?= $plan['id'] ?>"><i class="fas fa-edit"></i></a></td>
                        <td><a href="plan-details.php?id=<?= $plan['id'] ?>" class="success">نمایش</a></td>
                    </tr>
                <?php
                    $number++;
                }
                ?>
            </tbody>
        </table>

        <?php
        $sql = "SELECT COUNT(*) as total FROM plans";
        $result = $connect->query($sql);
        $data = $result->fetch(PDO::FETCH_ASSOC);
        $totalRecords = $data['total'];
        $totalPages = ceil($totalRecords / $limit);
        ?>
        <div class="tabel-info">
            <div class="countRow">
                تعداد کل: <?= $totalRecords ?>
            </div>
            <?php if ($totalPages > 1) : ?>
                <ul class="pagination">
                    <?php
                    $startPage = max(1, $currentPage - 3);
                    $endPage = min($totalPages, $startPage + 3);

                    if ($currentPage > 1) {
                        echo '<li><a href="?page=' . ($currentPage - 1) . '" class="paginate-item"><i class="fas fa-chevron-right"></i></a></li>';
                    }

                    if ($startPage > 1) {
                        echo '<li><a href="?page=1" class="paginate-item">1</a></li>';
                    }

                    for ($i = $startPage; $i <= $endPage; $i++) {
                        $active = ($i == $currentPage) ? 'active' : '';
                        echo '<li><a class="paginate-item ' . $active . '" href="?page=' . $i . '">' . $i . '</a></li>';
                    }

                    if ($endPage < $totalPages) {
                        echo '<li><a class="paginate-item" href="?page=' . $totalPages . '">' . $totalPages . '</a></li>';
                    }

                    if ($currentPage < $totalPages) {
                        echo '<li><a href="?page=' . ($currentPage + 1) . '" class="paginate-item"><i class="fas fa-chevron-left"></i></a></li>';
                    }
                    ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- end content -->

<?php
include_once 'footer.php';
?>