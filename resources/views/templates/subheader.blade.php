@if (\Request::is('*/*') && Request::segment(3) == '')  
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    {{ ucwords(Request::segment(2)) }}
                </h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{ url('/dashboard') }}" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="javascript:;" class="m-nav__link">
                            <span class="m-nav__link-text">
                                Manage Active {{ ucwords(str_replace('-',' ', Request::segment(2))) }}
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
            <div>
                @php 
                    $imports = ['students', 'staffs'];
                @endphp
                @if (in_array(Request::segment(2), $imports))
                <a href="javascript:;" class="btn m-btn--pill btn-accent add-btn m-btn--custom" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#import-{{ substr(strtolower(str_replace('-',' ', Request::segment(2))), 0, -1) }}">
                    <i class="la la-upload"></i> 
                        Import {{ substr(ucwords(str_replace('-',' ', Request::segment(2))), 0, -1) }}
                </a>
                @endif
                <a href="{{ url('/'.Request::segment(1).'/'.Request::segment(2).'/add') }}" class="btn m-btn--pill btn-brand add-btn m-btn--custom">
                    <i class="la la-commenting"></i> 
                    @php 
                        $string = substr(ucwords(Request::segment(2)), 0, -1);
                        $exemptions = ['modules', 'sub-modules'];
                    @endphp
                    @if (substr($string, -1) == 'e' && !in_array(Request::segment(2), $exemptions))
                        Add New {{ substr(ucwords(str_replace('-',' ', Request::segment(2))), 0, -2) }}
                    @else
                        Add New {{ substr(ucwords(str_replace('-',' ', Request::segment(2))), 0, -1) }}
                    @endif
                </a>
            </div>
        </div>
    </div>
@elseif ((\Request::is('*/*/add') && Request::segment(4) == '') || (\Request::is('*/*/edit/*') && Request::segment(5) == ''))  
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    {{ ucwords(str_replace('-',' ', Request::segment(2))) }}
                </h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{ url('/dashboard') }}" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="{{ url('/'.Request::segment(1).'/'.Request::segment(2)) }}" class="m-nav__link">
                            <span class="m-nav__link-text">
                                Manage {{ ucwords(str_replace('-',' ', Request::segment(2))) }}
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="#" class="m-nav__link">
                            <span class="m-nav__link-text">
                                @php 
                                    $string = substr(ucwords(Request::segment(2)), 0, -1);
                                    $exemptions = ['modules', 'sub-modules'];
                                @endphp
                                @if (\Request::is('*/*/edit/*'))
                                    @if (substr($string, -1) == 'e' && !in_array(Request::segment(2), $exemptions))
                                        Edit {{ substr(ucwords(str_replace('-',' ', Request::segment(2))), 0, -2) }}
                                    @else
                                        Edit {{ substr(ucwords(Request::segment(2)), 0, -1) }}
                                    @endif
                                @else
                                    @if (substr($string, -1) == 'e' && !in_array(Request::segment(2), $exemptions))
                                        New {{ substr(ucwords(str_replace('-',' ', Request::segment(2))), 0, -2) }}
                                    @else
                                        New {{ substr(ucwords(str_replace('-',' ', Request::segment(2))), 0, -1) }}
                                    @endif
                                @endif
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
            <div>
                <button type="button" class="submit-btn btn m-btn--pill btn-brand m-btn--custom">
                    <i class="la la-save"></i> Save Changes
                </button>
            </div>
        </div>
    </div>
@elseif (\Request::is('*/*/inactive') && Request::segment(4) == '')  
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    {{ ucwords(Request::segment(2)) }}
                </h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{ url('/dashboard') }}" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="javascript:;" class="m-nav__link">
                            <span class="m-nav__link-text">
                                Manage Inactive {{ ucwords(str_replace('-',' ', Request::segment(2))) }}
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
            <div>
                
            </div>
        </div>
    </div>
