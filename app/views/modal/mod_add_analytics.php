<div class="modal fade" tabindex="-1" id="mod_add_analytics">
    <div class="modal-dialog">
        <div class="modal-content">

    <div class="modal-header">  
        <h5 class="modal-title"><i class="bi bi-pencil-square pe-2"></i>
            Add new project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

    <div class="modal-body">

            <div class="mb-3">
              <label for="url" class="form-label">Url your project</label>
                <input type="text" class="form-control" id="url" placeholder="https://example.com">
                    </div>

            <div>
              <label for="comment" class="form-label">Сomment</label>
                <textarea class="form-control" id="comment" rows="3" placeholder="If you have any questions ..."></textarea>
                    </div>  
    </div>

            <div class="text-center mt-2 mb-4">
                <button type="button"
                        class="btn btn-outline-primary rounded-5 1col-10 py-2 px-5 1mb-3"
                        data-bs-toggle="modal"
                        data-bs-target="#mod_add_analytics"
                        onclick="addReq()">
                    <i class="bi bi-send pe-2"></i>Submit
                </button>
            </div>
        
        </div>
    </div> 
</div>