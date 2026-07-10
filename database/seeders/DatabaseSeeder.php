<?php

namespace Database\Seeders;

use App\Models\Prestation;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Remplit la base avec des comptes et un catalogue de démonstration.
     */
    public function run(): void
    {
        /*
        |----------------------------------------------------------------------
        | Comptes de démonstration (un par rôle)
        |----------------------------------------------------------------------
        | Mot de passe pour tous : "password"
        */
        User::updateOrCreate(
            ['email' => 'admin@ninich.test'],
            [
                'name'     => 'Admin Ninich',
                'password' => Hash::make('password'),
                'role'     => 'admin',
            ]
        );

        $prestataires = [
            ['name' => 'Sara Bennani',  'email' => 'sara@ninich.test',  'bio' => 'Spécialiste manucure & nail art'],
            ['name' => 'Imane El Idrissi', 'email' => 'imane@ninich.test', 'bio' => 'Soins du visage & maquillage'],
        ];

        foreach ($prestataires as $p) {
            User::updateOrCreate(
                ['email' => $p['email']],
                [
                    'name'     => $p['name'],
                    'password' => Hash::make('password'),
                    'role'     => 'prestataire',
                    'bio'      => $p['bio'],
                ]
            );
        }


        User::updateOrCreate(
            ['email' => 'cliente@ninich.test'],
            [
                'name'     => 'Client Démo',
                'password' => Hash::make('password'),
                'role'     => 'client',
            ]
        );

        /*
        |----------------------------------------------------------------------
        | Catalogue de prestations
        |----------------------------------------------------------------------
        */
        $img = fn (string $id) => "https://images.unsplash.com/{$id}?w=800&q=80&auto=format&fit=crop";

        $prestations = [
            ['nom' => 'Manucure simple',     'prix' => 120.00, 'duree' => 30, 'description' => 'Soin des ongles, limage et vernis classique.',        'image' => $img('photo-1604654894610-df63bc536371')],
            ['nom' => 'Manucure gel',        'prix' => 250.00, 'duree' => 60, 'description' => 'Pose de vernis semi-permanent longue tenue.',          'image' => $img('photo-1610992015732-2449b76344bc')],
            ['nom' => 'Pédicure complète',   'prix' => 200.00, 'duree' => 60, 'description' => 'Soin complet des pieds avec gommage.',                 'image' => $img('photo-1519014816548-bf5fe059798b')],
            ['nom' => 'Soin du visage',      'prix' => 350.00, 'duree' => 75, 'description' => 'Nettoyage, gommage et masque hydratant.',              'image' => $img('photo-1570172619644-dfd03ed5d881')],
            ['nom' => 'Maquillage soirée',   'prix' => 300.00, 'duree' => 45, 'description' => 'Maquillage professionnel pour vos événements.',        'image' => $img('photo-1487412720507-e7ab37603c6f')],
            ['nom' => 'Épilation sourcils',  'prix' => 80.00,  'duree' => 20, 'description' => 'Mise en forme des sourcils à la cire ou au fil.',      'image' => $img('photo-1512496015851-a90fb38ba796')],
        ];

        foreach ($prestations as $p) {
            Prestation::updateOrCreate(['nom' => $p['nom']], $p + ['active' => true]);
        }
    }
}
