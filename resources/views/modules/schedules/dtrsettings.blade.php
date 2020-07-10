<div class="row">
    <div class="col-md-12">
        <div class="m-portlet m-portlet--tab">
            <div class="m-portlet__body">

                <div class="row">
                    <div class="col-md-6">
                        <h5 class="m-bottom-1">Daily-Time Settings</h5>
                    </div>
                    <div class="col-md-6">
                        <button type="button" title="clear time settings" id="clear_dtr" class="btn btn-sm btn-default pull-right mr-2"> Clear Time</button>
                        <button type="button" title="restore time settings" id="restore_dtr" class="btn btn-sm btn-success pull-right mr-2"> Default Time</button>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div id="" class="row flex-row flex-nowrap">
                            <table class="table text-center" style="white-space: nowrap; overflow: auto; display: inline;" id="dtr_table">
                                <tr>
                                    
                                    <td colspan=3> Day </td>
                                    <td colspan=2> Normal in <input type='text' name='code_in_out[]' value='normal_in' hidden> </td>
                                    <td colspan=2> Normal out <input type='text' name='code_in_out[]' value='normal_out' hidden> </td>
                                    <td colspan=2> Late in <input type='text' name='code_in_out[]' value='late_in' hidden> </td>
                                    <td colspan=2> Late out <input type='text' name='code_in_out[]' value='late_out' hidden> </td>
                                    <td colspan=2> Early in <input type='text' name='code_in_out[]' value='early_in' hidden> </td>
                                    <td colspan=2> Early out <input type='text' name='code_in_out[]' value='early_out' hidden> </td>
                                </tr>
                                <tr>
                                    <td colspan=3></td>
                                    <td> From </td>
                                    <td> To </td>
                                    <td> From </td>
                                    <td> To </td>
                                    <td> From </td>
                                    <td> To </td>
                                    <td> From </td>
                                    <td> To </td>
                                    <td> From </td>
                                    <td> To </td>
                                    <td> From </td>
                                    <td> To </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('js/forms/dtrsettings.js') }}" type="text/javascript"></script>
@endpush