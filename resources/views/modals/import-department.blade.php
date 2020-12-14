<div class="modal fade" id="import-department" tabindex="-1" role="dialog" aria-labelledby="importDepartment">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-accent">
                <h5 class="modal-title full-width c-white" id="importDepartment">
                    Import Department
                    <a href="javascript:;" class="pull-right c-white" data-dismiss="modal">
                        <i class="la la-close"></i>
                    </a>
                </h5>
            </div>
            <div class="modal-body">
                <div class="progress m--margin-bottom-20">
                    <div class="progress-bar bg-accent" role="progressbar" data-dz-uploadprogress>
                        <span class="progress-text"></span>
                    </div>
                </div>
                <form method="POST" action="{{ url('/components/schools/departments/import') }}" class="dropzone dz-clickable" id="import-department-dropzone">
                    @csrf
                    <div class="dz-default dz-message"><span>Drop files here to upload</span></div>
                </form>
            </div>
        </div>
    </div>
</div>