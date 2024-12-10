@extends('admin.layouts.private')

@section('content')
<div class="container my-5">
    <h1>Enviar newsletter</h1>
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('newsletters.send') }}" method="post">
        @csrf
        <div class="form-group mt-3">
            <label for="subject">Asunto:</label>
            <input type="text" name="subject" id="subject" class="form-control" required>
        </div>

        <div class="form-group mt-5">
            <label for="body">Contenido:</label>
            <textarea name="body" id="body" class="form-control" rows="10" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary mt-5">Enviar newsletter</button>
    </form>
</div>
@endsection
