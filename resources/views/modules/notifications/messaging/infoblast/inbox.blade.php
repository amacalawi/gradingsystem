@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="m-portlet m-portlet--full-height ">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <div class="flex align-items-center">
                                <div class="mr-auto">
                                    <h3 class="m-portlet__head-text">
                                        All Active {{ ucfirst(Request::segment(4)) }} 
                                    </h3> 
                                </div>
                                <div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="m-input-icon m-input-icon--left m-bottom-2">
                                <input type="text" class="form-control m-input m-input--solid" placeholder="Search Keywords" id="generalSearch">
                                <span class="m-input-icon__icon m-input-icon__icon--left">
                                    <span>
                                        <i class="la la-search"></i>
                                    </span>
                                </span>
                            </div>
                            <div class="m-tabs" data-tabs="true" data-tabs-contents="#m_sections">
                                <ul class="m-nav m-nav--active-bg m-nav--active-bg-padding-lg m-nav--font-lg m-nav--font-bold m--margin-bottom-20 m--margin-top-10 m--margin-right-40" id="m_nav" role="tablist">
                                    @foreach ($inboxes as $inbox)
                                        <li class="m-nav__item">
                                            <a class="m-nav__link m-tabs__item m-tabs__item--active" data-tab-target="#m_section_1" href="#">
                                                <span class="m-nav__link-text">
                                                    @if ($inbox->user_id !== NULL)

                                                    @else
                                                        {{ $inbox->msisdn }}
                                                    @endif
                                                </span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="m-timeline-1 m-timeline-1--fixed">
                                <div class="m-timeline-1__items">
                                    <div class="m-timeline-1__marker"></div>
                                    <div class="m-timeline-1__item m-timeline-1__item--left m-timeline-1__item--first">
                                        <div class="m-timeline-1__item-circle">
                                            <div class="m--bg-danger"></div>
                                        </div>
                                        <div class="m-timeline-1__item-arrow"></div>
                                        <span class="m-timeline-1__item-time m--font-brand">
                                            11:35
                                            <span>
                                                AM
                                            </span>
                                        </span>
                                        <div class="m-timeline-1__item-content">
                                            <div class="m-timeline-1__item-title">
                                                Users Joined Today
                                            </div>
                                            <div class="m-timeline-1__item-body">
                                                <div class="m-timeline-1__item-body m--margin-top-15">
                                                    Lorem ipsum dolor sit amit,consectetur eiusmdd
                                                    <br>
                                                    tempors labore et dolore.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-timeline-1__item m-timeline-1__item--right">
                                        <div class="m-timeline-1__item-circle">
                                            <div class="m--bg-danger"></div>
                                        </div>
                                        <div class="m-timeline-1__item-arrow"></div>
                                        <span class="m-timeline-1__item-time m--font-brand">
                                            02:50
                                            <span>
                                                PM
                                            </span>
                                        </span>
                                        <div class="m-timeline-1__item-content">
                                            <div class="m-timeline-1__item-title">
                                                Users Joined Today
                                            </div>
                                            <div class="m-timeline-1__item-body">
                                                <div class="m-timeline-1__item-body m--margin-top-15">
                                                    Lorem ipsum dolor sit amit,consectetur eiusmdd
                                                    <br>
                                                    tempors labore et dolore.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-layer">
                                <div class="row">
                                    <div class="col-md-10">
                                        <textarea id="messages" class="form-control form-control-lg m-input m-input--solid" rows="2" maxlength="500" name="messages" cols="50"></textarea>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="text-btn btn btn-brand m-btn--custom">
                                            <i class="la la-send"></i> SEND
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
@endsection
