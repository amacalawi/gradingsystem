{{ Form::open(array('url' => 'notifications/messaging/infoblast/send', 'name' => 'infoblast_form', 'method' => 'POST')) }}
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
                            <div class="form-group m-form__group">
                                {{ 
                                    Form::textarea($name = 'messages', $value = '', 
                                    $attributes = array(
                                        'id' => 'messages',
                                        'class' => 'form-control form-control-lg m-input m-input--solid',
                                        'rows' => 3,
                                        'maxlength' => 500
                                    )) 
                                }}
                                <span class="m-form__help m--font-metal">
                                    500
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <button type="button" class="btn btn-secondary btn-sm">
                                Insert Template
                            </button>
                        </div>
                        <div class="col-md-8">
                            <div class="m-radio-inline text-right">
                                <label class="m-radio">
                                    <input type="radio" name="message_type_id" value="1" checked="checked">
                                    Messaging
                                    <span></span>
                                </label>
                                <label class="m-radio">
                                    <input type="radio" name="message_type_id" value="2">
                                    SOA
                                    <span></span>
                                </label>
                                <label class="m-radio">
                                    <input type="radio" name="message_type_id" value="3">
                                    Gradingsheet
                                    <span></span>
                                </label>
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
                                            <input type="text" name="anonymous" class="form-control" placeholder="Add mobile number here...">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="button">
                                                    Add
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-checkbox-list">
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
