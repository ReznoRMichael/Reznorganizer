<div class="card mt-3 text-sm">
  @foreach($project->activity as $activity)
      <div class="{{ $loop->last ? '' : 'mb-1' }}">
        @include("projects.activity.{$activity->description}")
        <span class="text-gray-500">{{ $activity->created_at->diffForHumans(null, true) }}</span>
      </div>
  @endforeach
</div>