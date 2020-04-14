@if (\Request::is('*/*') && Request::segment(3) == '')  
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    {{ ucfirst(Request::segment(2)) }}
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
                                Manange Active {{ ucfirst(Request::segment(2)) }}
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
            <div>
                <a href="{{ url('/'.Request::segment(1).'/'.Request::segment(2).'/add') }}" class="btn m-btn--pill btn-brand add-btn m-btn--custom">
                    <i class="la la-commenting"></i> 
                    @php 
                        $string = substr(ucfirst(Request::segment(2)), 0, -1);
                    @endphp
                    @if (substr($string, -1) == 'e')
                        Add New {{ substr(ucfirst(Request::segment(2)), 0, -2) }}
                    @else
                        Add New {{ substr(ucfirst(Request::segment(2)), 0, -1) }}
                    @endif
                </a>
            </div>
        </div>
    </div>
@elseif (\Request::is('*/*/inactive'))  
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    {{ ucfirst(Request::segment(2)) }}
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
                                Manange Inactive {{ ucfirst(Request::segment(2)) }}
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
                    {{ ucfirst(Request::segment(2)) }}
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
                        <a href="{{ url('/'.Request::segment(1).'/'.Request::segment(2)) }}" class="m-nav__link">
                            <span class="m-nav__link-text">
                                Manage {{ ucfirst(Request::segment(2)) }}
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
                                    $string = substr(ucfirst(Request::segment(2)), 0, -1);
                                @endphp
                                @if (\Request::is('*/*/edit/*'))
                                    @if (substr($string, -1) == 'e')
                                        Edit {{ substr(ucfirst(Request::segment(2)), 0, -2) }}
                                    @else
                                        Edit {{ substr(ucfirst(Request::segment(2)), 0, -1) }}
                                    @endif
                                @else
                                    @if (substr($string, -1) == 'e')
                                        New {{ substr(ucfirst(Request::segment(2)), 0, -2) }}
                                    @else
                                        New {{ substr(ucfirst(Request::segment(2)), 0, -1) }}
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


