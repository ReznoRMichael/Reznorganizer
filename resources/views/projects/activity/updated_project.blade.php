@if(count( $activity->changes['after']) == 1 )
    {{ ucwords($activity->user->name) }} updated the {{ key($activity->changes['after']) }}
@else
    {{ ucwords($activity->user->name) }} updated the entry
@endif