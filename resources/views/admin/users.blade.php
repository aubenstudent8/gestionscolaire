@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Gestion des utilisateurs</h1>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nom</label>
            <input name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input name="email" type="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Mot de passe</label>
            <input name="password" type="password" class="form-control" required>
        </div>
        <button class="btn btn-primary">Créer administrateur</button>
    </form>

    <hr>

    <h2>Utilisateurs existants</h2>
    <table class="table">
        <thead><tr><th>ID</th><th>Nom</th><th>Email</th><th>Rôles</th></tr></thead>
        <tbody>
        @foreach($users as $u)
            <tr>
                <td>{{ $u->id }}</td>
                <td>{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td>{{ implode(', ', $u->getRoleNames()->toArray()) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
