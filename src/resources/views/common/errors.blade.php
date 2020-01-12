@if (count($errors) > 0)
    <div class="alert alert-danger" role="alert">
        <strong>おや？何かがおかしいようです！</strong>
        <br><br>
        
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif