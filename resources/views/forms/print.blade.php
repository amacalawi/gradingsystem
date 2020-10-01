<div class="row">
    <div class="col-md-6">
        <div class="m-portlet m-portlet--tab">
            <div class="m-portlet__body">
                <div class="row">
                    <div class="form-group m-form__group required col-md-12">
                        {{ Form::label('user_id', 'User', ['class' => '']) }}
                        {{
                            Form::select('user_id', $users, $value = '', ['class' => 'select2 form-control form-control-lg m-input m-input--solid'])
                        }}
                        <span class="m-form__help m--font-danger">
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="m-portlet m-portlet--tab">
            <div class="m-portlet__body">
                <div class="row">
                    <div class="header">
                        <ul class="menu">
                            <li class="menu-item border input-wrapper">
                                Load Template <i class="la la-upload"></i>
                                <input type="file" accept="image/*" id="input-image-file">
                            </li>
                            <li class="menu-item border " id="btn-download">Download <i class="la la-download"></i></li> 
                            <li class="menu-item border " id="btn-print"> Print <i class="la la-print"></i></li> 
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="m-portlet m-portlet--tab">
            <div class="m-portlet__body">
                <div class="tui-image-editor-controls">
                    <div class="row">
                        <ul class="menu">
                            <div class="btn-group">
                                <li class="btn menu-item disabled border" title="Undo" id="btn-undo"> <i class="la la-undo"></i> </li>
                                <li class="btn menu-item disabled border" title="Redo" id="btn-redo"> <i class="la la-refresh"></i> </li>
                                <li class="btn menu-item border" title="ClearObjects" id="btn-clear-objects"> <i class="la la-trash"></i> </li>
                                <li class="btn btn-danger menu-item border" title="RemoveActiveObject" id="btn-remove-active-object"> <i class="la la-close"></i> </li>
                                <li class="btn menu-item border" title="Crop" id="btn-crop"> <i class="la la-crop"></i> </li>
                                <li class="btn menu-item border" title="Flip" id="btn-flip"> <i class="la la-undo"></i> </li>
                                <li class="btn menu-item border" title="Rotation" id="btn-rotation"> <i class="la la-rotate-right"></i> </li>
                                <li class="btn menu-item border" title="DrawLine" id="btn-draw-line"> <i class="la la-pencil"></i> </li>
                                <li class="btn menu-item border" title="Icon" id="btn-add-icon"> <i class="la la-cube"></i> </li>
                                <li class="btn menu-item border" title="Text" id="btn-text"> <i class="la la-font"></i> </li>
                                <li class="btn menu-item border" title="Upload" id="btn-mask-filter"> <i class="la la-image"></i> </li>
                            </div>
                        </ul>
                    </div>

                    <div class="row">
                        <div class="sub-menu-container" id="crop-sub-menu">
                            <ul class="menu align-items-center">
                                <li class="menu-item btn border" id="btn-apply-crop"><i class="la la-check"></i> </li> Apply
                                <li class="menu-item btn border" id="btn-cancel-crop"><i class="la la-remove"></i> </li> Close
                            </ul>
                        </div>
                    </div>

                    <div class="row">
                        <div class="sub-menu-container" id="flip-sub-menu">
                            <ul class="menu">
                                <li class="menu-item" id="btn-flip-x">FlipX</li>
                                <li class="menu-item" id="btn-flip-y">FlipY</li>
                                <li class="menu-item" id="btn-reset-flip">Reset</li>
                                <li class="menu-item close"><i class="la la-times-circle"></i></li>
                            </ul>
                        </div>
                    </div>

                    <div class="row">
                        <div class="sub-menu-container" id="rotation-sub-menu">
                            <ul class="menu">
                                <li class="menu-item" id="btn-rotate-clockwise">Clockwise(30)</li>
                                <li class="menu-item" id="btn-rotate-counter-clockwise">Counter-Clockwise(-30)</li>
                                <li class="menu-item no-pointer"><label>Range input<input id="input-rotation-range" type="range" min="-360" value="0" max="360"></label></li>
                                <li class="menu-item close"><i class="la la-times-circle"></i></li>
                            </ul>
                        </div>
                    </div>

                    <div class="row">
                        <div class="sub-menu-container menu" id="draw-line-sub-menu">
                            <ul class="menu">
                                <li class="menu-item">
                                    <label><input type="radio" class="select-line-type" name="select-line-type" value="freeDrawing"> Free drawing</label>
                                </li>
                                <li class="menu-item">
                                    <label><input type="radio" class="select-line-type" name="select-line-type" value="lineDrawing"> Straight line</label>
                                </li>
                                <li class="menu-item">
                                    <div id="tui-brush-color-picker">Brush color</div>
                                </li>
                                <li class="menu-item"><label class="menu-item no-pointer">Brush width<input id="input-brush-width-range" type="range" min="5" max="30" value="12"></label></li>
                                <li class="menu-item close"><i class="la la-times-circle"></i></li>
                            </ul>
                        </div>
                    </div>

                    <div class="row">
                        <div class="sub-menu-container" id="icon-sub-menu">
                            <ul class="menu">
                                <li class="menu-item">
                                    <div id="tui-icon-color-picker">Icon color</div>
                                </li>
                                <li class="menu-item border" id="btn-register-icon">Register custom icon</li>
                                <li class="menu-item icon-text" data-icon-type="arrow">➡</li>
                                <li class="menu-item icon-text" data-icon-type="cancel">✖</li>
                                {{--
                                <li class="menu-item icon-text" data-icon-type="customArrow">↑</li>
                                <li class="menu-item icon-text" data-icon-type="customstar">★</li>
                                <li class="menu-item icon-text" data-icon-type="custompolygon">⬣</li>
                                <li class="menu-item icon-text" data-icon-type="customheart">♥</li>
                                <li class="menu-item close"><i class="la la-times-circle"></i></li>
                                --}}
                            </ul>
                        </div>
                    </div>

                    <div class="row">
                        <div class="sub-menu-container" id="text-sub-menu">
                            <ul class="menu">
                                <li class="menu-item">
                                    <div>
                                        <button class="btn-text-style" data-style-type="b">Bold</button>
                                        <button class="btn-text-style" data-style-type="i">Italic</button>
                                        <button class="btn-text-style" data-style-type="u">Underline</button>
                                    </div>
                                    <div>
                                        <button class="btn-text-style" data-style-type="l">Left</button>
                                        <button class="btn-text-style" data-style-type="c">Center</button>
                                        <button class="btn-text-style" data-style-type="r">Right</button>
                                    </div>
                                    <div>
                                        <button class="btn-font-style" data-style-type="A">Arial</button>
                                        <button class="btn-font-style" data-style-type="T">Times New Roman</button>
                                        <button class="btn-font-style" data-style-type="H">Helvetica</button>
                                    </div>
                                </li>
                                <li class="menu-item"><label class="no-pointer"><input id="input-font-size-range" type="range" min="10" max="100" value="10"></label></li>
                                <li class="menu-item">
                                    <div id="tui-text-color-picker">Text color</div>
                                </li>
                                <li class="menu-item close"><i class="la la-times-circle"></i></li>
                            </ul>
                        </div>
                    </div>

                    <div class="row">
                        <div class="sub-menu-container" id="filter-sub-menu">
                            <ul class="menu">
                                <li class="menu-item border input-wrapper">
                                    Upload
                                    <input type="file" accept="image/*" id="input-mask-image-file">
                                </li>
                                {{--<li class="menu-item" id="btn-apply-mask">Apply mask filter</li>--}}
                                <li class="menu-item close"><i class="la la-times-circle"></i></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <img id="default-image" src="{{asset('/storage/uploads/id-template/default.png')}}" hidden >

    <div class="col-md-6">
        <div class="m-portlet m-portlet--tab">
            <div class="m-portlet__body">
                <div class="tui-image-editor">
                    <canvas id="canvas-tui"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>