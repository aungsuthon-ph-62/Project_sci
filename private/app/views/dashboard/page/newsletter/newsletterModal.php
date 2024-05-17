<!-- Add Newsletter Modal -->
<div class="modal fade" id="addNewsletter" tabindex="-1" aria-labelledby="addNewsletterLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addNewsletterLabel">เพิ่มจดหมายข่าว</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="private/app/controller/newsletter.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" name="action" value="addNewsletter">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="newsletterTopic" class="form-label">หัวข้อ</label>
                        <input type="text" class="form-control" id="newsletterTopic" name="newsletterTopic">
                    </div>
                    <div class="mb-3">
                        <label for="newsletterFile" class="form-label">แนบไฟล์จดหมายข่าว</label>
                        <input class="form-control" type="file" id="newsletterFile" name="newsletterFile" accept='.pdf, .doc, .docx, .ppt, .pptx'>
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

<!-- Edit Newsletter Modal -->
<div class="modal fade" id="editNewsletter" tabindex="-1" aria-labelledby="editNewsletterLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editNewsletterLabel">แก้ไขจดหมายข่าว</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="private/app/controller/newsletter.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" name="action" value="editNewsletter">
                <input type="hidden" name="id">
                <input type="hidden" name="oldNewsletter">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="newsletterTopic" class="form-label">หัวข้อ</label>
                        <input type="text" class="form-control" id="newsletterTopic" name="newsletterTopic">
                    </div>
                    <div class="mb-3">
                        <label for="newsletterFile" class="form-label">แนบไฟล์จดหมายข่าว</label>
                        <input class="form-control" type="file" id="newsletterFile" name="newsletterFile" accept='.pdf, .doc, .docx, .ppt, .pptx'>
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