@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Modifier le Rapport</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Erreurs :</strong>
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

        <!-- Expéditeur -->
        <div class="mb-3">
            <label for="titre" class="form-label">Titre</label>
            <input type="text" class="form-control" id="titre" name="titre"
                   value="{{ old('titre', $rapport->titre) }}" required>
        </div>

        <!-- Observation -->
        <div class="mb-3">
            <label for="commentaire" class="form-label">Commentaire</label>
            <input type="text" class="form-control" id="commentaire" name="commentaire"
                   value="{{ old('commentaire', $rapport->commentaire) }}" required>
        </div>

        <!-- Date de réception -->
        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" name="date"
                   value="{{ old('date', \Carbon\Carbon::parse($rapport->date)->format('Y-m-d')) }}"
>
        </div>

        <!-- Fichier -->
        <div class="mb-3">
            <label for="fichier" class="form-label">Pièce jointe (si vous souhaitez la remplacer)</label>
            <input type="file" class="form-control" name="fichier" id="fichier">
            @if ($rapport->fichier)
                <p class="mt-2">Fichier actuel :
                    <a href="{{ asset('storage/' . $rapport->fichier) }}" target="_blank">Voir la pièce jointe</a>
                </p>
            @endif
        </div>

        <!-- Bouton -->
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('rapports.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
