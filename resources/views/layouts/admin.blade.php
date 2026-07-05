<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titre', 'Administration') — Blac Joyaux</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --noir: #141110;
            --noir-doux: #221D1A;
            --creme: #F7F3EC;
            --blanc-chaud: #FFFDF9;
            --or: #B98A2F;
            --or-clair: #D9B96A;
            --encre: #2B2622;
            --gris: #8A8178;
            --ligne: #E6DFD3;
            --danger: #8E2323;
            --ok: #25402C;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Jost', sans-serif;
            background: var(--creme);
            color: var(--encre);
            display: flex;
            min-height: 100vh;
            font-size: 15px;
        }
        h1, h2, h3, .serif { font-family: 'Cormorant Garamond', serif; }

        /* ---------- Barre latérale ---------- */
        .sidebar {
            width: 240px;
            background: var(--noir);
            color: #EDE6DA;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; bottom: 0; left: 0;
        }
        .marque {
            padding: 32px 24px 24px;
            border-bottom: 1px solid rgba(217, 185, 106, .25);
        }
        .marque .nom {
            font-family: 'Cormorant Garamond', serif;
            font-size: 22px;
            letter-spacing: .35em;
            color: var(--or-clair);
            text-transform: uppercase;
        }
        .marque .sous {
            font-size: 11px;
            letter-spacing: .2em;
            text-transform: uppercase;
            color: var(--gris);
            margin-top: 6px;
        }
        .nav { padding: 20px 0; flex: 1; }
        .nav a {
            display: block;
            padding: 12px 24px;
            color: #CFC7BA;
            text-decoration: none;
            letter-spacing: .04em;
            border-left: 2px solid transparent;
            transition: all .15s;
        }
        .nav a:hover { color: var(--or-clair); }
        .nav a.actif {
            color: var(--or-clair);
            border-left-color: var(--or);
            background: rgba(217, 185, 106, .07);
        }
        .deconnexion { padding: 20px 24px; border-top: 1px solid rgba(217,185,106,.15); }
        .deconnexion button {
            background: none; border: none; color: var(--gris);
            font-family: inherit; font-size: 14px; cursor: pointer; letter-spacing: .04em;
        }
        .deconnexion button:hover { color: var(--or-clair); }

        /* ---------- Contenu ---------- */
        .contenu { margin-left: 240px; flex: 1; padding: 40px 48px; max-width: 1200px; }
        .entete { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 28px; }
        .entete h1 { font-size: 34px; font-weight: 600; }
        .entete .fil { font-size: 12px; letter-spacing: .18em; text-transform: uppercase; color: var(--or); margin-bottom: 4px; }

        /* ---------- Boutons ---------- */
        .btn {
            display: inline-block; padding: 11px 22px;
            font-family: 'Jost', sans-serif; font-size: 14px; letter-spacing: .06em;
            border: none; cursor: pointer; text-decoration: none; transition: all .15s;
        }
        .btn-or { background: var(--noir); color: var(--or-clair); }
        .btn-or:hover { background: var(--or); color: var(--noir); }
        .btn-ligne { background: transparent; color: var(--encre); border: 1px solid var(--ligne); }
        .btn-ligne:hover { border-color: var(--or); color: var(--or); }
        .btn-danger { background: transparent; color: var(--danger); border: 1px solid transparent; }
        .btn-danger:hover { border-color: var(--danger); }
        .btn-petit { padding: 6px 12px; font-size: 13px; }

        /* ---------- Cartes / tableaux ---------- */
        .carte { background: var(--blanc-chaud); border: 1px solid var(--ligne); padding: 26px; margin-bottom: 24px; }
        table { width: 100%; border-collapse: collapse; }
        th {
            text-align: left; font-size: 11px; letter-spacing: .16em; text-transform: uppercase;
            color: var(--gris); font-weight: 500; padding: 10px 12px; border-bottom: 1px solid var(--ligne);
        }
        td { padding: 14px 12px; border-bottom: 1px solid var(--ligne); vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        .vignette { width: 54px; height: 54px; object-fit: cover; background: var(--creme); border: 1px solid var(--ligne); }
        .vignette-vide {
            width: 54px; height: 54px; display: flex; align-items: center; justify-content: center;
            background: var(--creme); border: 1px dashed var(--ligne); color: var(--gris); font-size: 10px;
        }
        .pastille { display: inline-block; width: 16px; height: 16px; border-radius: 50%; border: 1px solid var(--ligne); vertical-align: middle; }
        .etiquette {
            display: inline-block; font-size: 11px; letter-spacing: .1em; text-transform: uppercase;
            padding: 4px 10px; border: 1px solid var(--ligne); color: var(--gris);
        }
        .etiquette.on { border-color: var(--ok); color: var(--ok); }
        .etiquette.off { border-color: var(--gris); }

        /* ---------- Formulaires ---------- */
        label { display: block; font-size: 12px; letter-spacing: .14em; text-transform: uppercase; color: var(--gris); margin-bottom: 7px; }
        input[type=text], input[type=number], input[type=email], input[type=password], select, textarea {
            width: 100%; padding: 11px 13px;
            font-family: 'Jost', sans-serif; font-size: 15px; color: var(--encre);
            background: var(--blanc-chaud); border: 1px solid var(--ligne); outline: none; transition: border-color .15s;
        }
        input:focus, select:focus, textarea:focus { border-color: var(--or); }
        textarea { resize: vertical; min-height: 96px; }
        .champ { margin-bottom: 20px; }
        .grille-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .grille-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }

        .choix-couleurs { display: flex; flex-wrap: wrap; gap: 10px; }
        .choix-couleurs label {
            display: flex; align-items: center; gap: 8px; cursor: pointer;
            border: 1px solid var(--ligne); padding: 8px 14px; margin: 0;
            font-size: 13px; letter-spacing: .04em; text-transform: none; color: var(--encre);
            background: var(--blanc-chaud); transition: border-color .15s;
        }
        .choix-couleurs label:has(input:checked) { border-color: var(--or); background: #FBF6EA; }
        .choix-couleurs input { accent-color: var(--or); }

        .interrupteur { display: flex; align-items: center; gap: 10px; }
        .interrupteur input { width: 18px; height: 18px; accent-color: var(--or); }
        .interrupteur span { font-size: 14px; color: var(--encre); }

        /* ---------- Filtres ---------- */
        .filtres { display: grid; grid-template-columns: repeat(6, 1fr) auto; gap: 12px; align-items: end; }
        .filtres .champ { margin-bottom: 0; }
        @media (max-width: 1100px) { .filtres { grid-template-columns: repeat(3, 1fr); } }

        /* ---------- Messages ---------- */
        .flash { padding: 13px 18px; margin-bottom: 22px; border-left: 3px solid var(--ok); background: #EEF2ED; color: var(--ok); }
        .erreurs { padding: 13px 18px; margin-bottom: 22px; border-left: 3px solid var(--danger); background: #F6ECEC; color: var(--danger); }
        .erreurs ul { margin-left: 18px; }

        /* ---------- Galerie images ---------- */
        .galerie { display: flex; flex-wrap: wrap; gap: 14px; }
        .galerie .item { position: relative; width: 130px; }
        .galerie img { width: 130px; height: 130px; object-fit: cover; border: 1px solid var(--ligne); display: block; }
        .galerie .item.couverture img { border: 2px solid var(--or); }
        .galerie .badge-cover {
            position: absolute; top: 6px; left: 6px; background: var(--noir); color: var(--or-clair);
            font-size: 10px; letter-spacing: .12em; text-transform: uppercase; padding: 3px 8px;
        }
        .galerie .actions { display: flex; gap: 6px; margin-top: 6px; }

        .pagination { margin-top: 20px; display: flex; gap: 6px; }
        .pagination a, .pagination span {
            padding: 7px 12px; border: 1px solid var(--ligne); text-decoration: none; color: var(--encre); font-size: 14px;
        }
        .pagination .actif, .pagination a:hover { border-color: var(--or); color: var(--or); }
        .vide { text-align: center; color: var(--gris); padding: 48px 0; }
        .vide .serif { font-size: 22px; color: var(--encre); margin-bottom: 6px; }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="marque">
        <div class="nom">Blac Joyaux</div>
        <div class="sous">Administration</div>
    </div>
    <nav class="nav">
        <a href="{{ route('admin.produits.index') }}" class="{{ request()->routeIs('admin.produits.*') ? 'actif' : '' }}">Sacs</a>
        <a href="{{ route('admin.commandes.index') }}" class="{{ request()->routeIs('admin.commandes.*') ? 'actif' : '' }}">Commandes</a>
        <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'actif' : '' }}">Collections</a>
        <a href="{{ route('admin.couleurs.index') }}" class="{{ request()->routeIs('admin.couleurs.*') ? 'actif' : '' }}">Couleurs</a>
    </nav>
    <div class="deconnexion">
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit">Se déconnecter</button>
        </form>
    </div>
</aside>

<main class="contenu">
    @if (session('succes'))
        <div class="flash">{{ session('succes') }}</div>
    @endif

    @if ($errors->any())
        <div class="erreurs">
            <ul>
                @foreach ($errors->all() as $erreur)
                    <li>{{ $erreur }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('contenu')
</main>

</body>
</html>
