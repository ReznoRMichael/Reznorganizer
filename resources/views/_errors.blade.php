@if($errors->{ $bag ?? 'default' }->any())
<div class="field mt-6">
    
    @foreach($errors->{ $bag ?? 'default' }->all() as $error)
        <div class="text-sm text-accent text-center">{{ $error }}</div>
    @endforeach

</div>
@endif