@elseif (\Request::is('*/*/*') && Request::segment(4) == '')  
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    @if (Request::segment(3) == 'all-gradingsheets')
                        Grading Sheets
                    @else
                        {{ ucwords(str_replace('-', ' ', Request::segment(3))) }}
                    @endif

                </h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{ url('/dashboard') }}" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="javascript:;" class="m-nav__link">
                            <span class="m-nav__link-text">
                                Manage Active {{ ucwords(str_replace('-',' ', Request::segment(3))) }}
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
            <div>
                @php 
                    $invisibles = ['transmutations', 'class-record'];
                @endphp
                @if (Request::segment(3) == 'components' && Auth::user()->type  != 'administrator')

                @elseif (!in_array(Request::segment(3), $invisibles))

                    @php 
                        $imports_academics = ['levels', 'sections', 'subjects', 'classes'];
                    @endphp
                    @if (in_array(Request::segment(3), $imports_academics))
                    
                        @php 
                            $string = substr(ucwords(Request::segment(3)), 0, -1);
                        @endphp
                        @if (substr($string, -1) == 'e')
                            <a href="javascript:;" class="btn m-btn--pill btn-accent add-btn m-btn--custom" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#import-{{ substr(strtolower(str_replace('-',' ', Request::segment(3))), 0, -2) }}">
                                <i class="la la-upload"></i> Import {{ substr(ucwords(str_replace('-',' ', Request::segment(3))), 0, -2) }}
                            </a>
                        @else
                            <a href="javascript:;" class="btn m-btn--pill btn-accent add-btn m-btn--custom" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#import-{{ substr(strtolower(str_replace('-',' ', Request::segment(3))), 0, -1) }}">
                                <i class="la la-upload"></i> Import {{ substr(ucwords(str_replace('-',' ', Request::segment(3))), 0, -1) }}
                            </a>
                        @endif
                    @endif

                    <a href="{{ url('/'.Request::segment(1).'/'.Request::segment(2).'/'.Request::segment(3).'/add') }}" class="btn m-btn--pill btn-brand add-btn m-btn--custom">
                        <i class="la la-commenting"></i> 
                        @php 
                            $string = substr(ucwords(Request::segment(3)), 0, -1);
                            $exemptions = ['modules', 'sub-modules', 'education-types'];
                        @endphp
                        @if (Request::segment(3) == 'all-gradingsheets')
                            Add New Grading Sheet
                        @else
                            @if (substr($string, -1) == 'e' && !in_array(Request::segment(3), $exemptions))
                                Add New {{ substr(ucwords(str_replace('-',' ', Request::segment(3))), 0, -2) }}
                            @else
                                @php 
                                    $exemption = [];
                                @endphp
                                @if (!in_array(Request::segment(3), $exemption))
                                    Add New {{ substr(ucwords(str_replace('-',' ', Request::segment(3))), 0, -1) }}
                                @else
                                    Add New {{ ucwords(str_replace('-',' ', Request::segment(3))) }}
                                @endif
                            @endif
                        @endif
                    </a>
                @endif
            </div>
        </div>
    </div>
@elseif ((\Request::is('*/*/*/add') && Request::segment(5) == '') || (\Request::is('*/*/*/view/*') && Request::segment(6) == '') || (\Request::is('*/*/*/edit/*') && Request::segment(6) == ''))  
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    @if (Request::segment(3) == 'all-gradingsheets')
                        Grading Sheets
                    @else
                        {{ ucwords(str_replace('-',' ', Request::segment(3))) }}
                    @endif
                </h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{ url('/dashboard') }}" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="{{ url('/'.Request::segment(1).'/'.Request::segment(2).'/'.Request::segment(3)) }}" class="m-nav__link">
                            <span class="m-nav__link-text">
                                @if (Request::segment(3) == 'all-gradingsheets')
                                    Manage Grading Sheets
                                @else
                                    Manage {{ ucwords(str_replace('-',' ', Request::segment(3))) }}
                                @endif
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="#" class="m-nav__link">
                            <span class="m-nav__link-text">
                                @php 
                                    $string = substr(ucwords(Request::segment(3)), 0, -1);
                                    $exemptions = ['modules', 'sub-modules'];
                                @endphp
                                @if (\Request::is('*/*/edit/*'))
                                    @if (Request::segment(3) == 'all-gradingsheets')
                                        Edit Grading Sheet
                                    @else
                                        @if (substr($string, -1) == 'e' && !in_array(Request::segment(3), $exemptions))
                                            Edit {{ substr(ucwords(str_replace('-',' ', Request::segment(3))), 0, -2) }}
                                        @else
                                            Edit {{ substr(ucwords(Request::segment(3)), 0, -1) }}
                                        @endif
                                    @endif
                                @else
                                    @if (\Request::is('*/*/view/*'))
                                        View Class Record
                                    @else
                                        @if (Request::segment(3) == 'all-gradingsheets')
                                            New Grading Sheet
                                        @else
                                            @if (substr($string, -1) == 'e' && !in_array(Request::segment(3), $exemptions))
                                                New {{ substr(ucwords(str_replace('-',' ', Request::segment(3))), 0, -2) }}
                                            @else
                                                New {{ substr(ucwords(str_replace('-',' ', Request::segment(3))), 0, -1) }}
                                            @endif
                                        @endif
                                    @endif
                                @endif
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
            <div>
                @if (\Request::is('*/*/view/*'))

                @else
                    <button type="button" class="submit-btn btn m-btn--pill btn-brand m-btn--custom">
                        @if (\Request::is('*/*/edit/*'))
                            <i class="la la-save"></i> Save Changes
                        @else
                            @if (Request::segment(3) == 'all-gradingsheets')
                                <i class="la la-save"></i> Generate Grading Sheet
                            @else
                                <i class="la la-save"></i> Save Changes
                            @endif
                        @endif
                    </button>
                @endif
            </div>
        </div>
    </div>
