@extends('layouts.admin')

@section('titre', 'Modifier ' . $produit->nom)

@section('contenu')

<div class="entete">
    <div>
        <div class="fil">Catalogue</div>
        <h1>{{ $produit->nom }}</h1>
    </div>
</div>

<form method="POST" action="{{ route('admin.produits.update', $produit) }}" enctype="multipart/form-data">
    @method('PUT')
    @include('admin.produits._form')
</form>

{{-- Formulaires séparés pour les actions sur les images (hors du formulaire principal) --}}
@foreach ($produit->images as $image)
    <form id="suppr-image-{{ $image->id }}" method="POST"
          action="{{ route('admin.produits.images.destroy', [$produit, $image]) }}">
        @csrf
        @method('DELETE')
    </form>
    <form id="cover-{{ $image->id }}" method="POST"
          action="{{ route('admin.produits.images.cover', [$produit, $image]) }}">
        @csrf
        @method('PATCH')
    </form>
@endforeach

@endsection
