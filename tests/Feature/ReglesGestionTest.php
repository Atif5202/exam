<?php

namespace Tests\Feature;

use App\Models\Adherent;
use App\Models\Emprunt;
use App\Models\Livre;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReglesGestionTest extends TestCase
{
    use RefreshDatabase;

    private function login()
    {
        $this->seed();
        $this->actingAs(User::where('email', 'bibliothecaire@example.com')->first());
    }

    public function test_r3_max_3_emprunts()
    {
        $this->login();
        $adherent = Adherent::where('email', 'lucas.petit@example.com')->first();
        $livres = Livre::where('quantite_disponible', '>', 0)->take(4)->get();
        for ($i = 0; $i < 3; $i++) {
            $this->post('/emprunts', [
                'livre_id' => $livres[$i]->id,
                'adherent_id' => $adherent->id,
                'date_emprunt' => now()->toDateString(),
                'date_retour_prevue' => now()->addDays(14)->toDateString(),
            ])->assertRedirect('/emprunts');
        }
        $reponse = $this->post('/emprunts', [
            'livre_id' => $livres[3]->id,
            'adherent_id' => $adherent->id,
            'date_emprunt' => now()->toDateString(),
            'date_retour_prevue' => now()->addDays(14)->toDateString(),
        ]);
        $reponse->assertSessionHas('error');
    }

    public function test_r5_suppression_bloquee()
    {
        $this->login();
        $livre = Livre::where('isbn', '978-2-0814-0000-0')->first();
        $this->delete('/livres/' . $livre->id)->assertSessionHas('error');
        $this->assertDatabaseHas('livres', ['id' => $livre->id]);
        $adherent = Adherent::where('email', 'atif.rakoto@example.com')->first();
        $this->delete('/adherents/' . $adherent->id)->assertSessionHas('error');
        $this->assertDatabaseHas('adherents', ['id' => $adherent->id]);
        $livreLibre = Livre::create(['titre' => 'X', 'auteur' => 'Y', 'isbn' => 'SUP-1', 'quantite_totale' => 1]);
        $this->delete('/livres/' . $livreLibre->id)->assertSessionHas('success');
        $this->assertDatabaseMissing('livres', ['id' => $livreLibre->id]);
    }

    public function test_r6_quantite_totale_bloquee()
    {
        $this->login();
        $livre = Livre::where('isbn', '978-2-0814-0000-0')->first();
        $reponse = $this->put('/livres/' . $livre->id, [
            'titre' => $livre->titre,
            'auteur' => $livre->auteur,
            'isbn' => $livre->isbn,
            'quantite_totale' => 0,
        ]);
        $reponse->assertSessionHas('error');
        $livre->refresh();
        $this->assertEquals(3, $livre->quantite_totale);
    }

    public function test_f3_validations()
    {
        $this->login();
        $this->post('/livres', [])->assertSessionHasErrors(['titre', 'auteur', 'isbn', 'quantite_totale']);
        $this->post('/livres', [
            'titre' => 'T', 'auteur' => 'A', 'isbn' => '978-2-0814-0000-0', 'quantite_totale' => 1,
        ])->assertSessionHasErrors(['isbn']);
        $this->post('/livres', [
            'titre' => 'T', 'auteur' => 'A', 'isbn' => 'NEG-1', 'quantite_totale' => -1,
        ])->assertSessionHasErrors(['quantite_totale']);
        $this->post('/adherents', ['nom' => '', 'prenom' => '', 'email' => 'pas-un-email'])
            ->assertSessionHasErrors(['nom', 'prenom', 'email']);
        $this->post('/adherents', [
            'nom' => 'N', 'prenom' => 'P', 'email' => 'atif.rakoto@example.com',
        ])->assertSessionHasErrors(['email']);
        $reponse = $this->get('/livres/999999/edit');
        $this->assertEquals(404, $reponse->status());
    }

    public function test_r2_stock_baisse_et_remonte()
    {
        $this->login();
        $livre = Livre::create(['titre' => 'S', 'auteur' => 'A', 'isbn' => 'STK-1', 'quantite_totale' => 1, 'quantite_disponible' => 1]);
        $adherent = Adherent::where('email', 'lucas.petit@example.com')->first();
        $this->assertEquals(1, $livre->quantite_disponible);
        $this->post('/emprunts', [
            'livre_id' => $livre->id,
            'adherent_id' => $adherent->id,
            'date_emprunt' => now()->toDateString(),
            'date_retour_prevue' => now()->addDays(14)->toDateString(),
        ])->assertRedirect('/emprunts');
        $this->assertEquals(0, $livre->fresh()->quantite_disponible);
        $emprunt = Emprunt::where('livre_id', $livre->id)->first();
        $this->put('/emprunts/' . $emprunt->id . '/retour', [
            'date_retour_effective' => now()->toDateString(),
        ])->assertRedirect('/emprunts');
        $this->assertEquals(1, $livre->fresh()->quantite_disponible);
    }
}
