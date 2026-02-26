<?php

namespace Database\Seeders;

use App\Models\KyarComUnitFix;
use Illuminate\Database\Seeder;

class KyarComUnitFixSeeder extends Seeder
{
    public function run(): void
    {
        $data = [

            ['tractor_name' => 'SF UNIT', 'set_hitam' => 14, 'set_merah' => 0, 'hood_merah' => 0, 'set_biru' => 3, 'hood_biru' => 0, 'set_grey' => 0],
            ['tractor_name' => 'MF1E35', 'set_hitam' => 6, 'set_merah' => 4, 'hood_merah' => 2, 'set_biru' => 0, 'hood_biru' => 0, 'set_grey' => 1],
            ['tractor_name' => 'MF1E25', 'set_hitam' => 5, 'set_merah' => 4, 'hood_merah' => 2, 'set_biru' => 0, 'hood_biru' => 0, 'set_grey' => 1],
            ['tractor_name' => 'MF2E', 'set_hitam' => 8, 'set_merah' => 4, 'hood_merah' => 2, 'set_biru' => 0, 'hood_biru' => 0, 'set_grey' => 1],
            ['tractor_name' => 'SXG2', 'set_hitam' => 7, 'set_merah' => 0, 'hood_merah' => 0, 'set_biru' => 2, 'hood_biru' => 2, 'set_grey' => 0],
            ['tractor_name' => 'NT DAI', 'set_hitam' => 7, 'set_merah' => 0, 'hood_merah' => 0, 'set_biru' => 7, 'hood_biru' => 0, 'set_grey' => 0],
            ['tractor_name' => 'SXG3', 'set_hitam' => 8, 'set_merah' => 0, 'hood_merah' => 0, 'set_biru' => 2, 'hood_biru' => 2, 'set_grey' => 0],
            ['tractor_name' => 'TLE3410', 'set_hitam' => 9, 'set_merah' => 0, 'hood_merah' => 0, 'set_biru' => 6, 'hood_biru' => 0, 'set_grey' => 0],
            ['tractor_name' => 'NT540', 'set_hitam' => 5, 'set_merah' => 0, 'hood_merah' => 0, 'set_biru' => 7, 'hood_biru' => 0, 'set_grey' => 0],
            ['tractor_name' => 'TXGS', 'set_hitam' => 6, 'set_merah' => 0, 'hood_merah' => 0, 'set_biru' => 1, 'hood_biru' => 2, 'set_grey' => 1],
            ['tractor_name' => 'TLE455 (NON A)', 'set_hitam' => 11, 'set_merah' => 0, 'hood_merah' => 0, 'set_biru' => 7, 'hood_biru' => 0, 'set_grey' => 0],
            ['tractor_name' => 'TLE455 (A)', 'set_hitam' => 12, 'set_merah' => 0, 'hood_merah' => 0, 'set_biru' => 7, 'hood_biru' => 0, 'set_grey' => 0],
            ['tractor_name' => 'MOKOL (H)', 'set_hitam' => 11, 'set_merah' => 0, 'hood_merah' => 0, 'set_biru' => 1, 'hood_biru' => 2, 'set_grey' => 0],
            ['tractor_name' => 'MOKOL (L)', 'set_hitam' => 9, 'set_merah' => 0, 'hood_merah' => 0, 'set_biru' => 1, 'hood_biru' => 2, 'set_grey' => 0],
            ['tractor_name' => 'MOKOL SXG2', 'set_hitam' => 4, 'set_merah' => 0, 'hood_merah' => 0, 'set_biru' => 0, 'hood_biru' => 2, 'set_grey' => 0],
            ['tractor_name' => 'MOKOL SUSXG', 'set_hitam' => 7, 'set_merah' => 0, 'hood_merah' => 0, 'set_biru' => 0, 'hood_biru' => 2, 'set_grey' => 0],
            ['tractor_name' => 'MF1741', 'set_hitam' => 9, 'set_merah' => 4, 'hood_merah' => 2, 'set_biru' => 0, 'hood_biru' => 0, 'set_grey' => 1],
            ['tractor_name' => 'SUSXG', 'set_hitam' => 6, 'set_merah' => 2, 'hood_merah' => 2, 'set_biru' => 0, 'hood_biru' => 0, 'set_grey' => 0],
            ['tractor_name' => 'MF1756', 'set_hitam' => 13, 'set_merah' => 5, 'hood_merah' => 2, 'set_biru' => 0, 'hood_biru' => 0, 'set_grey' => 1],
            ['tractor_name' => 'MFGC 1 UNIT', 'set_hitam' => 4, 'set_merah' => 1, 'hood_merah' => 2, 'set_biru' => 0, 'hood_biru' => 0, 'set_grey' => 2],
            ['tractor_name' => 'MFGC 2 UNIT', 'set_hitam' => 8, 'set_merah' => 1, 'hood_merah' => 4, 'set_biru' => 0, 'hood_biru' => 0, 'set_grey' => 3],
            ['tractor_name' => 'MF1640', 'set_hitam' => 5, 'set_merah' => 7, 'hood_merah' => 0, 'set_biru' => 0, 'hood_biru' => 0, 'set_grey' => 1],
            ['tractor_name' => 'MF1650', 'set_hitam' => 7, 'set_merah' => 7, 'hood_merah' => 0, 'set_biru' => 0, 'hood_biru' => 0, 'set_grey' => 1],
            ['tractor_name' => 'MOWER SF', 'set_hitam' => 4, 'set_merah' => 1, 'hood_merah' => 0, 'set_biru' => 1, 'hood_biru' => 2, 'set_grey' => 0],
            ['tractor_name' => 'MOWER SXG3', 'set_hitam' => 1, 'set_merah' => 0, 'hood_merah' => 0, 'set_biru' => 1, 'hood_biru' => 2, 'set_grey' => 0],
            ['tractor_name' => 'COLECTOR SXG3', 'set_hitam' => 9, 'set_merah' => 0, 'hood_merah' => 0, 'set_biru' => 0, 'hood_biru' => 0, 'set_grey' => 0],
            ['tractor_name' => 'MOWER SXG2', 'set_hitam' => 2, 'set_merah' => 0, 'hood_merah' => 0, 'set_biru' => 1, 'hood_biru' => 2, 'set_grey' => 0],
            ['tractor_name' => 'COLLETOR SXG2', 'set_hitam' => 4, 'set_merah' => 0, 'hood_merah' => 0, 'set_biru' => 0, 'hood_biru' => 0, 'set_grey' => 0],
            ['tractor_name' => 'COLL SF', 'set_hitam' => 3, 'set_merah' => 1, 'hood_merah' => 0, 'set_biru' => 1, 'hood_biru' => 2, 'set_grey' => 0],
            ['tractor_name' => 'UNIT SF', 'set_hitam' => 14, 'set_merah' => 0, 'hood_merah' => 0, 'set_biru' => 3, 'hood_biru' => 0, 'set_grey' => 0],

        ];

        foreach ($data as $item) {
            KyarComUnitFix::updateOrCreate(
                ['tractor_name' => $item['tractor_name']],
                $item
            );
        }
    }
}
