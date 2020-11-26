<div class="modal fade" id="gradingsheet-components" tabindex="-1" role="dialog" aria-labelledby="gradingsheetComponents">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="gradingsheet-components-form" method="post" name="gradingsheet-components">
            @csrf
                <div class="modal-header bg-accent">
                    <h5 class="modal-title full-width c-white" id="gradingsheetComponents">
                        Gradingsheet Components (<span class="components-title variables"></span>)
                        <a href="javascript:;" class="pull-right c-white" data-dismiss="modal">
                            <i class="la la-close"></i>
                        </a>
                    </h5>
                    <h6 class="component_id variables hidden"></h6>
                    <h6 class="subject_id variables hidden"></h6>
                    <h6 class="section_info_id variables hidden"></h6>
                    <h6 class="quarter_id variables hidden"></h6>
                    <h6 class="batch_id variables hidden"></h6>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>
                    <button id="component-save-btn" type="button" class="btn btn-brand">
                        Save changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>