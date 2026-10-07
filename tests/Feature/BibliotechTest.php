<?php

namespace Tests\Feature;

use App\Models\Adherent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BibliotechTest extends TestCase
{
    use RefreshDatabase;

    public function test_pages_publiques_et_protegees()
    {
        $this->get('/login')->assertStatus(200);
        $this->get('/dashboard')->assertRedirect('/login');
        $this->get('/livres')->assertRedirect('/login');
        $this->get('/adherents')->assertRedirect('/login');
        $this->get('/emprunts')->assertRedirect('/login');
    }

    public function test_pages_connecte()
    {
        $this->seed();
        $user = User::where('email', 'bibliothecaire@example.com')->first();
        $this->actingAs($user);

        $this->get('/dashboard')->assertStatus(200);
        $this->get('/livres')->assertStatus(200);
        $this->get('/livres/create')->assertStatus(200);
        $this->get('/adherents')->assertStatus(200);
        $this->get('/adherents/create')->assertStatus(200);
        $this->get('/emprunts')->assertStatus(200);
        $this->get('/emprunts/create')->assertStatus(200);
        $this->get('/emprunts/csv')->assertStatus(200);
    }

    public function test_fiche_adherent()
    {
        $this->seed();
        $user = User::where('email', 'bibliothecaire@example.com')->first();
        $this->actingAs($user);

        $adherent = Adherent::first();
        $this->get('/adherents/' . $adherent->id)->assertStatus(200);
    }

    public function test_scenario_emprunt_retour()
    {
        $this->seed();
        $user = User::where('email', 'bibliothecaire@example.com')->first();
        $this->actingAs($user);

        $this->post('/livres', [
            'titre' => 'Livre Scenario',
            'auteur' => 'Auteur Scenario',
            'isbn' => 'SCEN-001',
            'categorie' => 'Test',
            'annee' => 2024,
            'quantite_totale' => 2,
        ])->assertRedirect('/livres');

        $this->post('/adherents', [
            'nom' => 'NomScenario',
            'prenom' => 'PrenomScenario',
            'email' => 'scenario@example.com',
        ])->assertRedirect('/adherents');

        $livre = \App\Models\Livre::where('isbn', 'SCEN-001')->first();
        $adherent = Adherent::where('email', 'scenario@example.com')->first();
        $this->assertEquals(2, $livre->quantite_disponible);

        $this->post('/emprunts', [
            'livre_id' => $livre->id,
            'adherent_id' => $adherent->id,
            'date_emprunt' => now()->toDateString(),
            'date_retour_prevue' => now()->addDays(14)->toDateString(),
        ])->assertRedirect('/emprunts');

        $livre->refresh();
        $this->assertEquals(1, $livre->quantite_disponible);

        $emprunt = \App\Models\Emprunt::where('livre_id', $livre->id)->where('adherent_id', $adherent->id)->first();

        $this->put('/emprunts/' . $emprunt->id . '/retour', [
            'date_retour_effective' => now()->toDateString(),
        ])->assertRedirect('/emprunts');

        $livre->refresh();
        $this->assertEquals(2, $livre->quantite_disponible);
    }

    public function test_emprunt_bloque_sans_stock()
    {
        $this->seed();
        $user = User::where('email', 'bibliothecaire@example.com')->first();
        $this->actingAs($user);

        $livre = \App\Models\Livre::create([
            'titre' => 'Vide',
            'auteur' => 'Auteur',
            'isbn' => 'VIDE-001',
            'quantite_totale' => 0,
            'quantite_disponible' => 0,
        ]);
        $adherent = Adherent::where('email', 'lucas.petit@example.com')->first();

        $reponse = $this->post('/emprunts', [
            'livre_id' => $livre->id,
            'adherent_id' => $adherent->id,
            'date_emprunt' => now()->toDateString(),
            'date_retour_prevue' => now()->addDays(14)->toDateString(),
        ]);
        $reponse->assertSessionHas('error');
    }

    public function test_emprunt_bloque_si_retard()
    {
        $this->seed();
        $user = User::where('email', 'bibliothecaire@example.com')->first();
        $this->actingAs($user);

        $adherent = Adherent::where('email', 'atif.rakoto@example.com')->first();
        $livre = \App\Models\Livre::where('quantite_disponible', '>', 0)->where('isbn', '!=', '978-2-0814-0000-0')->first();

        $reponse = $this->post('/emprunts', [
            'livre_id' => $livre->id,
            'adherent_id' => $adherent->id,
            'date_emprunt' => now()->toDateString(),
            'date_retour_prevue' => now()->addDays(14)->toDateString(),
        ]);
        $reponse->assertSessionHas('error');
    }
}
