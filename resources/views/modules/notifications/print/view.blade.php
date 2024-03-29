@extends('layouts.app')

@section('content')
    @include('forms.print')
@endsection

@push('scripts')
    <script type="text/javascript" src="https://uicdn.toast.com/tui.code-snippet/v1.5.0/tui-code-snippet.min.js"></script>
    <script type="text/javascript" src="https://uicdn.toast.com/tui-color-picker/v2.2.6/tui-color-picker.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/1.6.6/fabric.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.3/FileSaver.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/gh/nhnent/tui.component.colorpicker@1.0.2/dist/colorpicker.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/gh/nhnent/tui.component.image-editor@1.3.0/dist/image-editor.min.js"></script>
    <script type="text/javascript" src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/forms/printid.js') }}" ></script>
@endpush

@push('styles')
    <link href="https://cdn.jsdelivr.net/gh/nhnent/tui.component.image-editor@1.3.0/samples/css/colorpicker.min.css" rel="stylesheet" type="text/css" >
    <link href="https://cdn.jsdelivr.net/gh/nhnent/tui.component.image-editor@1.3.0/samples/css/tui-image-editor.css" rel="stylesheet" type="text/css" >
    <link href="https://printjs-4de6.kxcdn.com/print.min.css" rel="stylesheet" type="text/css" >
@endpush