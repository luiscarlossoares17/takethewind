@php
    $modalSize = 'modal-lg';
    $closable = $closable ?? true;
    $hasHeader = $hasHeader ?? true;
    if(isset($size)){
        if($size === 'small'){
            $modalSize = 'modal-sm';
        }
        elseif ($size === 'medium'){
            $modalSize = 'modal-md';
        }
        elseif ($size === 'large'){
            $modalSize = 'modal-lg';
        }
        elseif ($size === 'xlarge'){
            $modalSize = 'modal-xl';
        }
        elseif($size === 'xxlarge'){
            $modalSize = 'modal-xxl';
        }
        else {
            $modalSize = 'modal-lg';
        }
    }
@endphp

<div class="modal fade" id="{{ $id }}" name="{{ $name }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered {{ $modalSize }}">
        <div class="modal-content">
            {{-- INCLUDING MODAL HEADER --}}
            @if($hasHeader === true)
                <div class="modal-main-header">
                    <div id="" class="modal-title ml-1 mt-2">
                        <h4>{{ $title }}</h4>
                    </div>
                    @if($closable === true)
                        <div class="close-button" data-dismiss="modal">
                            <i class="icon-close"></i>
                        </div>
                    @endif
                </div>
                @isset($subtitle)
                    <div class="bcore-modal-subheader">
                        <div class="bcore-modal-subtitle">{{ $subtitle }}</div>
                    </div>
                @endisset
            @endif
            <div id="@if(isset($modalBodyId)){{$modalBodyId}}@else{{'modalBodyDiv'}}@endif" class="modal-body bcore-modal-body">
                    @isset($content)
                        {{ $content }}
                    @endisset
            </div>
                @isset($footer)
                    <div class="bcore-modal-footer">
                        {{ $footer }}
                    </div>
                @endisset
        </div>
    </div>
</div>