<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — Blac Joyaux</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Jost', sans-serif;
            background: #141110;
            color: #EDE6DA;
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
        }
        .boite { width: 100%; max-width: 400px; padding: 24px; }
        .marque { text-align: center; margin-bottom: 40px; }
        .marque .nom {
            font-family: 'Cormorant Garamond', serif;
            font-size: 30px; letter-spacing: .4em; text-transform: uppercase; color: #D9B96A;
        }
        .marque .filet { width: 48px; height: 1px; background: #B98A2F; margin: 18px auto 0; }
        .marque .sous { font-size: 11px; letter-spacing: .25em; text-transform: uppercase; color: #8A8178; margin-top: 16px; }
        label { display: block; font-size: 11px; letter-spacing: .18em; text-transform: uppercase; color: #8A8178; margin-bottom: 8px; }
        input {
            width: 100%; padding: 13px 15px; margin-bottom: 20px;
            font-family: inherit; font-size: 15px; color: #EDE6DA;
            background: #221D1A; border: 1px solid #3A332D; outline: none;
        }
        input:focus { border-color: #B98A2F; }
        button {
            width: 100%; padding: 14px; margin-top: 6px;
            font-family: inherit; font-size: 14px; letter-spacing: .18em; text-transform: uppercase;
            background: #B98A2F; color: #141110; border: none; cursor: pointer; transition: background .15s;
        }
        button:hover { background: #D9B96A; }
        .erreur { border-left: 2px solid #C0562F; padding: 10px 14px; margin-bottom: 22px; color: #E0A891; font-size: 14px; background: rgba(192,86,47,.08); }
        .souvenir { display: flex; align-items: center; gap: 8px; margin-bottom: 8px; font-size: 13px; color: #8A8178; }
        .souvenir input { width: auto; margin: 0; accent-color: #B98A2F; }
    </style>
</head>
<body>
<div class="boite">
    <div class="marque">
        <div class="nom">Blac Joyaux</div>
        <div class="filet"></div>
        <div class="sous">Espace administration</div>
    </div>

    @if ($errors->any())
        <div class="erreur">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('admin.login.post') }}">
        @csrf
        <label for="email">Adresse e-mail</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>

        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" required>

        <label class="souvenir">
            <input type="checkbox" name="remember" value="1"> Rester connectée
        </label>

        <button type="submit">Se connecter</button>
    </form>
</div>
</body>
</html>
