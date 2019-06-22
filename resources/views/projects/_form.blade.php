@csrf

<div class="field mb-6">
    <label class="label text-lg mb-2 block" for="title">Note Title</label>
    <div class="control">

        <input type="text"
            class="input bg-transparent border border-muted-light rounded p-2 w-full"
            name="title"
            placeholder="What do you want to create?"
            value="{{ $project->title }}"
            required>

    </div>
</div>

<div class="field mb-6">
    <label class="label text-lg mb-2 block" for="description">Note Description</label>
    <div class="control">

        <textarea
            class="textarea bg-transparent border border-muted-light rounded p-2 mb-4 w-full"
            name="description"
            placeholder="Add a brief description of your Note"
            rows="10"
            required>{{ $descriptionText }}</textarea>

    </div>
</div>


<div class="field mb-6">
    <div class="control">
        <button type="submit" class="button mr-2">{{ $buttonText }}</button>

        <a class="button" href="{{ $project->path() }}">Cancel</a>
    </div>
</div>

@if($errors->any())
<div class="field">
    
    @foreach($errors->all() as $error)
        <div class="text-sm text-orange-600">{{ $error }}</div>
    @endforeach

</div>
@endif