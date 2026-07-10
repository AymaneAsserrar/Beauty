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
        $prestations = [
            ['nom' => 'Manucure simple',     'prix' => 120.00, 'duree' => 30, 'description' => 'Soin des ongles, limage et vernis classique.'],
            ['nom' => 'Manucure gel',        'prix' => 250.00, 'duree' => 60, 'description' => 'Pose de vernis semi-permanent longue tenue.'],
            ['nom' => 'Pédicure complète',   'prix' => 200.00, 'duree' => 60, 'description' => 'Soin complet des pieds avec gommage.'],
            ['nom' => 'Soin du visage',      'prix' => 350.00, 'duree' => 75, 'description' => 'Nettoyage, gommage et masque hydratant.'],
            ['nom' => 'Maquillage soirée',   'prix' => 300.00, 'duree' => 45, 'description' => 'Maquillage professionnel pour vos événements.'],
            ['nom' => 'Épilation sourcils',  'prix' => 80.00,  'duree' => 20, 'description' => 'Mise en forme des sourcils à la cire ou au fil.'],
        ];

        foreach ($prestations as $p) {
            Prestation::updateOrCreate(['nom' => $p['nom']], $p + ['active' => true]);
        }
    }
}
