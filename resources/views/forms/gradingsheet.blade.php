@inject('gradings', 'App\Http\Controllers\GradingSheetsController')
@if ( $segment == 'edit' )
    {{ Form::open(array('url' => 'academics/grading-sheets/all-gradingsheets/update/'.$grading->id, 'name' => 'gradingsheet_form', 'method' => 'PUT')) }}
@else
    {{ Form::open(array('url' => 'academics/grading-sheets/all-gradingsheets/store', 'name' => 'gradingsheet_form', 'method' => 'POST')) }}
@endif
    @if ($segment != 'edit')
        <div class="row">
            <div class="col-md-9">
                <!-- BASIC INFOS START -->
                <div class="m-portlet m-portlet--tab">
                    <div class="m-portlet__body">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="m-bottom-1">Grading Sheet Information</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 hidden">
                                {{ 
                                    Form::text($name = 'method', $value = ($segment == 'edit') ? 'edit' : 'add', 
                                    $attributes = array(
                                        'id' => 'method',
                                        'class' => 'form-control form-control-lg m-input m-input--solid'
                                    )) 
                                }}
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group m-form__group required">
                                    {{ Form::label('section_id', 'Section', ['class' => '']) }}
                                    {{  
                                        Form::select('section_id', $sections, !empty($grading) ? $grading->section_id : '', ['class' => 'form-control form-control-lg m-input m-input--solid'])
                                    }}
                                    <span class="m-form__help m--font-danger"></span>
                                </div>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group m-form__group required">
                                    {{ Form::label('subject_id', 'Subject', ['class' => '']) }}
                                    {{  
                                        Form::select('subject_id', $subjects, !empty($grading) ? $grading->subject_id : '', ['class' => 'form-control form-control-lg m-input m-input--solid'])
                                    }}
                                    <span class="m-form__help m--font-danger"></span>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
                <!-- BASIC INFOS END -->
            </div>
            <div class="col-md-3">
                <!-- Quarter TYPE -->
                <div class="m-portlet m-portlet--tab">
                    <div class="m-portlet__body">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="m-bottom-1">Quarter</h5>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group m-form__group required">
                                    {{ Form::label('quarter_id', 'Select Quarter', ['class' => '']) }}
                                    {{  
                                        Form::select('quarter_id', $quarters, !empty($grading) ? $grading->quarter_id : '', ['class' => 'form-control form-control-lg m-input m-input--solid'])
                                    }}
                                    <span class="m-form__help m--font-danger"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- QUARTER END -->
            </div>
        </div>
    @else
    <div class="row">
        <div class="col-md-12">
            <!-- BASIC INFOS START -->
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="scrolling_table_1" class="scrolly_table">
                                <table class="table-bordered">
                                    <tbody>
                                        <tr>
                                            <th class="shaded fixed freeze text-center scrolling_table_1">#</th>
                                            <th class="shaded fixed freeze text-center scrolling_table_1">STUDENT</th>
                                            <th class="shaded fixed freeze_vertical text-center scrolling_table_1" colspan="8">Written Task</th>
                                            <th class="shaded fixed freeze_vertical text-center scrolling_table_1" colspan="7">Performance Task</th>
                                            <th class="shaded fixed freeze_vertical text-center scrolling_table_1" colspan="3">Quarterly Assessment</th>
                                            <th class="shaded fixed freeze_vertical text-center scrolling_table_1">Initial</th>
                                            <th class="shaded fixed freeze_vertical text-center scrolling_table_1">QG</th>
                                            <th class="shaded fixed freeze_vertical text-center scrolling_table_1">TC</th>
                                        </tr>
                                        <tr>
                                            <th class="shaded fixed freeze text-center scrolling_table_1">1</th>
                                            <th class="shaded fixed freeze text-center scrolling_table_1">&nbsp;</th>
                                            <th class="shaded fixed freeze_vertical text-center scrolling_table_1">Q1</th>
                                            <th class="shaded fixed freeze_vertical text-center scrolling_table_1">Q2</th>
                                            <th class="shaded fixed freeze_vertical text-center scrolling_table_1">Q3</th>
                                            <th class="shaded fixed freeze_vertical text-center scrolling_table_1">Q4</th>
                                            <th class="shaded fixed freeze_vertical text-center scrolling_table_1">SUM</th>
                                            <th class="shaded fixed freeze_vertical text-center scrolling_table_1">HPS</th>
                                            <th class="shaded fixed freeze_vertical text-center scrolling_table_1">PS</th>
                                            <th class="shaded fixed freeze_vertical text-center scrolling_table_1">30%</th>
                                            <th class="shaded fixed freeze_vertical text-center scrolling_table_1">Q1</th>
                                            <th class="shaded fixed freeze_vertical text-center scrolling_table_1">Q2</th>
                                            <th class="shaded fixed freeze_vertical text-center scrolling_table_1">Q3</th>
                                            <th class="shaded fixed freeze_vertical text-center scrolling_table_1">Q4</th>
                                            <th class="shaded fixed freeze_vertical text-center scrolling_table_1">SUM</th>
                                            <th class="shaded fixed freeze_vertical text-center scrolling_table_1">PS</th>
                                            <th class="shaded fixed freeze_vertical text-center scrolling_table_1">20%</th>
                                            <th class="shaded fixed freeze_vertical text-center scrolling_table_1">Q1</th>
                                            <th class="shaded fixed freeze_vertical text-center scrolling_table_1">PS</th>
                                            <th class="shaded fixed freeze_vertical text-center scrolling_table_1">50%</th>
                                            <th class="shaded fixed freeze_vertical text-center scrolling_table_1">100%</th>
                                            <th class="shaded fixed freeze_vertical text-center scrolling_table_1">&nbsp;</th>
                                            <th class="shaded fixed freeze_vertical text-center scrolling_table_1">&nbsp;</th>
                                        </tr>
                                        <trr class="tr_shaded">
                                            <td class="shaded fixed freeze text-center scrolling_table_1">2</td>
                                            <td class="shaded fixed freeze text-center scrolling_table_1">&nbsp;</td>
                                            <td class="shaded fixed freeze_vertical text-center scrolling_table_1">35</td>
                                            <td class="shaded fixed freeze_vertical text-center scrolling_table_1">25</td>
                                            <td class="shaded fixed freeze_vertical text-center scrolling_table_1">40</td>
                                            <td class="shaded fixed freeze_vertical text-center scrolling_table_1">29</td>
                                            <td class="shaded fixed freeze_vertical text-center scrolling_table_1">120</td>
                                            <td class="shaded fixed freeze_vertical text-center scrolling_table_1">120</td>
                                            <td class="shaded fixed freeze_vertical text-center scrolling_table_1">90</td>
                                            <td class="shaded fixed freeze_vertical text-center scrolling_table_1">&nbsp;</td>
                                            <td class="shaded fixed freeze_vertical text-center scrolling_table_1">20</td>
                                            <td class="shaded fixed freeze_vertical text-center scrolling_table_1">20</td>
                                            <td class="shaded fixed freeze_vertical text-center scrolling_table_1">20</td>
                                            <td class="shaded fixed freeze_vertical text-center scrolling_table_1">20</td>
                                            <td class="shaded fixed freeze_vertical text-center scrolling_table_1">80</td>
                                            <td class="shaded fixed freeze_vertical text-center scrolling_table_1">60</td>
                                            <td class="shaded fixed freeze_vertical text-center scrolling_table_1">&nbsp;</td>
                                            <td class="shaded fixed freeze_vertical text-center scrolling_table_1">80</td>
                                            <td class="shaded fixed freeze_vertical text-center scrolling_table_1">60</td>
                                            <td class="shaded fixed freeze_vertical text-center scrolling_table_1">&nbsp;</td>
                                            <td class="shaded fixed freeze_vertical text-center scrolling_table_1">&nbsp;</td>
                                            <td class="shaded fixed freeze_vertical text-center scrolling_table_1">&nbsp;</td>
                                            <td class="shaded fixed freeze_vertical text-center scrolling_table_1">&nbsp;</td>
                                        </tr>
                                        <trr class="tr_shaded">
                                            <td class="fixed freeze text-center scrolling_table_1">3</td>
                                            <td class="fixed freeze text-center scrolling_table_1">Aliudin Amer Macalawi</td>
                                            <td class="fixed freeze_vertical text-center scrolling_table_1 no-padding"><input class="text-cell" type="text"/></td>
                                            <td class="fixed freeze_vertical text-center scrolling_table_1 no-padding"><input class="text-cell" type="text"/></td>
                                            <td class="fixed freeze_vertical text-center scrolling_table_1 no-padding"><input class="text-cell" type="text"/></td>
                                            <td class="fixed freeze_vertical text-center scrolling_table_1 no-padding"><input class="text-cell" type="text"/></td>
                                            <td class="fixed freeze_vertical text-center scrolling_table_1 no-padding"><input class="text-cell" type="text"/></td>
                                            <td class="fixed freeze_vertical text-center scrolling_table_1 no-padding"><input class="text-cell" type="text"/></td>
                                            <td class="fixed freeze_vertical text-center scrolling_table_1 no-padding"><input class="text-cell" type="text"/></td>
                                            <td class="fixed freeze_vertical text-center scrolling_table_1 no-padding"><input class="text-cell" type="text"/></td>
                                            <td class="fixed freeze_vertical text-center scrolling_table_1 no-padding"><input class="text-cell" type="text"/></td>
                                            <td class="fixed freeze_vertical text-center scrolling_table_1 no-padding"><input class="text-cell" type="text"/></td>
                                            <td class="fixed freeze_vertical text-center scrolling_table_1 no-padding"><input class="text-cell" type="text"/></td>
                                            <td class="fixed freeze_vertical text-center scrolling_table_1 no-padding"><input class="text-cell" type="text"/></td>
                                            <td class="fixed freeze_vertical text-center scrolling_table_1 no-padding"><input class="text-cell" type="text"/></td>
                                            <td class="fixed freeze_vertical text-center scrolling_table_1 no-padding"><input class="text-cell" type="text"/></td>
                                            <td class="fixed freeze_vertical text-center scrolling_table_1 no-padding"><input class="text-cell" type="text"/></td>
                                            <td class="fixed freeze_vertical text-center scrolling_table_1 no-padding"><input class="text-cell" type="text"/></td>
                                            <td class="fixed freeze_vertical text-center scrolling_table_1 no-padding"><input class="text-cell" type="text"/></td>
                                            <td class="fixed freeze_vertical text-center scrolling_table_1 no-padding"><input class="text-cell" type="text"/></td>
                                            <td class="fixed freeze_vertical text-center scrolling_table_1 no-padding"><input class="text-cell" type="text"/></td>
                                            <td class="fixed freeze_vertical text-center scrolling_table_1">&nbsp;</td>
                                            <td class="fixed freeze_vertical text-center scrolling_table_1">&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>                                          		
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
{{ Form::close() }}
