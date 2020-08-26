@inject('annualfee', 'App\Http\Controllers\AppController')
<form type="POST" class="m-form m-form--label-align-left- m-form--state-" id="m_form" enctype="multipart/form-data">
    <!-- form 1 -->
    <div class="m-wizard__form-step m-wizard__form-step--current" id="m_wizard_form_step_1">
        <div class="row hidden">
            <div class="col-xl-12">
                <div class="form-group m-form__group">
                    {{ Form::label('exampleInputEmail1', 'Application ID', ['class' => '']) }}
                    {{ 
                        Form::text($name = 'app_id', $value = $application->app_id, 
                        $attributes = array(
                            'class' => 'form-control m-input m-input--solid',
                            'placeholder' => '*****',
                            'disabled' => 'disabled'
                        )) 
                    }}
                    <span class="m-form__help form-control-feedback"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-4">
                <div class="form-group m-form__group required">
                    {{ Form::label('exampleInputEmail1', 'Application No', ['class' => '']) }}
                    {{ 
                        Form::text($name = 'app_no', $value = $application->app_no, 
                        $attributes = array(
                            'class' => 'form-control m-input m-input--solid',
                            'placeholder' => 'Enter application no.'
                        )) 
                    }}
                    <span class="m-form__help form-control-feedback"></span>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="form-group m-form__group required">
                    {{ Form::label('app_filing_date', 'Filing Date', ['class' => '']) }}
                    {{ 
                        Form::text($name = 'app_filing_date', $value = $application->app_filing_date, 
                        $attributes = array(
                            'id' => 'app_filing_date',
                            'class' => 'form-control m-input m-input--solid date-picker',
                            'placeholder' => 'Enter filing date'
                        )) 
                    }}
                    <span class="m-form__help form-control-feedback"></span>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="form-group m-form__group required">
                    {{ Form::label('app_title', 'Title', ['class' => '']) }}
                    {{ 
                        Form::text($name = 'app_title', $value = $application->app_title, 
                        $attributes = array(
                            'class' => 'form-control m-input m-input--solid',
                            'placeholder' => 'Enter application title'
                        )) 
                    }}
                    <span class="m-form__help form-control-feedback"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-4">
                <div class="form-group m-form__group required">
                    {{ Form::label('app_applicants', 'Applicants', ['class' => '']) }}
                    {{ 
                        Form::select('app_applicants[]', $application->app_applicants, $application->app_applicants, 
                            [   
                                'id' => 'applicants',
                                'class' => 'form-control m-select2',
                                'multiple' => 'multiple'
                            ]
                        )

                    }}
                    <span class="m-form__help form-control-feedback"></span>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="form-group m-form__group required">
                    {{ Form::label('app_inventors', 'Inventors', ['class' => '']) }}
                    {{ 
                        Form::select('app_inventors[]', $application->app_inventors, $application->app_inventors, 
                            [   
                                'id' => 'inventors',
                                'class' => 'form-control m-select2',
                                'multiple' => 'multiple'
                            ]
                        )

                    }}
                    <span class="m-form__help form-control-feedback"></span>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="form-group m-form__group required">
                    {{ Form::label('app_contact', 'Contact No', ['class' => '']) }}
                    {{ 
                        Form::text($name = 'app_contact', $value = $application->app_contact, 
                        $attributes = array(
                            'class' => 'form-control m-input m-input--solid',
                            'placeholder' => 'Enter contact no'
                        )) 
                    }}
                    <span class="m-form__help form-control-feedback"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6">
                <div class="form-group m-form__group">
                    {{ Form::label('app_amount', 'Govenrment Fees', ['class' => '']) }}
                    {{ 
                        Form::text($name = 'app_amount', $value = $application->app_amount, 
                        $attributes = array(
                            'id' => 'app_amount',
                            'class' => 'form-control m-input m-input--solid numeric-double',
                            'placeholder' => 'Enter government fees'
                        )) 
                    }}
                    <span class="m-form__help form-control-feedback"></span>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="form-group m-form__group">
                    {{ Form::label('professional_fee1', 'Professional Fees', ['class' => '']) }}
                    {{ 
                        Form::text($name = 'professional_fee1', $value = $application->professional_fee1, 
                        $attributes = array(
                            'id' => 'professional_fee1',
                            'class' => 'form-control m-input m-input--solid numeric-double',
                            'placeholder' => 'Enter professional fees'
                        )) 
                    }}
                    <span class="m-form__help form-control-feedback"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="form-group m-form__group">
                    {{ Form::label('app_address', 'Address', ['class' => '']) }}
                    {{ 
                        Form::textarea($name = 'app_address', $value = $application->app_address, 
                        $attributes = array(
                            'id' => 'app_address',
                            'rows' => 3,
                            'class' => 'form-control m-input m-input--solid',
                            'placeholder' => ''
                        )) 
                    }}
                    <span class="m-form__help form-control-feedback"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="form-group m-form__group">
                    {{ Form::label('app_remarks', 'Remarks', ['class' => '']) }}
                    {{ 
                        Form::textarea($name = 'app_remarks', $value = $application->app_remarks, 
                        $attributes = array(
                            'id' => 'app_remarks',
                            'rows' => 3,
                            'class' => 'form-control m-input m-input--solid',
                            'placeholder' => ''
                        )) 
                    }}
                    <span class="m-form__help form-control-feedback"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="form-group m-form__group">
                    {{ Form::label('app_file', 'File Browser', ['class' => '']) }}
                    <div class="custom-file">
                        {{ Form::file('app_file', 
                            $attributes = 
                            [   
                                'id' => 'customFile',
                                'class' => 'custom-file-input' 
                            ]) 
                        }}
                        <label class="custom-file-label" for="customFile">
                            {{ $application->app_file_label }}                            
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- form 2 -->
    <div class="m-wizard__form-step" id="m_wizard_form_step_2">
        <div class="subsequent-form-1">
            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group m-form__group {{ ($application->fer_yes_no_yes == true) ? '' : 'required' }}">
                        {{ Form::label('sub_paper_no1', 'Paper No', ['class' => '']) }}
                        {{ 
                            Form::text($name = 'sub_paper_no1', $value = $application->sub_paper_no1, 
                            $attributes = array(
                                'id' => 'sub_paper_no1',
                                'class' => 'form-control m-input m-input--solid',
                                'placeholder' => 'Enter paper no'
                            )) 
                        }}
                        <span class="m-form__help form-control-feedback"></span>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group m-form__group {{ ($application->fer_yes_no_yes == true) ? '' : 'required' }}">
                        {{ Form::label('sub_mailing_date1', 'Mailing Date', ['class' => '']) }}
                        {{ 
                            Form::text($name = 'sub_mailing_date1', $value = $application->sub_mailing_date1, 
                            $attributes = array(
                                'id' => 'sub_mailing_date1',
                                'class' => 'form-control m-input m-input--solid date-picker',
                                'placeholder' => 'Enter mailing date'
                            )) 
                        }}
                        <span class="m-form__help form-control-feedback"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group m-form__group">
                        {{ Form::label('sub_amount_file1', 'Govenrment Fees', ['class' => '']) }}
                        @if($application->sub_mailing_date1 != '')
                        {{ 
                            Form::text($name = 'sub_amount_file1', $value = $application->sub_amount_file1, 
                            $attributes = array(
                                'id' => 'sub_amount_file1',
                                'class' => 'form-control m-input m-input--solid numeric-double',
                                'placeholder' => 'Enter government fees'
                            )) 
                        }}
                        @else
                        {{ 
                            Form::text($name = 'sub_amount_file1', $value = $application->sub_amount_file1, 
                            $attributes = array(
                                'id' => 'sub_amount_file1',
                                'class' => 'form-control m-input m-input--solid numeric-double',
                                'placeholder' => 'Enter government fees',
                                'disabled' => 'disabled'
                            )) 
                        }}
                        @endif
                        <span class="m-form__help form-control-feedback"></span>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group m-form__group">
                        {{ Form::label('professional_fee2_1', 'Professional Fees', ['class' => '']) }}
                        @if($application->sub_mailing_date1 != '')
                        {{ 
                            Form::text($name = 'professional_fee2_1', $value = $application->professional_fee2_1, 
                            $attributes = array(
                                'id' => 'professional_fee2_1',
                                'class' => 'form-control m-input m-input--solid numeric-double',
                                'placeholder' => 'Enter professional fees'
                            )) 
                        }}
                        @else
                        {{  
                            Form::text($name = 'professional_fee2_1', $value = $application->professional_fee2_1, 
                            $attributes = array(
                                'id' => 'professional_fee2_1',
                                'class' => 'form-control m-input m-input--solid numeric-double',
                                'placeholder' => 'Enter professional fees',
                                'disabled' => 'disabled'
                            )) 
                        }}
                        @endif
                        <span class="m-form__help form-control-feedback"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="form-group m-form__group">
                        {{ Form::label('sub_file1', 'File Browser', ['class' => '']) }}
                        <div class="custom-file">
                            {{ Form::file('sub_file1', 
                                $attributes = 
                                [   
                                    'id' => 'customFile',
                                    'class' => 'custom-file-input' 
                                ]) 
                            }}
                            <label class="custom-file-label" for="customFile">
                                {{ $application->sub_file1_label }}
                            </label>
                        </div>
                        <span class="m-form__help form-control-feedback"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="form-group m-form__group m--margin-top-10 m--margin-bottom-20">
                    <div class="alert m-alert m-alert--default" role="alert">
                        To enable subsequent formality examination report select
                        <code>
                            yes
                        </code>
                        othewise leave it no
                        <label class="m-radio m--margin-left-10 m-radio m-radio--info">
                            {{ Form::radio('fer_yes_no', 'Yes', $application->fer_yes_no_yes) }}
                            Yes
                            <span></span>
                        </label>
                        <label class="m-radio m-radio m-radio--info">
                            {{ Form::radio('fer_yes_no', 'No', $application->fer_yes_no_no) }}
                            No
                            <span></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="subsequent-form-2 {{ ($application->fer_yes_no_yes == true) ? '' : 'hidden' }}">
            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group m-form__group {{ ($application->fer_yes_no_yes == true) ? 'required' : '' }}">
                        {{ Form::label('sub_paper_no2', 'Paper No', ['class' => '']) }}
                        {{ 
                            Form::text($name = 'sub_paper_no2', $value = $application->sub_paper_no2, 
                            $attributes = array(
                                'id' => 'sub_paper_no2',
                                'class' => 'form-control m-input m-input--solid',
                                'placeholder' => 'Enter paper no'
                            )) 
                        }}
                        <span class="m-form__help form-control-feedback"></span>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group m-form__group {{ ($application->fer_yes_no_yes == true) ? 'required' : '' }}">
                        {{ Form::label('sub_mailing_date2', 'Mailing Date', ['class' => '']) }}
                        {{ 
                            Form::text($name = 'sub_mailing_date2', $value = $application->sub_mailing_date2, 
                            $attributes = array(
                                'id' => 'sub_mailing_date2',
                                'class' => 'form-control m-input m-input--solid date-picker',
                                'placeholder' => 'Enter mailing date'
                            )) 
                        }}
                        <span class="m-form__help form-control-feedback"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group m-form__group">
                        {{ Form::label('sub_amount_file2', 'Govenrment Fees', ['class' => '']) }}
                        @if($application->sub_mailing_date2 != '')
                        {{ 
                            Form::text($name = 'sub_amount_file2', $value = $application->sub_amount_file2, 
                            $attributes = array(
                                'id' => 'sub_amount_file2',
                                'class' => 'form-control m-input m-input--solid numeric-double',
                                'placeholder' => 'Enter government fees'
                            )) 
                        }}
                        @else
                        {{ 
                            Form::text($name = 'sub_amount_file2', $value = $application->sub_amount_file2, 
                            $attributes = array(
                                'id' => 'sub_amount_file2',
                                'class' => 'form-control m-input m-input--solid numeric-double',
                                'placeholder' => 'Enter government fees',
                                'disabled' => 'disabled'
                            )) 
                        }}
                        @endif
                        <span class="m-form__help form-control-feedback"></span>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group m-form__group">
                        {{ Form::label('professional_fee2_2', 'Professional Fees', ['class' => '']) }}
                        @if($application->sub_mailing_date2 != '')
                        {{ 
                            Form::text($name = 'professional_fee2_2', $value = $application->professional_fee2_2, 
                            $attributes = array(
                                'id' => 'professional_fee2_2',
                                'class' => 'form-control m-input m-input--solid numeric-double',
                                'placeholder' => 'Enter professional fees'
                            )) 
                        }}
                        @else
                        {{  
                            Form::text($name = 'professional_fee2_2', $value = $application->professional_fee2_2, 
                            $attributes = array(
                                'id' => 'professional_fee2_2',
                                'class' => 'form-control m-input m-input--solid numeric-double',
                                'placeholder' => 'Enter professional fees',
                                'disabled' => 'disabled'
                            )) 
                        }}
                        @endif
                        <span class="m-form__help form-control-feedback"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="form-group m-form__group">
                        {{ Form::label('sub_file2', 'File Browser', ['class' => '']) }}
                        <div class="custom-file">
                            {{ Form::file('sub_file2', 
                                $attributes = 
                                [   
                                    'id' => 'customFile',
                                    'class' => 'custom-file-input' 
                                ]) 
                            }}
                            <label class="custom-file-label" for="customFile">
                                {{ $application->sub_file2_label }}
                            </label>
                        </div>
                        <span class="m-form__help form-control-feedback"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- form 3 -->
    <div class="m-wizard__form-step" id="m_wizard_form_step_3">
        <div class="row">
            <div class="col-xl-4">
                <div class="form-group m-form__group required">
                    {{ Form::label('pub_date', 'Publication Date', ['class' => '']) }}
                    {{ 
                        Form::text($name = 'pub_date', $value = $application->pub_date, 
                        $attributes = array(
                            'id' => 'pub_date',
                            'class' => 'form-control m-input m-input--solid date-picker',
                            'placeholder' => 'Enter publication date'
                        )) 
                    }}
                    <span class="m-form__help form-control-feedback"></span>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="form-group m-form__group">
                    {{ Form::label('pub_amount', 'Govenrment Fees', ['class' => '']) }}
                    {{ 
                        Form::text($name = 'pub_amount', $value = $application->pub_amount, 
                        $attributes = array(
                            'id' => 'pub_amount',
                            'class' => 'form-control m-input m-input--solid numeric-double',
                            'placeholder' => 'Enter government fees'
                        )) 
                    }}
                    <span class="m-form__help form-control-feedback"></span>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="form-group m-form__group">
                    {{ Form::label('professional_fee3', 'Professional Fees', ['class' => '']) }}
                    {{ 
                        Form::text($name = 'professional_fee3', $value = $application->professional_fee3, 
                        $attributes = array(
                            'id' => 'professional_fee3',
                            'class' => 'form-control m-input m-input--solid numeric-double',
                            'placeholder' => 'Enter professional fees'
                        )) 
                    }}
                    <span class="m-form__help form-control-feedback"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="form-group m-form__group">
                    {{ Form::label('pub_file', 'File Browser', ['class' => '']) }}
                    <div class="custom-file">
                        {{ Form::file('pub_file', 
                            $attributes = 
                            [   
                                'id' => 'customFile',
                                'class' => 'custom-file-input' 
                            ]) 
                        }}
                        <label class="custom-file-label" for="customFile">
                            {{ $application->pub_file_label }}
                        </label>
                    </div>
                    <span class="m-form__help form-control-feedback"></span>
                </div>
            </div>
        </div>
    </div>

    <!-- form 4 -->
    <div class="m-wizard__form-step" id="m_wizard_form_step_4">
        <div class="subsequent-form-4-1">
            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group m-form__group required">
                        {{ Form::label('subs_paper_no1', 'Paper No', ['class' => '']) }}
                        {{ 
                            Form::text($name = 'subs_paper_no1', $value = $application->subs_paper_no1, 
                            $attributes = array(
                                'id' => 'subs_paper_no1',
                                'class' => 'form-control m-input m-input--solid',
                                'placeholder' => 'Enter paper no'
                            )) 
                        }}
                        <span class="m-form__help form-control-feedback"></span>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group m-form__group required">
                        {{ Form::label('subs_mailing_date1', 'Mailing Date', ['class' => '']) }}
                        {{ 
                            Form::text($name = 'subs_mailing_date1', $value = $application->subs_mailing_date1, 
                            $attributes = array(
                                'id' => 'subs_mailing_date1',
                                'class' => 'form-control m-input m-input--solid date-picker',
                                'placeholder' => 'Enter mailing date'
                            )) 
                        }}
                        <span class="m-form__help form-control-feedback"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group m-form__group">
                        {{ Form::label('subs_amount_file1', 'Govenrment Fees', ['class' => '']) }}
                        {{ 
                            Form::text($name = 'subs_amount_file1', $value = $application->subs_amount_file1, 
                            $attributes = array(
                                'id' => 'subs_amount_file1',
                                'class' => 'form-control m-input m-input--solid numeric-double',
                                'placeholder' => 'Enter government fees'
                            )) 
                        }}
                        <span class="m-form__help form-control-feedback"></span>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group m-form__group">
                        {{ Form::label('professional_fee4_1', 'Professional Fees', ['class' => '']) }}
                        {{ 
                            Form::text($name = 'professional_fee4_1', $value = $application->professional_fee4_1, 
                            $attributes = array(
                                'id' => 'professional_fee4_1',
                                'class' => 'form-control m-input m-input--solid numeric-double',
                                'placeholder' => 'Enter professional fees'
                            )) 
                        }}
                        <span class="m-form__help form-control-feedback"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="form-group m-form__group">
                        {{ Form::label('subs_file1', 'File Browser', ['class' => '']) }}
                        <div class="custom-file">
                            {{ Form::file('subs_file1', 
                                $attributes = 
                                [   
                                    'id' => 'customFile',
                                    'class' => 'custom-file-input' 
                                ]) 
                            }}
                            <label class="custom-file-label" for="customFile">
                                {{ $application->subs_file1_label }}
                            </label>
                        </div>
                        <span class="m-form__help form-control-feedback"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="form-group m-form__group m--margin-top-10 m--margin-bottom-20">
                        <div class="alert m-alert m-alert--default" role="alert">
                            To enable subsequent formality examination report select
                            <code>
                                yes
                            </code>
                            othewise leave it no
                            <label class="m-radio m--margin-left-10 m-radio m-radio--info">
                                <input type="radio" name="subsequent_checklist_form_4" value="Yes">
                                Yes
                                <span></span>
                            </label>
                            <label class="m-radio m-radio m-radio--info">
                                <input type="radio" name="subsequent_checklist_form_4" value="No" checked="checked">
                                No
                                <span></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="subsequent-form-4-2 hidden">
            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group m-form__group">
                        {{ Form::label('subs_paper_no2', 'Paper No', ['class' => '']) }}
                        {{ 
                            Form::text($name = 'subs_paper_no2', $value = $application->subs_paper_no2, 
                            $attributes = array(
                                'id' => 'subs_paper_no2',
                                'class' => 'form-control m-input m-input--solid',
                                'placeholder' => 'Enter paper no',
                                'disabled' => 'disabled'
                            )) 
                        }}
                        <span class="m-form__help form-control-feedback"></span>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group m-form__group">
                        {{ Form::label('subs_mailing_date2', 'Mailing Date', ['class' => '']) }}
                        {{ 
                            Form::text($name = 'subs_mailing_date2', $value = $application->subs_mailing_date2, 
                            $attributes = array(
                                'id' => 'subs_mailing_date2',
                                'class' => 'form-control m-input m-input--solid date-picker',
                                'placeholder' => 'Enter mailing date',
                                'disabled' => 'disabled'
                            )) 
                        }}
                        <span class="m-form__help form-control-feedback"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group m-form__group">
                        {{ Form::label('subs_amount_file2', 'Govenrment Fees', ['class' => '']) }}
                        {{ 
                            Form::text($name = 'subs_amount_file2', $value = $application->subs_amount_file2, 
                            $attributes = array(
                                'id' => 'subs_amount_file2',
                                'class' => 'form-control m-input m-input--solid numeric-double',
                                'placeholder' => 'Enter government fees',
                                'disabled' => 'disabled'
                            )) 
                        }}
                        <span class="m-form__help form-control-feedback"></span>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group m-form__group">
                        {{ Form::label('professional_fee4_2', 'Professional Fees', ['class' => '']) }}
                        {{ 
                            Form::text($name = 'professional_fee4_2', $value = $application->professional_fee4_2, 
                            $attributes = array(
                                'id' => 'professional_fee4_2',
                                'class' => 'form-control m-input m-input--solid numeric-double',
                                'placeholder' => 'Enter professional fees'
                            )) 
                        }}
                        <span class="m-form__help form-control-feedback"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="form-group m-form__group">
                        {{ Form::label('subs_file2', 'File Browser', ['class' => '']) }}
                        <div class="custom-file">
                            {{ Form::file('subs_file2', 
                                $attributes = 
                                [   
                                    'id' => 'customFile',
                                    'class' => 'custom-file-input' 
                                ]) 
                            }}
                            <label class="custom-file-label" for="customFile">
                                {{ $application->subs_file2_label }}
                            </label>
                        </div>
                        <span class="m-form__help form-control-feedback"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- form 5 -->
    <div class="m-wizard__form-step" id="m_wizard_form_step_5">
        <div class="row">
            <div class="col-xl-4">
                <div class="form-group m-form__group required">
                    {{ Form::label('issuance_date', 'Issuance Date', ['class' => '']) }}
                    {{ 
                        Form::text($name = 'issuance_date', $value = $application->issuance_date, 
                        $attributes = array(
                            'id' => 'issuance_date',
                            'class' => 'form-control m-input m-input--solid date-picker',
                            'placeholder' => 'Enter issuance date'
                        )) 
                    }}
                    <span class="m-form__help form-control-feedback"></span>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="form-group m-form__group">
                    {{ Form::label('allow_amount_file', 'Govenrment Fees', ['class' => '']) }}
                    {{ 
                        Form::text($name = 'allow_amount_file', $value = $application->allow_amount_file, 
                        $attributes = array(
                            'id' => 'allow_amount_file',
                            'class' => 'form-control m-input m-input--solid numeric-double',
                            'placeholder' => 'Enter government fees'
                        )) 
                    }}
                    <span class="m-form__help form-control-feedback"></span>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="form-group m-form__group">
                    {{ Form::label('professional_fee5', 'Professional Fees', ['class' => '']) }}
                    {{ 
                        Form::text($name = 'professional_fee5', $value = $application->professional_fee5, 
                        $attributes = array(
                            'id' => 'professional_fee5',
                            'class' => 'form-control m-input m-input--solid numeric-double',
                            'placeholder' => 'Enter professional fees'
                        )) 
                    }}
                    <span class="m-form__help form-control-feedback"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="form-group m-form__group">
                    {{ Form::label('allow_remarks', 'Remarks', ['class' => '']) }}
                    {{ 
                        Form::textarea($name = 'allow_remarks', $value = $application->allow_remarks, 
                        $attributes = array(
                            'id' => 'allow_remarks',
                            'class' => 'form-control m-input m-input--solid date-picker',
                            'placeholder' => '',
                            'rows' => 3
                        )) 
                    }}
                    <span class="m-form__help form-control-feedback"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="form-group m-form__group">
                    {{ Form::label('allow_file', 'File Browser', ['class' => '']) }}
                    <div class="custom-file">
                        {{ Form::file('allow_file', 
                            $attributes = 
                            [   
                                'id' => 'customFile',
                                'class' => 'custom-file-input' 
                            ]) 
                        }}
                        <label class="custom-file-label" for="customFile">
                            {{ $application->allow_file_label }}
                        </label>
                    </div>
                    <span class="m-form__help form-control-feedback"></span>
                </div>
            </div>
        </div>
        <div id="annual_fees_layer" class="row">
            <div class="col-xl-12">
                <h5 class="text-center m--margin-top-5"><strong>*** ANNUAL FEES ***</strong></h5>
            </div>
            <div class="col-xl-12">
                <div class="table-reponsive">
                    <table id="annuity_table" class="table">
                        <thead>
                            <th class="text-center"><strong>Annuity</strong></th>
                            <th class="text-center"><strong>Due Date</strong></th>
                            <th class="text-center"><strong>Annuity Fee</strong></th>
                            <th class="text-center"><strong>is Paid?</strong></th>
                        </thead>
                        <tbody>
                            @php
                            $i = 5;
                            @endphp
                            @while ( $i <= 20 )
                                <tr data-row-id="{{$i}}">
                                    <td class="text-center">
                                        <label class="m--margin-top-7">{{ $i }}th Year</label>
                                    </td> 
                                    <td class="hidden"><input name="annuity_identification[]" value="{{$i}}"/></td>
                                    <td class="hidden">
                                        @if($application->app_id != '' && $application->pub_date != '')
                                            <input id="annuity_due_date_{{$i}}" name="annuity_due_date_{{$i}}" value="{{ $annualfee->fetchAnnualFee($i, $application->app_id, $application->pub_date, 'due_dates') }}"/>
                                        @else
                                            <input id="annuity_due_date_{{$i}}" name="annuity_due_date_{{$i}}" value=""/>
                                        @endif
                                    </td>
                                    <td>
                                        @if($application->app_id != '' && $application->pub_date != '')
                                        {{ 
                                            Form::text($name = 'annuity_due_date_clone[]', $value = $annualfee->fetchAnnualFee($i, $application->app_id, $application->pub_date, 'due_date'), 
                                            $attributes = array(
                                                'id' => 'annuity_due_date_clone_'.$i,
                                                'class' => 'text-center form-control m-input m-input--solid date-picker',
                                                'placeholder' => '',
                                                'disabled' => 'disabled'
                                            )) 
                                        }}
                                        @else
                                        {{ 
                                            Form::text($name = 'annuity_due_date_clone[]', $value = '', 
                                            $attributes = array(
                                                'id' => 'annuity_due_date_clone_'.$i,
                                                'class' => 'text-center form-control m-input m-input--solid date-picker',
                                                'placeholder' => '',
                                                'disabled' => 'disabled'
                                            )) 
                                        }}
                                        @endif
                                    </td> 
                                    <td>
                                        @if($application->app_id != '' && $application->pub_date != '')
                                        {{ 
                                            Form::text($name = 'annuity_fee_'.$i, $value = $value = $annualfee->fetchAnnualFee($i, $application->app_id, $application->pub_date, 'due_date_fee'), 
                                            $attributes = array(
                                                'id' => 'annuity_fee_'.$i,
                                                'class' => 'text-center form-control m-input m-input--solid numeric-double',
                                                'placeholder' => ''
                                            )) 
                                        }}
                                        @else
                                        {{ 
                                            Form::text($name = 'annuity_fee_'.$i, $value = $application->annuity_fee, 
                                            $attributes = array(
                                                'id' => 'annuity_fee_'.$i,
                                                'class' => 'text-center form-control m-input m-input--solid numeric-double',
                                                'placeholder' => ''
                                            )) 
                                        }}
                                        @endif
                                    </td> 
                                    <td class="text-center">
                                        @if($application->app_id != '')
                                            @php 
                                                $paid = $annualfee->fetchAnnualFee($i, $application->app_id, $application->pub_date, 'due_date_is_paid');
                                            @endphp
                                        @endif
                                        <label class="m--margin-top-7 m-radio m-radio m-radio--info">
                                            @if($application->app_id != '')
                                                @if($paid == 1)
                                                    <input type="radio" name="annuity_paid_{{$i}}" value="1" checked="checked">
                                                @else
                                                    <input type="radio" name="annuity_paid_{{$i}}" value="1">
                                                @endif
                                            @else
                                                <input type="radio" name="annuity_paid_{{$i}}" value="1">
                                            @endif
                                            Yes
                                            <span></span>
                                        </label>
                                        <label class="m--margin-top-7 m-radio m-radio m-radio--info m--margin-left-10">
                                            @if($application->app_id != '')
                                                @if($paid == 0)
                                                    <input type="radio" name="annuity_paid_{{$i}}" value="0" checked="checked">
                                                @else
                                                    <input type="radio" name="annuity_paid_{{$i}}" value="0">
                                                @endif
                                            @else
                                                <input type="radio" name="annuity_paid_{{$i}}" value="0" checked="checked">
                                            @endif
                                            No
                                            <span></span>
                                        </label>
                                    </td> 
                                </tr>
                            @php
                            $i++;
                            @endphp
                            @endwhile
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="form-group m-form__group m--margin-top-10 m--margin-bottom-20">
                    <div class="alert m-alert m-alert--default" role="alert">
                        Note that if selected to 
                        <code>
                            yes
                        </code>
                        the patent application will serve as completed and cannot be modify othewise leave it no
                        <label class="m-radio m-radio m-radio--info">
                            <input type="radio" name="completed" value="Yes">
                            Yes
                            <span></span>
                        </label>
                        <label class="m-radio m-radio m-radio--info">
                            <input type="radio" name="completed" value="No" checked="checked">
                            No
                            <span></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
