<?php
$news = new News;
$news_result = $news->newsSelect_list();
?>

<div class="pagetitle">
    <h1>เพิ่มจดหมายข่าว</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index">หน้าหลัก</a></li>
            <li class="breadcrumb-item active">เพิ่มจดหมายข่าว</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-3 p-lg-5">
                    <form id="newsletterAdd">
                        <div class="mb-5">
                            <label for="newsletterTopic" class="form-label">ปีที่ | ฉบับที่ | เดือน | ปี พ.ศ.</label>
                            <input class="form-control" type="text" id="newsletterTopic" name="topic">
                        </div>
                        <div class="mb-5">
                            <label for="newsletterCheckTable" class="form-label">เลือกข่าว</label>
                            <div class="table-resposive" id="newsletterCheckTable">
                                <table class="table table-bordered table-hover datatable">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                เลือกข่าว
                                            </th>
                                            <th>หัวข้อข่าว</th>
                                            <th>วันที่เพิ่ม</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($news_result) {
                                            $i = 0 ?>
                                            <?php foreach ($news_result as $row) { ?>
                                                <tr>
                                                    <td style="width:90px; text-align: center;">
                                                        <input type="checkbox" name="newsletterCheckBox[]" value="<?= $row['news_unique']; ?>">
                                                    </td>
                                                    <td class="text-truncate"><?= substr(cleanData($row['news_topic']), 0, 50) . "..."; ?></td>
                                                    <td><?= DateThai($row['news_created']); ?></td>
                                                </tr>
                                            <?php } ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary rounded-pill float-end" name="newsletterValid" id="valid">ถัดไป <i class="bi bi-arrow-right"></i></button>
                </div>
            </div>
        </div>
</section>

<script>
    $('#valid').on('click', function(e) {
        e.preventDefault();

        // Retrieve the values of the inputs
        var topic = $('#newsletterAdd input[name="topic"]').val();

        // Retrieve the checked checkboxes
        var checkboxes = document.getElementsByName('newsletterCheckBox[]');

        // Array to store the selected checkbox values
        var selectedValues = [];

        // Loop through the checkboxes and check if they are checked
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                selectedValues.push(checkboxes[i].value); // Add the checked value to the array
            }
        }

        // Check if any input is empty
        if (!topic || selectedValues.length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                timer: 1500,
                showConfirmButton: true,
                focusConfirm: true
            });
            return; // Stop further execution
        }

        // Construct the URL with the parameters
        var url = "?page=newsletter-valid&topic=" + encodeURIComponent(topic) + "&selectedValues=" + encodeURIComponent(selectedValues.join(","));

        // Redirect to the URL
        window.location.href = url;
    });
</script>