<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['utilisateur_id' => 1, 'type_paiement' => 'gold', 'montant' => 50000, 'created_at' => '2025-11-20'],
            ['utilisateur_id' => 2, 'type_paiement' => 'regime', 'montant' => 120000, 'created_at' => '2025-12-05'],
            ['utilisateur_id' => 3, 'type_paiement' => 'recharge', 'montant' => 15000, 'created_at' => '2026-01-10'],
            ['utilisateur_id' => 4, 'type_paiement' => 'gold', 'montant' => 50000, 'created_at' => '2026-02-15'],
            ['utilisateur_id' => 5, 'type_paiement' => 'regime', 'montant' => 150000, 'created_at' => '2026-03-25'],
            ['utilisateur_id' => 1, 'type_paiement' => 'regime', 'montant' => 100000, 'created_at' => '2026-04-10'],
            ['utilisateur_id' => 2, 'type_paiement' => 'recharge', 'montant' => 30000, 'created_at' => '2026-05-02'],
        ];

        // Check if empty before inserting
        if ($this->db->table('paiements')->countAll() == 0) {
            $this->db->table('paiements')->insertBatch($data);
        }
    }
}
