<!DOCTYPE html>
<html>
<head>
    <title>Cure</title>
</head>
<body>

<p>Bonjour Virginie,</p>

<p>Nom: {{$donnée["nom"]}} {{$donnée["prénom"]}}</p>
<p>Email: {{$donnée["email"]}}</p>
<p>Téléphone: {{$donnée["téléphone"]}}</p>
<p>Nombre de personne: {{$donnée["nombres"]}}</p>
<p>Chambre souhaitée: {{$donnée["chambre"]}} {{$donnée["date"]}}</p>

@if ($donnée["cure"] === "Oui")
    <p>Type de formule numéro 1: {{ $donnée["formule1"] }}</p>
    @if ($donnée["nombres"] === "2")
        <p>Type de formule numéro 2: {{ $donnée["formule2"] }}</p>
    @endif
@else
    <p>Type de formule: Aucune</p>
@endif



@if ($donnée["commentaire"])
<p>Commentaire: {{$donnée["commentaire"]}}</p>
@endif
<p>Bonne journée :D</p>
</body>
</html>
