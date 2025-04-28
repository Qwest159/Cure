<?php

return [
    'required' => 'Le champ :attribute est obligatoire.',
    'string' => 'Le champ :attribute doit être une chaîne de caractères.',
    'integer' => 'Le champ :attribute doit être un chiffre.',
    'max' => [
        'string' => 'Le champ :attribute ne peut pas dépasser :max caractères.',
    ],
    'min' => [
        'string' => 'Le champ :attribute doit contenir au moins :min caractères.',
    ],
    'email' => 'Le champ :attribute doit être une adresse e-mail valide.',
    'in' => 'Le champ :attribute avec la valeur ":input" ne correspond pas à nos enregistrements.',
    'required_if' => 'Le champ :attribute est demandé car le "Type de nettoyage" est : ":value"',
    'required_without' => 'Le champ :attribute est obligatoire.'
];
