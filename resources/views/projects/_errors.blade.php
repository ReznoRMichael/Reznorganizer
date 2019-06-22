@if($errors->any())
<div class="field">
    
    @foreach($errors->all() as $error)
        <div class="text-sm text-orange-600">{{ $error }}</div>
    @endforeach

</div>
@endif