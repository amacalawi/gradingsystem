{{ Form::open(array('url' => 'notifications/messaging/emailblast/store', 'name' => 'emailblast_form', 'method' => 'POST')) }}
    <div class="row">
        <div class="col-md-8">
            <!-- MESSAGES START -->
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="m-bottom-1">Send Message</h5>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group m-form__group required">
                                {{ Form::label('l_sender', 'Sender', ['class' => '']) }}
                                {{
                                    Form::select('sender', $email, $value = '', ['class' => 'form-control form-control-lg m-input m-input--solid'])
                                }}
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group m-form__group required">
                                {{ Form::label('subject', 'Subject', ['class' => '']) }}
                                {{ 
                                    Form::text($name = 'subject', $value = '', 
                                    $attributes = array(
                                        'id' => 'subject',
                                        'class' => 'form-control form-control-lg m-input m-input--solid'
                                    )) 
                                }}
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group m-form__group">
                                {{ Form::label('attachment', 'Attachment', ['class' => '']) }}
                                <div class="col-md-12">
                                    <input type="file" name="attachments" id="attachments" multiple>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group m-form__group ">
                                <input type="checkbox" name="checkbox-autoattachment">
                                {{ Form::label('autoattachment', 'Auto Attachment', ['class' => '']) }}
                                <div class="col-md-12 radio-autoattachment">
                                    <label class="m-radio col-md-3">
                                        <input type="radio" name="radio_autoattachment" value="is_payslip" checked="checked">
                                        Payslip
                                        <span></span>
                                    </label>
                                    <label class="m-radio col-md-3">
                                        <input type="radio" name="radio_autoattachment" value="is_soa">
                                        SOA
                                        <span></span>
                                    </label>
                                    <label class="m-radio col-md-3">
                                        <input type="radio" name="radio_autoattachment" value="is_grade">
                                        Gradingsheet
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group m-form__group">
                                {{ Form::label('message', 'Message', ['class' => '']) }}
                                <textarea class="ckeditor form-control" name="message_editor" id="message_editor"></textarea>
                                {{-- 
                                    Form::textarea($name = 'messages', $value = '', 
                                    $attributes = array(
                                        'id' => 'messages',
                                        'class' => 'form-control form-control-lg m-input m-input--solid',
                                        'rows' => 3
                                    )) 
                                --}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary btn-sm">
                                Messaging Template
                            </button>
                            <button type="button" class="btn btn-secondary btn-sm">
                                SOA Template
                            </button>
                            <button type="button" class="btn btn-secondary btn-sm">
                                Gradingsheet Template
							</button>
                        </div>
                        <div class="col-md-5">
                            <div class="m-radio-inline text-right">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- MESSAGES END -->
        </div>
        <div class="col-md-4">
            <!-- SIDEBAR -->
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="nav nav-tabs  m-tabs-line" role="tablist">
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link active show" data-toggle="tab" href="#m_tabs_6_1" role="tab" aria-selected="true">
                                        Groups
                                    </a>
                                </li>
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_2" role="tab" aria-selected="false">
                                        Sections
                                    </a>
                                </li>
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_3" role="tab" aria-selected="false">
                                        Users
                                    </a>
                                </li>
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_4" role="tab" aria-selected="false">
                                        Anonymous
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active show" id="m_tabs_6_1" role="tabpanel">
                                    <div class="m-checkbox-list">
                                        @foreach ($groups as $group)
                                            <label class="m-checkbox m-checkbox--air">
                                                {{ Form::checkbox('group[]', $group->id, false, array()) }}
                                                {{ $group->name }}
                                                <span></span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="tab-pane" id="m_tabs_6_2" role="tabpanel">
                                    <div class="m-checkbox-list">
                                        @foreach ($sections as $section)
                                            <label class="m-checkbox m-checkbox--air">
                                                {{ Form::checkbox('section[]', $section->id, false, array()) }}
                                                {{ $section->name }}
                                                <span></span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="tab-pane" id="m_tabs_6_3" role="tabpanel">
                                    <div class="m-checkbox-list">
                                        @foreach ($users as $user)
                                            <label class="m-checkbox m-checkbox--air">
                                                {{ Form::checkbox('user[]', $user->id, false, array()) }}
                                                {{ $user->name }}
                                                <span></span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="tab-pane" id="m_tabs_6_4" role="tabpanel">
                                    <div class="form-group m-form__group">
                                        <div class="input-group">
                                            <input type="email" class="form-control" placeholder="Add email here...">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="button">
                                                    Add
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- SIDEBAR END -->
        </div>
    </div>
{{ Form::close() }}
