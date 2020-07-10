<div class="row">
    <div class="col-md-12">
        <div class="m-portlet m-portlet--tab">
            <div class="m-portlet__body">

                <div class="row">
                    <div class="col-md-6">
                        <h5 class="m-bottom-1">Preset Settings</h5>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group m-form__group required">
                            {{ Form::label('mormal-in-preset-message', 'Normal-in Preset Message', ['class' => '']) }}
                            {{
                                Form::select('normal_in_preset_message', $preset_message, !empty($dtr_time_setting_pm) ? $dtr_time_setting_pm['normal_in'] : '', ['class' => 'form-control form-control-lg m-input m-input--solid'])
                            }}
                            <span class="m-form__help m--font-danger">
                            </span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group m-form__group">
                            <div class="form-group m-form__group required">
                                {{ Form::label('mormal-out-preset-message', 'Normal-out Preset Message', ['class' => '']) }}
                                {{
                                    Form::select('normal_out_preset_message', $preset_message, !empty($dtr_time_setting_pm) ? $dtr_time_setting_pm['normal_out'] : '', ['class' => 'form-control form-control-lg m-input m-input--solid'])
                                }}
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group m-form__group">
                            <div class="form-group m-form__group required">
                                {{ Form::label('late-in-preset-message', 'Late-in Preset Message', ['class' => '']) }}
                                {{
                                    Form::select('late_in_preset_message', $preset_message, !empty($dtr_time_setting_pm) ? $dtr_time_setting_pm['late_in'] : '', ['class' => 'form-control form-control-lg m-input m-input--solid'])
                                }}
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group m-form__group">
                            <div class="form-group m-form__group required">
                                {{ Form::label('late-out-preset-message', 'Late-out Preset Message', ['class' => '']) }}
                                {{
                                    Form::select('late_out_preset_message', $preset_message, !empty($dtr_time_setting_pm) ? $dtr_time_setting_pm['late_out'] : '', ['class' => 'form-control form-control-lg m-input m-input--solid'])
                                }}
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group m-form__group">
                            <div class="form-group m-form__group required">
                                {{ Form::label('early-in-preset-message', 'Early-in Preset Message', ['class' => '']) }}
                                {{
                                    Form::select('early_in_preset_message', $preset_message, !empty($dtr_time_setting_pm) ? $dtr_time_setting_pm['early_in'] : '', ['class' => 'form-control form-control-lg m-input m-input--solid'])
                                }}
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group m-form__group">
                            <div class="form-group m-form__group required">
                                {{ Form::label('early-out-preset-message', 'Early-out Preset Message', ['class' => '']) }}
                                {{
                                    Form::select('early_out_preset_message', $preset_message, !empty($dtr_time_setting_pm) ? $dtr_time_setting_pm['early_out'] : '', ['class' => 'form-control form-control-lg m-input m-input--solid'])
                                }}
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('js/forms/preset.js') }}" type="text/javascript"></script>
@endpush