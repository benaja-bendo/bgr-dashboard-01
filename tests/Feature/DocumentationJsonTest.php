<?php

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;

beforeEach(function () {
    // Utilisation du trait RefreshDatabase pour réinitialiser la base de données à chaque test
    $this->refreshDatabase();
});

it('can create, retrieve, update, and delete a Student', function () {
    // Créer un nouveau Student via l'API
    $response = $this->StudentJson('/api/v1/Students', [
        'title' => 'Mon premier Student',
        'content' => 'Ceci est le contenu du Student.'
    ]);

    $response->assertStatus(201); // Vérifie que le statut de la réponse est 201 Created
    $response->assertJsonStructure([
        'data' => [
            'id', 'title', 'content', 'created_at', 'updated_at'
        ]
    ]);

    $StudentId = $response->json('data.id'); // Récupère l'ID du Student créé

    // Récupérer le Student créé
    $response = $this->getJson("/api/v1/Students/{$StudentId}");
    $response->assertStatus(200); // Vérifie que le statut de la réponse est 200 OK
    $response->assertJson([
        'data' => [
            'id' => $StudentId,
            'title' => 'Mon premier Student',
            'content' => 'Ceci est le contenu du Student.'
        ]
    ]);

    // Mettre à jour le Student
    $response = $this->putJson("/api/v1/Students/{$StudentId}", [
        'title' => 'Titre mis à jour',
        'content' => 'Contenu mis à jour.'
    ]);
    $response->assertStatus(200); // Vérifie que le statut de la réponse est 200 OK
    $response->assertJson([
        'data' => [
            'id' => $StudentId,
            'title' => 'Titre mis à jour',
            'content' => 'Contenu mis à jour.'
        ]
    ]);

    // Supprimer le Student
    $response = $this->deleteJson("/api/v1/Students/{$StudentId}");
    $response->assertStatus(204);

    // Vérifier que le Student a bien été supprimé
    $this->getJson("/api/v1/Students/{$StudentId}")
        ->assertStatus(404); // Vérifie que le statut de la réponse est 404 Not Found
});
