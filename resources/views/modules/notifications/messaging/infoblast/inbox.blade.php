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
                        <div class="col-md-3 border-right">
                            <div class="m-scrollable" data-scrollable="true" data-max-height="400">
                                <div class="m-input-icon m-input-icon--left m-bottom-2">
                                    <input type="text" class="form-control m-input m-input--solid" placeholder="Search Keywords" id="generalSearch">
                                    <span class="m-input-icon__icon m-input-icon__icon--left">
                                        <span>
                                            <i class="la la-search"></i>
                                        </span>
                                    </span>
                                </div>
                                <div class="m-tabs" data-tabs="true" data-tabs-contents="#m_sections">
                                    <ul class="m-nav m-nav--active-bg m-nav--active-bg-padding-lg m-nav--font-lg m-nav--font-bold m--margin-bottom-20 m--margin-top-10" id="m_nav" role="tablist">
                                        @foreach ($inboxes as $inbox)
                                            <li class="m-nav__item">
                                                <a class="m-nav__link m-tabs__item" data-tab-target="#m_section_1" data-msisdn="{{ $inbox->msisdn }}" href="javascript:;">
                                                    <span class="m-nav__link-text text-center">
                                                        @if ($inbox->user_id !== NULL)
                                                            {{ $inbox->user->name }}
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
                        </div>
                        <div class="col-md-9">
                            <div class="m-scrollable" data-scrollable="true" data-max-height="400">
                                <div id="panel-result">
                                </div>
                            </div>
                            <div class="text-layer">
                                {{ Form::open(array('url' => 'notifications/messaging/infoblast/send', 'name' => 'infoblast_form', 'method' => 'POST')) }}
                                    <div class="row">
                                        <div class="col-md-10">
                                            <textarea id="messages" class="form-control form-control-lg m-input m-input--solid" rows="2" maxlength="500" name="messages" cols="50"></textarea>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="submit-btn text-btn btn btn-brand m-btn--custom">
                                                <i class="la la-send"></i> SEND
                                            </button>
                                        </div>
                                    </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script src="{{ asset('js/forms/inbox.js') }}" type="text/javascript"></script>
@endpush