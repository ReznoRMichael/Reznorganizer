@csrf

<div class="field mb-6">
    <label class="label text-lg mb-2 block" for="title">Title</label>
    <div class="control">

        <input type="text"
            class="input bg-transparent border border-muted-light rounded p-2 w-full"
            name="title"
            placeholder="Create anything: to-do list, recipe, instruction, note..."
            value="{{ $project->title }}"
            required>

    </div>
</div>

<div class="field mb-6">
    <label class="label text-lg mb-2 block" for="description">Description</label>
    <div class="control">

        <textarea
            class="textarea bg-transparent border border-muted-light rounded p-2 mb-4 w-full"
            name="description"
            placeholder="Add a brief description for your to-do list, recipe, instruction, note..."
            rows="10"
            required>{{ $descriptionText }}</textarea>

    </div>
</div>


<div class="field mb-6">
    <div class="control">
        <button type="submit" class="button rt-orange mr-2">{{ $buttonText }}</button>

        <a class="button btn-gray" href="{{ $project->path() }}">Cancel</a>
    </div>
</div>

@include('_errors')