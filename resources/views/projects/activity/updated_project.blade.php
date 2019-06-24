@if(count( $activity->changes['after']) == 1 )
    {{ $activity->user->name }} updated {{ key($activity->changes['after']) }}
@else
{{ $activity->user->name }} updated the entry
@endif