<div class="card flex flex-col" style="height: 200px;">
    
    <h3 class="font-normal text-xl py-4 -ml-5 mb-3 border-l-4 border-orange-400 pl-4">
        <a href="{{ $project->path() }}" class="text-default no-underline hover:text-orange-400">{{ $project->title }}</a>
    </h3>

    <div class="text-default-alt mb-4 flex-1">{{ str_limit($project->description, 200) }}</div>

    @can('manage', $project)
    <footer>
        <form action="{{ $project->path() }}" method="post" class="text-right">
            @method('DELETE')
            @csrf
            <button type="submit" class="text-xs hover:text-orange-400">Delete Entry</button>
        </form>
    </footer>
    @endcan

</div>