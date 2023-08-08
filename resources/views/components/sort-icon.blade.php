@if($orderBy !== $field)
    <span></span>
@elseif($sortAsc)
    <i class="fa-solid fa-chevron-up"></i>
@else
    <i class="fa-solid fa-chevron-down"></i>
@endif
