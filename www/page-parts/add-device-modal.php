<div class="modal fade" tabindex="-1" aria-hidden="true" id="addDeviceModal">
    <div class="modal-dialog  modal-dialog-centered">
        <form action="newdevice.php" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Device</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="#nameInput" class="form-label">Name:</label>
                        <input type="text" name="name" required class="form-control" id="nameInput">
                    </div>
                    <div class="mb-3">
                        <label for="#snInput" class="form-label">Serial Number:</label>
                        <input type="text" name="sn" required class="form-control" id="snInput">
                    </div>
                    <div class="mb-3">
                        <label for="#categoryInput" class="form-label">Category:</label>
                        <input type="text" name="category" required class="form-control" id="categoryInput">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Device</button>
                </div>
            </div>
        </form>
    </div>
</div>