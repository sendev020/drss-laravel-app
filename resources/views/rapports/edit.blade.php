@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Modifier le rapport</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Erreur !</strong> Veuillez corriger les erreurs ci-dessous :
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('rapports.update', $rapport->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="titre" class="form-label">Titre du rapport</label>
            <input type="text" name="titre" class="form-control" value="{{ old('titre', $rapport->titre) }}" required>
        </div>

        <div class="mb-3">
            <label for="fichier" class="form-label">Fichier (PDF, DOC, etc.)</label>
            <input type="file" name="fichier" class="form-control">
            @if ($rapport->fichier)
                <small class="d-block mt-2">Fichier actuel :
                    <a href="{{ asset('storage/rapports/' . $rapport->fichier) }}" target="_blank">Voir ou télécharger</a>
                </small>
            @endif
        </div>

        <button type="submit" class="btn btn-success">
            <i class="bi bi-check-circle"></i> Enregistrer les modifications
        </button>
        <a href="{{ route('rapports.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
