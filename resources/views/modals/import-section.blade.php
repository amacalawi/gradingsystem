<div class="modal fade" id="import-section" tabindex="-1" role="dialog" aria-labelledby="importSection">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-accent">
                <h5 class="modal-title full-width c-white" id="importSection">
                    Import Section
                    <a href="javascript:;" class="pull-right c-white" data-dismiss="modal">
                        <i class="la la-close"></i>
                    </a>
                </h5>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ url('/academics/academics/sections/import') }}" class="dropzone dz-clickable" id="import-section-dropzone">
                    @csrf
                    <div class="dz-default dz-message"><span>Drop files here to upload</span></div>
                </form>
            </div>
        </div>
    </div>
</div>