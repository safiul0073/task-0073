@props([
    'value' => 'value',
    'label' => 'label',
    'selected' => 'false',
    'flag' => '',
    'image' => '',
    'filter_by' => '',
])
@aware([ 'onselect' => '', ])

@php
    $selected = filter_var($selected, FILTER_VALIDATE_BOOLEAN);
@endphp
<div class="py-3 pl-4 pr-3 flex items-center text-base cursor-pointer hover:bg-slate-100/90 dark:hover:bg-dark-800/50 dark:hover:text-dark-200 bw-select-item"
     data-label="{{ $label }}" data-value="{{ $value }}"
     @if(!empty($filter_by)) data-filter-value="{{$filter_by}}" @endif
     @if($selected) data-selected="true" @endif
     @if($onselect !== '') data-user-function="{{ $onselect }}"@endif>
    @if ($flag !== '' && $image == '')
        <i class="{{ $flag }} flag"></i>
    @endif
    @if ($image !== '')
        <x-bladewind::avatar size="small" class="!mt-0 !mr-4" image="{{ $image }}"/>
    @endif
    <span class="grow text-left">{!! html_entity_decode($label) !!}</span>
    <x-bladewind::icon name="check-circle" class="text-slate-400 size-5 hidden svg-{{$value }}"/>
</div>