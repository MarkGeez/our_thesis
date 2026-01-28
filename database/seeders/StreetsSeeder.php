<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Houses;
use Illuminate\Support\Facades\DB;



class StreetsSeeder extends Seeder
{
    public function run(): void
    {
        $data = [

            /* =======================
             * ALMEDA ST.
             * ======================= */
            'Almeda St.' => [
                '1833A','1833B','1833C','1833D','1833E','1833F','1833G',
                '1833H','1833I','1833J','1833K','1833L','1833M',

                '1841','1843','1847',
                '1849A','1849B',
                '1853','1855','1857','1859','1861',
                '1829','1827','1825','1815',
                '1807A','1807B','1807C',
                '1801A','1801B',
                '1868',
            ],

            /* =======================
             * BIAK NA BATO ST.
             * ======================= */
            'Biak Na Bato St.' => [
                '1801','1809',
                '1808A','1808B','1808C',
                '1816','1815','1819','1826','1821','1823','1827','1825','1828',
                '1826A','1826B','1826C',
                '1830',
                '1838A','1838B','1838C',
                '1841',
                '1842A','1842B','1842C','1842D',
                '1844A','1844B','1844C','1844D','1844E','1844F',
                '1845A','1845B','1845C',
                '1846A','1846B',
                '1848A','1848B',
                '1850A','1850B',
                '1852A','1852B',
                '1854A','1854B',
                '1851A',
                '1855',
                '1844A','1844B','1844C',
                '1856A',
                '1858',
                '1862','1861','1867','1869',
                '1871','1873',
                '1879A','1879B',
                '1880A','1880B','1880C',
                '1883','1885','1887',
                '1865A',
            ],

            /* =======================
             * VILLARUEL ST.
             * ======================= */
            'Villaruel St.' => [
                '1221','1217','1215','1213','1211',
                '1207A','1207B',
                '1818','1820',
            ],

            /* =======================
             * ABAD SANTOS ST.
             * ======================= */
            'Abad Santos St.' => [
                '1822','1826','1828','1830','1832',
                '1854A','1854B','1854C',
                '1860','1870',
            ],

            /* =======================
             * TAYUMAN ST.
             * ======================= */
            'Tayuman St.' => [
                '1200',
                '1206A',
                '1210','1214',
                '1232','1234',
            ],
        ];

        foreach ($data as $streetName => $houses) {

            $streetId = DB::table('streets')->insertGetId([
                'street_name' => $streetName,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $rows = [];

            foreach ($houses as $houseNo) {
                $rows[] = [
                    'street_id' => $streetId,
                    'house_no' => $houseNo,
                    'property_type' => 'residential',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            DB::table('houses')->insert($rows);
        }
    }
}