@elseif (\Request::is('*/*/*/inactive') && Request::segment(5) == '')  
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    {{ ucwords(Request::segment(3)) }}
                </h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{ url('/dashboard') }}" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="javascript:;" class="m-nav__link">
                            <span class="m-nav__link-text">
                                Manage Inactive {{ ucwords(str_replace('-',' ', Request::segment(3))) }}
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
            <div>
                
            </div>
        </div>
    </div>
@elseif (\Request::is('*/*/infoblast/*') && Request::segment(4) != '')  
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    {{ ucwords(str_replace('-',' ', Request::segment(3))) }}
                </h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{ url('/dashboard') }}" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="{{ url('/'.Request::segment(1).'/'.Request::segment(2).'/'.Request::segment(3).'/tracking') }}" class="m-nav__link">
                            <span class="m-nav__link-text">
                                Manage {{ ucwords(str_replace('-',' ', Request::segment(3))) }}
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="#" class="m-nav__link">
                            <span class="m-nav__link-text">
                                @php 
                                    $string = substr(ucwords(Request::segment(3)), 0, -1);
                                    $exemptions = ['modules', 'sub-modules'];
                                @endphp
                                @if (\Request::is('*/*/edit/*'))
                                    @if (Request::segment(4) == 'all-gradingsheets')
                                        Edit Grading Sheet
                                    @else
                                        @if (substr($string, -1) == 'e' && !in_array(Request::segment(4), $exemptions))
                                            Edit {{ substr(ucwords(str_replace('-',' ', Request::segment(4))), 0, -2) }}
                                        @else
                                            Edit {{ substr(ucwords(Request::segment(4)), 0, -1) }}
                                        @endif
                                    @endif
                                @elseif (\Request::is('*/*/infoblast/*'))
                                    @if (Request::segment(4) == 'new')
                                        New Infoblast
                                    @else
                                        @php echo ucwords(Request::segment(4)); @endphp
                                    @endif
                                @else
                                    @php 
                                        $exempted = ['infoblast'];
                                    @endphp
                                    @if (Request::segment(3) == 'all-gradingsheets')
                                        New Grading Sheet
                                    @else
                                        @if (substr($string, -1) == 'e' && !in_array(Request::segment(3), $exemptions))
                                            New {{ substr(ucwords(str_replace('-',' ', Request::segment(3))), 0, -2) }}
                                        @else
                                            @if (!in_array(Request::segment(1), $exempted))
                                                New {{ ucwords(str_replace('-',' ', Request::segment(3))) }}
                                            @else
                                                New {{ substr(ucwords(str_replace('-',' ', Request::segment(3))), 0, -1) }}
                                            @endif
                                        @endif
                                    @endif
                                @endif
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
            <div>
                @php 
                    $exemptions = ['outbox', 'tracking'];
                @endphp
                @if (\Request::is('*/*/view/*') || in_array(Request::segment(4), $exemptions))

                @else
                    @if(Request::segment(4) == 'templates' && Request::segment(5) == '') 
                        <a href="{{ url('/'.Request::segment(1).'/'.Request::segment(2).'/'.Request::segment(3).'/'.Request::segment(4).'/add') }}" class="btn m-btn--pill btn-brand add-btn m-btn--custom">
                            <i class="la la-commenting"></i>
                            Add New Template
                        </a>
                    @else
                    <button type="button" class="submit-btn btn m-btn--pill btn-brand m-btn--custom">
                        @if (\Request::is('*/*/edit/*') || \Request::is('*/*/add'))
                            <i class="la la-save"></i> Save Changes
                        @else
                            <i class="la la-send"></i> Send Message
                        @endif
                    </button>
                    @endif
                @endif
            </div>
        </div>
    </div>

    @elseif (\Request::is('*/*/emailblast/*')  && Request::segment(4) != '')  
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    @if(\Request::is('*/*/emailblast/outbox') )
                        {{ ucwords(str_replace('-',' ', Request::segment(3))).' '.ucwords(Request::segment(4)) }}
                    @elseif(\Request::is('*/*/emailblast/settings') )
                        {{ ucwords(str_replace('-',' ', Request::segment(3))).' '.ucwords(Request::segment(4)) }}
                    @elseif(\Request::is('*/*/emailblast/*'))
                        {{ ucwords(str_replace('-',' ', Request::segment(3))) }}
                    @endif
                </h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{ url('/dashboard') }}" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="{{ url('/'.Request::segment(1).'/'.Request::segment(2).'/'.Request::segment(3).'/tracking') }}" class="m-nav__link">
                            <span class="m-nav__link-text">
                                Manage {{ ucwords(str_replace('-',' ', Request::segment(3))) }}
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>

                    
                    <li class="m-nav__item">
                        <a href="#" class="m-nav__link">
                            <span class="m-nav__link-text">
                                @php 
                                    $string = substr(ucwords(Request::segment(3)), 0, -1);
                                    $exemptions = ['modules', 'sub-modules'];
                                @endphp
                                @if (\Request::is('*/*/edit/*'))
                                    @if (Request::segment(3) == 'all-emailblast')
                                        Edit Grading Sheet
                                    @else
                                        @if (substr($string, -1) == 'e' && !in_array(Request::segment(3), $exemptions))
                                            Edit {{ substr(ucwords(str_replace('-',' ', Request::segment(3))), 0, -2) }}
                                        @else
                                            Edit {{ substr(ucwords(Request::segment(3)), 0, -1) }}
                                        @endif
                                    @endif
                                @else
                                    @php 
                                        $exempted = ['emailblast', 'settings'];
                                    @endphp
                                    @if (Request::segment(4) == 'all-emailblast')
                                        New Emailblast
                                    @else
                                        @if (substr($string, -1) == 'e' && !in_array(Request::segment(3), $exemptions))
                                            New {{ substr(ucwords(str_replace('-',' ', Request::segment(3))), 0, -2) }}
                                        @else
                                            @if (!in_array(Request::segment(4), $exempted))
                                                New {{ ucwords(str_replace('-',' ', Request::segment(3))) }}
                                            @else
                                                New {{ substr(ucwords(str_replace('-',' ', Request::segment(3))), 0, -1) }}
                                            @endif
                                        @endif
                                    @endif
                                @endif
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
            <div>
                @if (\Request::is('*/*/view/*'))

                @elseif(\Request::is('*/*/*/outbox'))
                
                @elseif(\Request::is('*/*/*/settings'))
                    <a href="{{ url('/'.Request::segment(1).'/'.Request::segment(2).'/'.Request::segment(3).'/'.Request::segment(4).'/add') }}" class="btn m-btn--pill btn-brand add-btn m-btn--custom">
                        <span class="m-nav__link-text">
                            Add New Account
                        </span>
                    </a>
                @else
                    <button type="button" class="submit-btn btn m-btn--pill btn-brand m-btn--custom">
                        @if (\Request::is('*/*/edit/*') || \Request::is('*/*/*/*/add'))
                            <i class="la la-save"></i> Save Changes
                        @else
                            <i class="la la-send"></i> Send Message
                        @endif
                    </button>
                @endif
            </div>
        </div>
    </div>


