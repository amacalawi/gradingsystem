{{ Form::open(array('url' => 'notifictions/messaging/infoblast/store', 'name' => 'infoblast_form', 'method' => 'POST')) }}
    <div class="row">
        <div class="col-md-9">
            <!-- BASIC INFOS START -->
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="m-bottom-1">Basic Information</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 hidden">
                        </div>
                    </div>
                </div>
            </div>
            <!-- BASIC INFOS END -->
        </div>
        <div class="col-md-3">
            <!-- AVATAR START -->
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
                                        Individuals
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active show" id="m_tabs_6_1" role="tabpanel">
                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                                </div>
                                <div class="tab-pane" id="m_tabs_6_2" role="tabpanel">
                                    It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                                </div>
                                <div class="tab-pane" id="m_tabs_6_3" role="tabpanel">
                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- AVATAR END -->
        </div>
    </div>
{{ Form::close() }}
