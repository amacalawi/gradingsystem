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
                    $imports = ['students'];
                @endphp
                @if (in_array(Request::segment(2), $imports))
                <a href="javascript:;" class="btn m-btn--pill btn-accent add-btn m-btn--custom" data-toggle="modal" data-target="#import-student">
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

                    @if (Request::segment(3) == 'sections' || Request::segment(3) == 'levels' || Request::segment(3) == 'subjects' || Request::segment(3) == 'classes')
                        <button type="button" class="btn m-btn--pill btn-success m-btn--custom" data-toggle="modal" data-target="#importmodule">
                            Import {{ ucwords(Request::segment(3)) }}
                        </button>
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
@elseif (\Request::is('*/*/infoblast/*')  && Request::segment(4) != '')  
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
                @if (\Request::is('*/*/view/*'))

                @else
                    <button type="button" class="submit-btn btn m-btn--pill btn-brand m-btn--custom">
                        @if (\Request::is('*/*/edit/*'))
                            <i class="la la-save"></i> Save Changes
                        @else
                            <i class="la la-send"></i> Send Message
                        @endif
                    </button>
                @endif
            </div>
        </div>
    </div>
@endif

