<div class="row">
    <div class="col-md-12">
        <div class="m-portlet m-portlet--tab">
            <div class="m-portlet__body">
                <div class="tui-image-editor-controls">
                    <div class="header">
                        <ul class="menu">
                            <li class="menu-item border input-wrapper">
                                Load
                                <input type="file" accept="image/*" id="input-image-file">
                            </li>
                            <li class="menu-item border" id="btn-download">Download</li>
                        </ul>
                    </div>
                    <ul class="menu">
                        <li class="menu-item disabled" id="btn-undo">Undo</li>
                        <li class="menu-item disabled" id="btn-redo">Redo</li>
                        <li class="menu-item" id="btn-clear-objects">ClearObjects</li>
                        <li class="menu-item" id="btn-remove-active-object">RemoveActiveObject</li>
                        <li class="menu-item" id="btn-crop">Crop</li>
                        <li class="menu-item" id="btn-flip">Flip</li>
                        <li class="menu-item" id="btn-rotation">Rotation</li>
                        <li class="menu-item" id="btn-draw-line">DrawLine</li>
                        <li class="menu-item" id="btn-add-icon">Icon</li>
                        <li class="menu-item" id="btn-text">Text</li>
                        <li class="menu-item" id="btn-mask-filter">Mask</li>
                    </ul>

                    <div class="sub-menu-container" id="crop-sub-menu">
                        <ul class="menu">
                            <li class="menu-item" id="btn-apply-crop">Apply</li>
                            <li class="menu-item" id="btn-cancel-crop">Cancel</li>
                        </ul>
                    </div>
                    <div class="sub-menu-container" id="flip-sub-menu">
                        <ul class="menu">
                            <li class="menu-item" id="btn-flip-x">FlipX</li>
                            <li class="menu-item" id="btn-flip-y">FlipY</li>
                            <li class="menu-item" id="btn-reset-flip">Reset</li>
                            <li class="menu-item close">Close</li>
                        </ul>
                    </div>
                    <div class="sub-menu-container" id="rotation-sub-menu">
                        <ul class="menu">
                            <li class="menu-item" id="btn-rotate-clockwise">Clockwise(30)</li>
                            <li class="menu-item" id="btn-rotate-counter-clockwise">Counter-Clockwise(-30)</li>
                            <li class="menu-item no-pointer"><label>Range input<input id="input-rotation-range" type="range" min="-360" value="0" max="360"></label></li>
                            <li class="menu-item close">Close</li>
                        </ul>
                    </div>
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
                            <li class="menu-item close">Close</li>
                        </ul>
                    </div>
                    <div class="sub-menu-container" id="icon-sub-menu">
                        <ul class="menu">
                            <li class="menu-item">
                                <div id="tui-icon-color-picker">Icon color</div>
                            </li>
                            <li class="menu-item border" id="btn-register-icon">Register custom icon</li>
                            <li class="menu-item icon-text" data-icon-type="arrow">➡</li>
                            <li class="menu-item icon-text" data-icon-type="cancel">✖</li>
                            <li class="menu-item close">Close</li>
                        </ul>
                    </div>
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
                            </li>
                            <li class="menu-item"><label class="no-pointer"><input id="input-font-size-range" type="range" min="10" max="100" value="10"></label></li>
                            <li class="menu-item">
                                <div id="tui-text-color-picker">Text color</div>
                            </li>
                            <li class="menu-item close">Close</li>
                        </ul>
                    </div>
                    <div class="sub-menu-container" id="filter-sub-menu">
                        <ul class="menu">
                            <li class="menu-item border input-wrapper">
                                Load Mask Image
                                <input type="file" accept="image/*" id="input-mask-image-file">
                            </li>
                            <li class="menu-item" id="btn-apply-mask">Apply mask filter</li>
                            <li class="menu-item close">Close</li>
                        </ul>
                    </div>
                </div>
                <div class="tui-image-editor">
                    <canvas></canvas>
                </div>
            </div>
        </div>
    </div>
</div>