<!-- Add Category Modal -->
<div class="modal fade" id="addBanner" tabindex="-1" aria-labelledby="addBannerLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addBannerLabel">เพิ่มแบนเนอร์</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="private/app/controller/banner.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" name="action" value="addBanner">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="bannerImg" class="form-label">แนบไฟล์รูปภาพ</label>
                        <input class="form-control" type="file" id="bannerImg" name="bannerImg" accept='image/gif, image/jpeg, image/png, image/jpg, image/webp, image/svg'>
                    </div>
                    <div class="mb-3">
                        <label for="bannerTopic" class="form-label">หัวข้อ</label>
                        <input type="text" class="form-control" id="bannerTopic" name="bannerTopic">
                    </div>
                    <div class="mb-3">
                        <label for="bannerDesc" class="form-label">คำอธิบาย</label>
                        <input type="text" class="form-control" id="bannerDesc" name="bannerDesc">
                    </div>
                    <div class="mb-3">
                        <label for="bannerLink" class="form-label">ลิงก์</label>
                        <input type="text" class="form-control" id="bannerLink" name="bannerLink">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editBanner" tabindex="-1" aria-labelledby="editBannerLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editBannerLabel">แก้ไขแบนเนอร์</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="private/app/controller/banner.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" name="action" value="editBanner">
                <input type="hidden" name="id">
                <input type="hidden" name="oldBanner">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="bannerImg" class="form-label">แนบไฟล์รูปภาพ</label>
                        <input class="form-control" type="file" id="bannerImg" name="bannerImg" accept='image/gif, image/jpeg, image/png, image/jpg, image/webp, image/svg'>
                    </div>
                    <div class="mb-3">
                        <label for="bannerTopic" class="form-label">หัวข้อ</label>
                        <input type="text" class="form-control" id="bannerTopic" name="bannerTopic">
                    </div>
                    <div class="mb-3">
                        <label for="bannerDesc" class="form-label">คำอธิบาย</label>
                        <input type="text" class="form-control" id="bannerDesc" name="bannerDesc">
                    </div>
                    <div class="mb-3">
                        <label for="bannerLink" class="form-label">ลิงก์</label>
                        <input type="text" class="form-control" id="bannerLink" name="bannerLink">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                </div>
            </form>
        </div>
    </div>
</div>