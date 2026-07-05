@extends('layouts.admin')

@section('titre', 'Ajouter un sac')

@section('contenu')

<div class="entete">
    <div>
        <div class="fil">Catalogue</div>
        <h1>Ajouter un sac</h1>
    </div>
</div>

<form method="POST" action="{{ route('admin.produits.store') }}" enctype="multipart/form-data">
    @include('admin.produits._form', ['produit' => null])
</form>

@endsection
