<!-- Add Category Modal -->
<div class="modal fade" id="addUsers" tabindex="-1" aria-labelledby="addUsersLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addUsersLabel">เพิ่มผู้ใช้งาน</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="private/app/controller/users.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" name="action" value="addUsers">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="usersFName" class="form-label">ชื่อจริง</label>
                        <input type="text" class="form-control" id="usersFname" name="usersFname">
                    </div>
                    <div class="mb-3">
                        <label for="usersLname" class="form-label">นามสกุล</label>
                        <input type="text" class="form-control" id="usersLname" name="usersLname">
                    </div>
                    <div class="mb-3">
                        <label for="usersEmail" class="form-label">อีเมลล์</label>
                        <input type="email" class="form-control emailValid" id="usersEmail" name="usersEmail" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="usersPassword" class="form-label">รหัสผ่าน</label>
                        <input type="password" class="form-control passwordValid" id="usersPassword" name="usersPassword" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <div class="form-floating">
                            <select class="form-select" id="usersRole" name="usersRole" aria-label="เลือกระดับผู้ใช้งาน">
                                <option value="" selected>กรุณาเลือกระดับผู้ใช้งาน</option>
                                <option value="แอดมิน">แอดมิน</option>
                                <option value="นักสื่อสารองค์กร">นักสื่อสารองค์กร</option>
                                <option value="ประชาสัมพันธ์">ประชาสัมพันธ์</option>
                                <option value="บรรณาธิการ">บรรณาธิการ</option>
                            </select>
                            <label for="usersRole">เลือกระดับ</label>
                        </div>
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
<div class="modal fade" id="editUsers" tabindex="-1" aria-labelledby="editUsersLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editUsersLabel">แก้ไขผู้ใช้งาน</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="private/app/controller/users.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" name="id" value="">
                <input type="hidden" name="oldPassword" value="">
                <div class="modal-body">
                    <div class="mb-3" id="usersApproveSelect">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="usersApprove" name="usersApprove">
                            <label class="form-check-label" for="usersApprove">ยืนยันการเข้าใช้งาน</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="usersFname" class="form-label">ชื่อจริง</label>
                        <input type="text" class="form-control" id="usersFname" name="usersFname">
                    </div>
                    <div class="mb-3">
                        <label for="usersLname" class="form-label">นามสกุล</label>
                        <input type="text" class="form-control" id="usersLname" name="usersLname">
                    </div>
                    <div class="mb-3">
                        <label for="usersEmail" class="form-label">อีเมลล์</label>
                        <input type="email" class="form-control" id="usersEmail" name="usersEmail" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="usersPassword" class="form-label">รหัสผ่าน</label>
                        <input type="password" class="form-control" id="usersPassword" name="usersPassword" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <div class="form-floating">
                            <select class="form-select" id="usersRoleSelect" name="usersRole" aria-label="แก้ไขระดับผู้ใช้งาน">
                                <option value="แอดมิน">แอดมิน</option>
                                <option value="นักสื่อสารองค์กร">นักสื่อสารองค์กร</option>
                                <option value="ประชาสัมพันธ์">ประชาสัมพันธ์</option>
                                <option value="บรรณาธิการ">บรรณาธิการ</option>
                                <option value="สมาชิก">สมาชิก</option>
                            </select>
                            <label for="usersRoleSelect">แก้ไขระดับผู้ใช้งาน</label>
                        </div>
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