@elseif (\Request::is('*/*/*/*')  && Request::segment(5) == '' || (\Request::is('*/*/*/*/add') && Request::segment(6) == '') || (\Request::is('*/*/*/*/edit/*') )) 
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                @php
                    $url = ['staff-attendance', 'student-attendance'];
                @endphp
                <h3 class="m-subheader__title m-subheader__title--separator">
                    @if (in_array(Request::segment(3), $url) && ( \Request::is('*/*/*/file-attendance') || \Request::is('*/*/*/file-attendance/*') ) )
                        {{ ucwords(str_replace('-',' ', Request::segment(3))) }}
                    @elseif( in_array(Request::segment(3), $url) && ( \Request::is('*/*/*/settings') || \Request::is('*/*/*/settings/*') ) )
                        {{ ucwords(str_replace('-',' ', Request::segment(3).' '.Request::segment(4))) }}
                    @endif
                </h3>

                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{ url('/dashboard') }}" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="{{ url('/'.Request::segment(1).'/'.Request::segment(2).'/'.Request::segment(3).'/file-attendance') }}" class="m-nav__link">
                        </a>
                    </li>
                    <li class="m-nav__item">
                        @php 
                            $string = substr(ucwords(Request::segment(3)), 0, -1);
                            $url = ['staff-attendance', 'student-attendance'];
                        @endphp

                        @if(Request::segment(4) == 'settings')
                            <a href="{{ url('/'.Request::segment(1).'/'.Request::segment(2).'/'.Request::segment(3).'/settings') }}" class="m-nav__link">
                                <span class="m-nav__link-text">
                                    @if (substr($string, -1) == 'e' && in_array(Request::segment(3), $url))
                                        Manage {{ substr(ucwords(str_replace('-',' ', Request::segment(3))), 0, -2).' '.Request::segment(4) }}
                                    @else
                                        @if( in_array(Request::segment(3), $url) && \Request::is('*/*/*/settings') )
                                            Manage {{ substr(ucwords(str_replace('-',' ', Request::segment(3)).' '.Request::segment(4) ), 0, -1) }}
                                        @else
                                            Manage {{ substr(ucwords(str_replace('-',' ', Request::segment(3))), 0, -1).' '.Request::segment(4) }}
                                        @endif
                                    @endif
                                </span>
                            </a>
                        @else
                            <a href="{{ url('/'.Request::segment(1).'/'.Request::segment(2).'/'.Request::segment(3).'/file-attendance') }}" class="m-nav__link">
                                <span class="m-nav__link-text">
                                    @if (substr($string, -1) == 'e' && in_array(Request::segment(3), $url))
                                        Manage {{ substr(ucwords(str_replace('-',' ', Request::segment(3))), 0, -2) }}
                                    @else
                                        @if (in_array(Request::segment(3), $url) && \Request::is('*/*/*/file-attendance'))
                                            Manage {{ ucwords(str_replace('-',' ', Request::segment(3))) }}
                                        @else
                                            Manage {{ substr(ucwords(str_replace('-',' ', Request::segment(3))), 0, -1) }}
                                        @endif
                                    @endif
                                </span>
                            </a>
                        @endif
                    </li>
                </ul>
            </div>

            @if (Request::segment(5) == '')   
                <div>
                    <a href="{{ url('/'.Request::segment(1).'/'.Request::segment(2).'/'.Request::segment(3).'/'.Request::segment(4).'/add') }}" class="btn m-btn--pill btn-brand add-btn m-btn--custom">
                        <i class="la la-commenting"></i>
                        @if(Request::segment(4) == 'settings')
                            Add New {{ ucwords(str_replace('-',' ', Request::segment(3))).' '.Request::segment(4) }}
                        @else
                            Add New {{ ucwords(str_replace('-',' ', Request::segment(3)))}}
                        @endif
                    </a>
                </div>
            @endif
            
            @if (\Request::is('*/*/*/*/add') || (\Request::is('*/*/*/*/edit/*')) )
                <div>
                    <button type="button" class="submit-btn btn m-btn--pill btn-brand m-btn--custom">
                            <i class="la la-save"></i> Save Changes
                    </button>
                </div>
            @endif

        </div>
    </div>
@endif

