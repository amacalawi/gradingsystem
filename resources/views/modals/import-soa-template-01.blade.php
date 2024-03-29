<div class="modal fade" id="import-soa-template-01" tabindex="-1" role="dialog" aria-labelledby="importSoaTemplate01">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-accent">
                <h5 class="modal-title full-width c-white" id="importSoaTemplate01">
                    Import SOA Template 01
                    <a href="javascript:;" class="pull-right c-white" data-dismiss="modal">
                        <i class="la la-close"></i>
                    </a>
                </h5>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ url('/components/csv-management/soa-template-01/import') }}" class="dropzone dz-clickable" id="import-soa-template-01-dropzone">
                    @csrf
                    <div class="dz-default dz-message"><span>Drop files here to upload</span></div>
                </form>
            </div>
        </div>
    </div>
</div>