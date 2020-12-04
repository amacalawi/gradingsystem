!function($) {

    'use strict';

    var supportingFileAPI = !!(window.File && window.FileList && window.FileReader);
    var rImageType = /data:(image\/.+);base64,/;
    var mask;

    // Functions
    // HEX to RGBA
    function hexToRGBa(hex, alpha) {
        var r = parseInt(hex.slice(1, 3), 16);
        var g = parseInt(hex.slice(3, 5), 16);
        var b = parseInt(hex.slice(5, 7), 16);
        var a = alpha || 1;

        return 'rgba(' + r + ', ' + g + ', ' + b + ', ' + a + ')';
    }
    function base64ToBlob(data) {
        var mimeString = '';
        var raw, uInt8Array, i, rawLength;

        raw = data.replace(rImageType, function(header, imageType) {
            mimeString = imageType;

            return '';
        });

        raw = atob(raw);
        rawLength = raw.length;
        uInt8Array = new Uint8Array(rawLength); // eslint-disable-line

        for (i = 0; i < rawLength; i += 1) {
            uInt8Array[i] = raw.charCodeAt(i);
        }

        return new Blob([uInt8Array], {type: mimeString});
    }
    function getBrushSettings() {
        var brushWidth = $inputBrushWidthRange.val();
        var brushColor = brushColorpicker.getColor();

        return {
            width: brushWidth,
            color: hexToRGBa(brushColor, 0.5)
        };
    }

    // Buttons
    var $btns = $('.menu-item');
    var $btnsActivatable = $btns.filter('.activatable');
    var $inputImage = $('#input-image-file');
    var $btnDownload = $('#btn-download');
    var $btnPrint = $('#btn-print');

    var $btnUndo = $('#btn-undo');
    var $btnRedo = $('#btn-redo');
    var $btnClearObjects = $('#btn-clear-objects');
    var $btnRemoveActiveObject = $('#btn-remove-active-object');
    var $btnCrop = $('#btn-crop');
    var $btnFlip = $('#btn-flip');
    var $btnRotation = $('#btn-rotation');
    var $btnDrawLine = $('#btn-draw-line');
    var $btnApplyCrop = $('#btn-apply-crop');
    var $btnCancelCrop = $('#btn-cancel-crop');
    var $btnFlipX = $('#btn-flip-x');
    var $btnFlipY = $('#btn-flip-y');
    var $btnResetFlip = $('#btn-reset-flip');
    var $btnRotateClockwise = $('#btn-rotate-clockwise');
    var $btnRotateCounterClockWise = $('#btn-rotate-counter-clockwise');
    var $btnText = $('#btn-text');
    var $btnClosePalette = $('#btn-close-palette');
    var $btnTextStyle = $('.btn-text-style');
    var $btnAddIcon = $('#btn-add-icon');
    var $btnRegisterIcon = $('#btn-register-icon');
    var $btnMaskFilter = $('#btn-mask-filter');
    var $btnLoadMaskImage = $('#input-mask-image-file');
    var $btnApplyMask = $('#btn-apply-mask');
    var $btnClose = $('.close');

    // Range Input
    var $inputRotationRange = $('#input-rotation-range');
    var $inputBrushWidthRange = $('#input-brush-width-range');
    var $inputFontSizeRange = $('#input-font-size-range');

    // Font Style
    var $btnFontStyle = $('.btn-font-style');

    // Member
    var $userID = $('#user_id');

    // Sub menus
    var $displayingSubMenu = $();
    var $cropSubMenu = $('#crop-sub-menu');
    var $flipSubMenu = $('#flip-sub-menu');
    var $rotationSubMenu = $('#rotation-sub-menu');
    var $freeDrawingSubMenu = $('#free-drawing-sub-menu');
    var $drawLineSubMenu = $('#draw-line-sub-menu');
    var $textSubMenu = $('#text-sub-menu');
    var $iconSubMenu = $('#icon-sub-menu');
    var $filterSubMenu = $('#filter-sub-menu');

    // Select line type
    var $selectMode = $('[name="select-line-type"]');

    // Text palette
    var $textPalette = $('#tui-text-palette');

    // Image editor
    var imageEditor = new tui.component.ImageEditor('.tui-image-editor canvas', {
        cssMaxWidth: 700,
        cssMaxHeight: 500
    });

    // Color picker for free drawing
    var brushColorpicker = tui.component.colorpicker.create({
        container: $('#tui-brush-color-picker')[0],
        color: '#000000'
    });

    // Color picker for text palette
    var textPaletteColorpicker = tui.component.colorpicker.create({
        container: $('#tui-text-color-picker')[0],
        color: '#000000'
    });

    // Color picker for icon
    var iconColorpicker = tui.component.colorpicker.create({
        container: $('#tui-icon-color-picker')[0],
        color: '#000000'
    });

    brushColorpicker.on('selectColor', function(event) {
        imageEditor.setBrush({
            color: hexToRGBa(event.color, 0.5)
        });
    });

    // Attach image editor custom events
    imageEditor.once('loadImage', function() {
        imageEditor.clearUndoStack();
        swal({
            title: "Message",
            text: "This feature is still in development.",
            type: "warning",
            showCancelButton: false,
            closeOnConfirm: true,
            confirmButtonClass: "btn btn-warning btn-focus m-btn m-btn--pill m-btn--air m-btn--custom"
        });
    });

    var resizeEditor = function() {
        var $editor = $('.tui-image-editor');
        var $container = $('.tui-image-editor-canvas-container');
        var height = parseFloat($container.css('max-height'));

        $editor.height(height);
    };

    imageEditor.on({
        endCropping: function() {
            $cropSubMenu.hide();
            resizeEditor();
        },
        endFreeDrawing: function() {
            $freeDrawingSubMenu.hide();
        },
        emptyUndoStack: function() {
            $btnUndo.addClass('disabled');
            resizeEditor();
        },
        emptyRedoStack: function() {
            $btnRedo.addClass('disabled');
            resizeEditor();
        },
        pushUndoStack: function() {
            $btnUndo.removeClass('disabled');
            resizeEditor();
        },
        pushRedoStack: function() {
            $btnRedo.removeClass('disabled');
            resizeEditor();
        },
        activateText: function(obj) {
            $displayingSubMenu.hide();
            $displayingSubMenu = $textSubMenu.show();

            if (obj.type === 'new') { // add new text on cavas
                imageEditor.addText('Double Click', {
                    position: obj.originPosition
                });
            }
        },
        adjustObject: function(obj, type) {
            if (obj.type === 'text' && type === 'scale') {
                $inputFontSizeRange.val(obj.getFontSize());
            }
        },
        removeObject: function(obj) {
            console.log(obj);
        }
    });

    // Member
    $userID.on('change', function() {

        if($(this).val())
        {

            $.ajax({
                type: 'GET',
                url: base_url + 'components/id-management/print-id/search/'+$(this).val(),
                success: function(response) {
                    
                    var data = $.parseJSON(response);
                    var id_objects = ['identification_no', 'firstname', 'lastname', 'avatar'];
                    var id_objects_properties = '';

                    for (var x in data) {
                        if(id_objects.includes( x )){
                            if( x == 'avatar'){
                                imageEditor.addImageObject('{{asset("storage/uploads/students/'+data.identification_no+'/default.jpg")}}');
                           
                            } if(x == 'identification_no'){

                                imageEditor.addText( data[x], {
                                    id: 1,
                                    styles: {
                                        fill: '#000',
                                        fontSize: 100,
                                        fontWeight: 'bold'
                                    },
                                    position: {
                                        x: 100,
                                        y: 100
                                    }
                                });
                                imageEditor.changeText( 1, 'change text');
                                
                            }else{
                                imageEditor.addText( data[x], {
                                    styles: {
                                        fill: '#000',
                                        fontSize: 100,
                                        fontWeight: 'bold'
                                    },
                                    position: {
                                        x: 100,
                                        y: 100
                                    }
                                });
                            }
                        }else {
                            console.log(data[x]);
                        }
                    }
                        
                }, 
                complete: function() {
                    window.onkeydown = null;
                    window.onfocus = null;
                }
            });
        }
    });

    // Attach button click event listeners
    $btns.on('click', function() {
        $btnsActivatable.removeClass('active');
    });

    $btnsActivatable.on('click', function() {
        $(this).addClass('active');
    });

    $btnUndo.on('click', function() {
        $displayingSubMenu.hide();
        imageEditor.undo();
    });

    $btnRedo.on('click', function() {
        $displayingSubMenu.hide();
        imageEditor.redo();
    });

    $btnClearObjects.on('click', function() {
        $displayingSubMenu.hide();
        imageEditor.clearObjects();
    });

    $btnRemoveActiveObject.on('click', function() {
        $displayingSubMenu.hide();
        imageEditor.removeActiveObject();
    });

    $btnCrop.on('click', function() {
        imageEditor.startCropping();
        $displayingSubMenu.hide();
        $displayingSubMenu = $cropSubMenu.show();
    });

    $btnFlip.on('click', function() {
        imageEditor.endAll();
        $displayingSubMenu.hide();
        $displayingSubMenu = $flipSubMenu.show();
    });

    $btnRotation.on('click', function() {
        imageEditor.endAll();
        $displayingSubMenu.hide();
        $displayingSubMenu = $rotationSubMenu.show();
    });

    $btnClose.on('click', function() {
        imageEditor.endAll();
        $displayingSubMenu.hide();
    });

    $btnApplyCrop.on('click', function() {
        imageEditor.endCropping(true);
    });

    $btnCancelCrop.on('click', function() {
        imageEditor.endCropping();
        $displayingSubMenu.hide();
    });

    $btnFlipX.on('click', function() {
        imageEditor.flipX();
    });

    $btnFlipY.on('click', function() {
        imageEditor.flipY();
    });

    $btnResetFlip.on('click', function() {
        imageEditor.resetFlip();
    });

    $btnRotateClockwise.on('click', function() {
        imageEditor.rotate(30);
    });

    $btnRotateCounterClockWise.on('click', function() {
        imageEditor.rotate(-30);
    });

    $inputRotationRange.on('mousedown', function() {
        var changeAngle = function() {
            imageEditor.setAngle(parseInt($inputRotationRange.val(), 10));
        };
        $(document).on('mousemove', changeAngle);
        $(document).on('mouseup', function stopChangingAngle() {
            $(document).off('mousemove', changeAngle);
            $(document).off('mouseup', stopChangingAngle);
        });
    });

    $inputBrushWidthRange.on('change', function() {
        imageEditor.setBrush({width: parseInt(this.value, 10)});
    });

    $inputImage.on('change', function(event) {
        var file;

        if (!supportingFileAPI) {
            alert('This browser does not support file-api');
        }

        file = event.target.files[0];
        imageEditor.loadImageFromFile(file);
    });

    $btnDownload.on('click', function() {
        var imageName = imageEditor.getImageName();
        var dataURL = imageEditor.toDataURL();
        var blob, type, w;

        if (supportingFileAPI) {
            blob = base64ToBlob(dataURL);
            type = blob.type.split('/')[1];
            if (imageName.split('.').pop() !== type) {
                imageName += '.' + type;
            }

            // Library: FileSaver - saveAs
            saveAs(blob, imageName); // eslint-disable-line
        } else {
            alert('This browser needs a file-server');
            w = window.open();
            w.document.body.innerHTML = '<img src=' + dataURL + '>';
        }
    });

    $btnPrint.on('click', function() {
        printJS({printable: document.querySelector("#canvas-tui").toDataURL(), type: 'image', imageStyle: 'width:20px, height:20px'});
    });

    // control draw mode
    $btnDrawLine.on('click', function() {
        imageEditor.endAll();
        $displayingSubMenu.hide();
        $displayingSubMenu = $drawLineSubMenu.show();
        $selectMode.removeAttr('checked');
    });

    $selectMode.on('change', function() {
        var mode = $(this).val();
        var settings = getBrushSettings();
        var state = imageEditor.getCurrentState();

        if (mode === 'freeDrawing') {
            if (state === 'FREE_DRAWING') {
                imageEditor.endFreeDrawing();
            }
            imageEditor.startFreeDrawing(settings);
        } else {
            if (state === 'LINE') {
                imageEditor.endLineDrawing();
            }
            imageEditor.startLineDrawing(settings);
        }
    });

    // control text mode
    $btnText.on('click', function() {
        if (imageEditor.getCurrentState() === 'TEXT') {
            $(this).removeClass('active');
            imageEditor.endTextMode();
        } else {
            $displayingSubMenu.hide();
            $displayingSubMenu = $textSubMenu.show();
            imageEditor.startTextMode();
            $textPalette.hide();
        }
    });

    $inputFontSizeRange.on('change', function() {
        imageEditor.changeTextStyle({
            fontSize: parseInt(this.value, 10),
        });
    });

    $btnTextStyle.on('click', function(e) { // eslint-disable-line
        var styleType = $(this).attr('data-style-type');
        var styleObj;

        e.stopPropagation();

        switch (styleType) {
            case 'b':
                styleObj = {fontWeight: 'bold'};
                break;
            case 'i':
                styleObj = {fontStyle: 'italic'};
                break;
            case 'u':
                styleObj = {textDecoration: 'underline'};
                break;
            case 'l':
                styleObj = {textAlign: 'left'};
                break;
            case 'c':
                styleObj = {textAlign: 'center'};
                break;
            case 'r':
                styleObj = {textAlign: 'right'};
                break;
            default:
                styleObj = {};
        }

        imageEditor.changeTextStyle(styleObj);
    });

    $btnFontStyle.on('click', function(e) { // eslint-disable-line
        var styleType = $(this).attr('data-style-type');
        var styleObj;

        e.stopPropagation();

        switch (styleType) {
            case 'A':
                styleObj = {fontFamily: 'arial'};
                break;
            case 'T':
                styleObj = {fontFamily: 'times new roman'};
                break;
            case 'H':
                styleObj = {fontFamily: 'helvetica'};
                break;
            default:
                styleObj = {};
        }

        imageEditor.changeTextStyle(styleObj);
    });


    textPaletteColorpicker.on('selectColor', function(event) {
        imageEditor.changeTextStyle({
            'fill': event.color
        });
    });

    $btnClosePalette.on('click', function() {
        imageEditor.deactivateAll();
        $textPalette.hide();
    });

    // control icon
    $btnAddIcon.on('click', function() {
        imageEditor.endAll();
        $displayingSubMenu.hide();
        $displayingSubMenu = $iconSubMenu.show();
    });

    $btnRegisterIcon.on('click', function() {
        $iconSubMenu.find('.menu').append(
                '<li class="menu-item icon-text" data-icon-type="customArrow">↑</li>',
                //'<li class="menu-item icon-text" data-icon-type="customarrow"><h6>Arrow 2</h6></li>',
                //'<li class="menu-item icon-text" data-icon-type="customStar">Star 1</li>',
                '<li class="menu-item icon-text" data-icon-type="customstar">★</li>',
                //'<li class="menu-item icon-text" data-icon-type="customarrow2"></li>',
                //'<li class="menu-item icon-text" data-icon-type="customarrow3"></li>',
                //'<li class="menu-item icon-text" data-icon-type="customstar2"></li>',
                '<li class="menu-item icon-text" data-icon-type="custompolygon">⬣</li>',
                //'<li class="menu-item icon-text" data-icon-type="customlocation"><h6>Location</h6></li>',
                '<li class="menu-item icon-text" data-icon-type="customheart">♥</li>',
        );

        imageEditor.registerIcons({
            customArrow: 'M 60 0 L 120 60 H 90 L 75 45 V 180 H 45 V 45 L 30 60 H 0 Z',
            customStar: 'M 272.70141,238.71731 \
            C 206.46141,238.71731 152.70146,292.4773 152.70146,358.71731  \
            C 152.70146,493.47282 288.63461,528.80461 381.26391,662.02535 \
            C 468.83815,529.62199 609.82641,489.17075 609.82641,358.71731 \
            C 609.82641,292.47731 556.06651,238.7173 489.82641,238.71731  \
            C 441.77851,238.71731 400.42481,267.08774 381.26391,307.90481 \
            C 362.10311,267.08773 320.74941,238.7173 272.70141,238.71731  \
            z ',
            customarrow: 'M40 12 V 0 l 24 24-24 24 V 36 H0V12h40z',
	        customarrow2: 'M49,32 H3 V22 h46 l-18,-18 h12 l23,23 L43,50 h-12 l18,-18  z ',
	        customarrow3: 'M43.349998,27 L17.354,53 H1.949999 l25.996,-26 L1.949999,1 h15.404 L43.349998,27  z ',
	        customstar: 'M35,54.557999 l-19.912001,10.468 l3.804,-22.172001 l-16.108,-15.7 l22.26,-3.236 L35,3.746 l9.956,20.172001 l22.26,3.236 l-16.108,15.7 l3.804,22.172001  z ',
	        customstar2: 'M17,31.212 l-7.194,4.08 l-4.728,-6.83 l-8.234,0.524 l-1.328,-8.226 l-7.644,-3.14 l2.338,-7.992 l-5.54,-6.18 l5.54,-6.176 l-2.338,-7.994 l7.644,-3.138 l1.328,-8.226 l8.234,0.522 l4.728,-6.83 L17,-24.312 l7.194,-4.08 l4.728,6.83 l8.234,-0.522 l1.328,8.226 l7.644,3.14 l-2.338,7.992 l5.54,6.178 l-5.54,6.178 l2.338,7.992 l-7.644,3.14 l-1.328,8.226 l-8.234,-0.524 l-4.728,6.83  z ',
	        custompolygon: 'M3,31 L19,3 h32 l16,28 l-16,28 H19  z ',
	        customlocation: 'M24 62C8 45.503 0 32.837 0 24 0 10.745 10.745 0 24 0s24 10.745 24 24c0 8.837-8 21.503-24 38zm0-28c5.523 0 10-4.477 10-10s-4.477-10-10-10-10 4.477-10 10 4.477 10 10 10z',
	        customheart: 'M49.994999,91.349998 l-6.96,-6.333 C18.324001,62.606995 2.01,47.829002 2.01,29.690998 C2.01,14.912998 13.619999,3.299999 28.401001,3.299999 c8.349,0 16.362,5.859 21.594,12 c5.229,-6.141 13.242001,-12 21.591,-12 c14.778,0 26.390999,11.61 26.390999,26.390999 c0,18.138 -16.314001,32.916 -41.025002,55.374001 l-6.96,6.285  z ',
	        custombubble: 'M44 48L34 58V48H12C5.373 48 0 42.627 0 36V12C0 5.373 5.373 0 12 0h40c6.627 0 12 5.373 12 12v24c0 6.627-5.373 12-12 12h-8z'
        });

        $btnRegisterIcon.off('click');
    });

    $iconSubMenu.on('click', '.menu-item', function() {
        var iconType = $(this).attr('data-icon-type');

        imageEditor.addIcon(iconType);
    });

    iconColorpicker.on('selectColor', function(event) {
        imageEditor.changeIconColor(event.color);
    });

    // control mask filter
    $btnMaskFilter.on('click', function() {
        imageEditor.endAll();
        $displayingSubMenu.hide();


        $displayingSubMenu = $filterSubMenu.show();
    });

    $btnLoadMaskImage.on('change', function() {
        var file;
        var imgUrl;

        if (!supportingFileAPI) {
            alert('This browser does not support file-api');
        }

        file = event.target.files[0];

        if (file) {
            imgUrl = URL.createObjectURL(file);

            imageEditor.loadImageFromURL(imageEditor.toDataURL(), 'FilterImage');

            imageEditor.addImageObject(imgUrl);
        }
    });

    $btnApplyMask.on('click', function() {
        imageEditor.applyFilter('mask');
    });

    // Etc..
    // Load sample image
    imageEditor.loadImageFromURL('https://easybadges-easybadges.netdna-ssl.com/wp-content/uploads/2016/05/ID-card-template-corporate-11-sample.png', 'SampleImage');
   
    // IE9 Unselectable
    $('.menu').on('selectstart', function() {
        return false;
    });

}(window.jQuery);
