@inject('roles', 'App\Http\Controllers\UserRoleController')
@if ( $segment == 'edit' )
    {{ Form::open(array('url' => 'memberships/users/roles/update/'.$role->id, 'name' => 'user_role_form', 'method' => 'PUT')) }}
@else
    {{ Form::open(array('url' => 'memberships/users/roles/store', 'name' => 'user_role_form', 'method' => 'POST')) }}
@endif
<div class="row">
    <div class="col-md-12">
        <div class="m-portlet m-portlet--tab">
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-md-12 hidden">
                        {{ 
                            Form::text($name = 'method', $value = ($segment == 'edit') ? 'edit' : 'add', 
                            $attributes = array(
                                'id' => 'method',
                                'class' => 'form-control form-control-lg m-input m-input--solid'
                            )) 
                        }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group m-form__group required">
                            {{ Form::label('code', 'Code', ['class' => '']) }}
                            {{ 
                                Form::text($name = 'code', $value = $role->code, 
                                $attributes = array(
                                    'id' => 'code',
                                    'class' => 'form-control form-control-lg m-input m-input--solid'
                                )) 
                            }}
                            <span class="m-form__help m--font-danger">
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group m-form__group required">
                            {{ Form::label('name', 'Name', ['class' => '']) }}
                            {{ 
                                Form::text($name = 'name', $value = $role->name, 
                                $attributes = array(
                                    'id' => 'name',
                                    'class' => 'form-control form-control-lg m-input m-input--solid'
                                )) 
                            }}
                            <span class="m-form__help m--font-danger">
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group m-form__group">
                            {{ Form::label('description', 'Description', ['class' => '']) }}
                            {{ 
                                Form::textarea($name = 'description', $value = $role->description, 
                                $attributes = array(
                                    'id' => 'description',
                                    'class' => 'form-control form-control-lg m-input m-input--solid',
                                    'rows' => 3
                                )) 
                            }}
                            <span class="m-form__help m--font-danger">
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="m-portlet m-portlet--tab">
            <div class="m-portlet__body">
                <a href="javascript:;" class="check-roles" value="checkall">[ Check All ]</a>
                <a href="javascript:;" class="check-roles" value="uncheckall">[ Uncheck All ]</a>
                <div class="m-accordion m-accordion--bordered m-accordion--solid" id="m_accordion_4" role="tablist">
                    <div class="row">
                        @foreach ($headers as $header)
                            <div class="col-md-6 margin-top-bottom-10">
                                <div class="m-accordion__item">
                                    <div class="m-accordion__item-head collapsed" id="m_accordion_4_item_{{ $header['id'] }}_head">
                                        <span class="m-accordion__item-icon">
                                            <label class="m-checkbox">
                                                @if (!empty($role))
                                                    @php $headerCheck = $roles->check_header_if_checked($header['id'], $role->id); @endphp
                                                    @if ($headerCheck > 0)
                                                        <input type="checkbox" name="headers[]" value="{{ $header['id'] }}" checked="checked">
                                                    @else
                                                        <input type="checkbox" name="headers[]" value="{{ $header['id'] }}">
                                                    @endif
                                                @else
                                                    <input type="checkbox" name="headers[]" value="{{ $header['id'] }}">
                                                @endif
                                                <span></span>
                                            </label>
                                        </span>
                                        <span class="m-accordion__item-title">
                                            {{ $header['name'] }}
                                        </span>
                                        <span role="tab" href="#m_accordion_4_item_{{ $header['id'] }}_body" data-toggle="collapse" class="m-accordion__item-mode" aria-expanded="false"></span>
                                    </div>
                                    <div class="m-accordion__item-body collapse" id="m_accordion_4_item_{{ $header['id'] }}_body" class=" " role="tabpanel" aria-labelledby="m_accordion_4_item_{{ $header['id'] }}_head" data-parent="#m_accordion_4">
                                        <div class="m-accordion__item-content">
                                            <div class="m-checkbox-list">
                                                @foreach ($header['modules'] as $module)
                                                    <label class="m-checkbox">
                                                        @if (!empty($role))
                                                            @php $moduleCheck = $roles->check_module_if_checked($module['id'], $role->id); @endphp
                                                            @if ($moduleCheck > 0)
                                                                <input type="checkbox" name="modules[]" value="{{ $module['id'] }}" checked="checked">
                                                            @else
                                                                <input type="checkbox" name="modules[]" value="{{ $module['id'] }}">
                                                            @endif
                                                        @else
                                                            <input type="checkbox" name="modules[]" value="{{ $module['id'] }}">
                                                        @endif
                                                            {{ $module['name'] }}
                                                        <span></span>
                                                    </label>
                                                    @foreach ($header['sub_modules'][$module['id']] as $sub_module)
                                                        <div class="m-left-2 m-checkbox-list">
                                                            <label class="m-checkbox">
                                                                @if (!empty($role))
                                                                    @php $subModuleCheck = $roles->check_sub_module_if_checked($sub_module['id'], $role->id); @endphp
                                                                    @if ($subModuleCheck['count'] > 0)
                                                                        <input module="{{ $module['id'] }}" type="checkbox" name="sub_modules[]" value="{{ $sub_module['id'] }}" checked="checked">
                                                                    @else
                                                                        <input module="{{ $module['id'] }}" type="checkbox" name="sub_modules[]" value="{{ $sub_module['id'] }}">
                                                                    @endif
                                                                @else
                                                                    <input module="{{ $module['id'] }}" type="checkbox" name="sub_modules[]" value="{{ $sub_module['id'] }}">
                                                                @endif
                                                                    {{ $sub_module['name'] }}
                                                                <span></span>
                                                                <div class="pull-right">
                                                                    <a href="javascript:;" class="toggle-crud">
                                                                        <i class="la la-plus"></i>
                                                                    </a>
                                                                </div>
                                                                <div class="toggle-crud-info hidden">
                                                                    <div class="m-checkbox-inline margin-top-bottom-10">
                                                                        <label class="m-checkbox">
                                                                            @if (!empty($role))
                                                                                @if ($subModuleCheck['create'] > 0)
                                                                                    <input submodule="{{ $sub_module['id'] }}" type="checkbox" name="crud[{{ $sub_module['id'] }}][1]" value="1" checked="checked">
                                                                                @else
                                                                                    <input submodule="{{ $sub_module['id'] }}" type="checkbox" name="crud[{{ $sub_module['id'] }}][1]" value="1">
                                                                                @endif
                                                                            @else
                                                                                <input submodule="{{ $sub_module['id'] }}" type="checkbox" name="crud[{{ $sub_module['id'] }}][1]" value="1">
                                                                            @endif
                                                                                Create
                                                                            <span></span>
                                                                        </label>
                                                                        <label class="m-checkbox">
                                                                            @if (!empty($role))
                                                                                @if ($subModuleCheck['read'] > 0)
                                                                                    <input submodule="{{ $sub_module['id'] }}" type="checkbox" name="crud[{{ $sub_module['id'] }}][2]" value="1" checked="checked">
                                                                                @else
                                                                                    <input submodule="{{ $sub_module['id'] }}" type="checkbox" name="crud[{{ $sub_module['id'] }}][2]" value="1">
                                                                                @endif
                                                                            @else
                                                                                <input submodule="{{ $sub_module['id'] }}" type="checkbox" name="crud[{{ $sub_module['id'] }}][2]" value="1">
                                                                            @endif
                                                                                Read
                                                                            <span></span>
                                                                        </label>
                                                                        <label class="m-checkbox">
                                                                            @if (!empty($role))
                                                                                @if ($subModuleCheck['update'] > 0)
                                                                                    <input submodule="{{ $sub_module['id'] }}" type="checkbox" name="crud[{{ $sub_module['id'] }}][3]" value="1" checked="checked">
                                                                                @else
                                                                                    <input submodule="{{ $sub_module['id'] }}" type="checkbox" name="crud[{{ $sub_module['id'] }}][3]" value="1">
                                                                                @endif
                                                                            @else
                                                                                <input submodule="{{ $sub_module['id'] }}" type="checkbox" name="crud[{{ $sub_module['id'] }}][3]" value="1">
                                                                            @endif
                                                                                Update
                                                                            <span></span>
                                                                        </label>
                                                                        <label class="m-checkbox">
                                                                            @if (!empty($role))
                                                                                @if ($subModuleCheck['delete'] > 0)
                                                                                    <input submodule="{{ $sub_module['id'] }}" type="checkbox" name="crud[{{ $sub_module['id'] }}][4]" value="1" checked="checked">
                                                                                @else
                                                                                    <input submodule="{{ $sub_module['id'] }}" type="checkbox" name="crud[{{ $sub_module['id'] }}][4]" value="1">
                                                                                @endif
                                                                            @else
                                                                                <input submodule="{{ $sub_module['id'] }}" type="checkbox" name="crud[{{ $sub_module['id'] }}][4]" value="1">
                                                                            @endif
                                                                                Delete
                                                                            <span></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}