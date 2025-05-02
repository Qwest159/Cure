<!DOCTYPE html>
<html>
<head>
    <title>Cure</title>
</head>
<body>

<p>Bonjour Virginie,</p>

<p>Nom: {{$donnée["Nom"]}} {{$donnée["Prénom"]}}</p>
<p>Email: {{$donnée["Email"]}}</p>
<p>Téléphone: {{$donnée["Téléphone"]}}</p>
<p>Nombre de personne: {{$donnée["Nombres"]}}</p>
<p>Chambre souhaitée: {{$donnée["Chambre"]}} </p>

@if ($donnée["Cure"] === "Oui")
<p>Type de formule: {{$donnée["Formule"]}}</p>
@else
<p>Type de formule: Aucune</p>
@endif


@if ($donnée["Commentaire"])
<p>Commentaire: {{$donnée["Commentaire"]}}</p>
@endif
<p>Bonne journée :D</p>
</body>
</html>
