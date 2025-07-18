@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Ajouter un rapport</h2>

    <form action="{{ route('rapports.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="titre" class="form-label">Titre du rapport</label>
            <input type="text" name="titre" id="titre" class="form-control" required>
        </div>

         <div class="mb-3">
            <label for="commentaire" class="form-label">Commentaire</label>
            <input type="text" name="commentaire" id="commentaire" class="form-control" required>
        </div>

         <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" name="date" id="date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="fichier" class="form-label">Fichier</label>
            <input type="file" name="fichier" id="fichier" class="form-control" required>
        </div>

        <button class="btn btn-primary" type="submit">Enregistrer</button>
    </form>
</div>
@endsection
