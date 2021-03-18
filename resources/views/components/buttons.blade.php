@php
    $elementType = $element ?? 'page';
    $holderHidden = false;

    if(isset($hidden)){
        $holderHidden = $hidden === true ? true : false;
    }

@endphp
<div class="component-buttons-holder @if($holderHidden){{'d-none'}}@endif">
    @foreach($buttons as $button)
        @php
            $category = $button['category'];
            $text = $button['text'];
            $name = array_key_exists('name', $button) === true ? $button['name'] : '';
            $type = array_key_exists('type', $button) === true ? $button['type'] : 'button';
            $value = array_key_exists('value', $button) === true ? $button['value'] : '';
            $form = array_key_exists('form', $button) === true ? $button['form'] : null;
            $buttonHidden = array_key_exists('hidden', $button) === true ? $button['hidden'] : false;

            if($category === 'save'){
                $buttonClass = 'save';
                if($elementType === 'modal'){
                    $id = array_key_exists('id', $button) === true ? $button['id'] : 'editModalButton';
                }else{
                    $id = array_key_exists('id', $button) === true ? $button['id'] : 'save-submit';
                }
            }
            else if ($category === 'delete'){
                $buttonClass = 'delete';
                $id = array_key_exists('id', $button) === true ? $button['id'] : 'delete-submit';
            }
            else if($category === 'submit'){
                $buttonClass = 'submit';
                if($elementType === 'modal'){
                    $id = array_key_exists('id', $button) === true ? $button['id'] : 'createModalButton';
                }else{
                    $id = array_key_exists('id', $button) === true ? $button['id'] : 'save-submit';
                }

            }
            else if ($category === 'cancel'){
                $buttonClass = 'cancel';

                if($elementType === 'page'){
                    $id = array_key_exists('id', $button) === true ? $button['id'] : 'cancelModalButton';
                }
                else{
                    $id = array_key_exists('id', $button) === true ? $button['id'] : 'cancel-submit';
                }
            }

            $buttonClass = array_key_exists('buttonClass', $button) === true ? $button['buttonClass'] : '';
            $route = array_key_exists('route', $button) === true ? $button['route'] : null;

        @endphp
        <button id="{{ $id }}" name="{{ $name }}" value="{{ $value }}" type="{{ $type }}"
                @if($elementType === 'modal' && $category === 'cancel' && $type !== 'submit')
                    data-dismiss="modal"
                @endif
                class="btn {{ $category }} {{ $buttonClass }}@if($buttonHidden){{' d-none'}}@endif"
                @if($route)
                    onclick="window.location='{{$route}}'"
                @endif
                @if($form !== null)
                    form="{{ $form }}"
                @endif
                >
                {{ $text }}
        </button>
    @endforeach
</div>