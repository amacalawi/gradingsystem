<div class="modal fade" id="import-payslip" tabindex="-1" role="dialog" aria-labelledby="importPayslipUpload">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-accent">
                <h5 class="modal-title full-width c-white" id="importPayslipUpload">
                    Import Payslip File
                    <a href="javascript:;" class="pull-right c-white" data-dismiss="modal">
                        <i class="la la-close"></i>
                    </a>
                </h5>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ url('/components/file-management/payslip/import') }}" class="dropzone dz-clickable" id="import-payslip-dropzone">
                    @csrf
                    <div class="dz-default dz-message"><span>Drop files here to upload</span></div>
                </form>
            </div>
        </div>
    </div>
</div>