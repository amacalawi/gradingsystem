@if (\Request::is('*/*/*') && Request::segment(4) == '')  
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    {{ ucwords(Request::segment(3)) }}
                </h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{ url('/') }}" class="m-nav__link m-nav__link--icon">
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
                <a href="{{ url('/'.Request::segment(1).'/'.Request::segment(2).'/'.Request::segment(3).'/add') }}" class="btn m-btn--pill btn-brand add-btn m-btn--custom">
                    <i class="la la-commenting"></i> 
                    @php 
                        $string = substr(ucwords(Request::segment(3)), 0, -1);
                        $exemptions = ['modules', 'sub-modules'];
                    @endphp
                    @if (substr($string, -1) == 'e' && !in_array(Request::segment(3), $exemptions))
                        Add New {{ substr(ucwords(str_replace('-',' ', Request::segment(3))), 0, -2) }}
                    @else
                        Add New {{ substr(ucwords(str_replace('-',' ', Request::segment(3))), 0, -1) }}
                    @endif
                </a>
            </div>
        </div>
    </div>
@elseif (\Request::is('*/*/*/inactive'))  
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    {{ ucwords(Request::segment(3)) }}
                </h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{ url('/') }}" class="m-nav__link m-nav__link--icon">
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
@elseif (\Request::is('*/*/add') || \Request::is('*/*/edit/*'))  
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    {{ ucwords(str_replace('-',' ', Request::segment(3))) }}
                </h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{ url('/') }}" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="{{ url('/'.Request::segment(1).'/'.Request::segment(2).'/'.Request::segment(3)) }}" class="m-nav__link">
                            <span class="m-nav__link-text">
                                Manage {{ ucwords(str_replace('-',' ', Request::segment(3))) }}
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="" class="m-nav__link">
                            <span class="m-nav__link-text">
                                @php 
                                    $string = substr(ucwords(Request::segment(3)), 0, -1);
                                    $exemptions = ['modules', 'sub-modules'];
                                @endphp
                                @if (\Request::is('*/*/edit/*'))
                                    @if (substr($string, -1) == 'e' && !in_array(Request::segment(3), $exemptions))
                                        Edit {{ substr(ucwords(str_replace('-',' ', Request::segment(3))), 0, -2) }}
                                    @else
                                        Edit {{ substr(ucwords(Request::segment(3)), 0, -1) }}
                                    @endif
                                @else
                                    @if (substr($string, -1) == 'e' && !in_array(Request::segment(3), $exemptions))
                                        New {{ substr(ucwords(str_replace('-',' ', Request::segment(3))), 0, -2) }}
                                    @else
                                        New {{ substr(ucwords(str_replace('-',' ', Request::segment(3))), 0, -1) }}
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
@endif


