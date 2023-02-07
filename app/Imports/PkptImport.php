<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use App\Models\Pkpt;

class PkptImport implements ToModel, WithStartRow, WithCalculatedFormulas
{

    private $tahun;
    private $jenis;

    public function __construct(int $tahun,  $jenis)
    {
        $this->tahun = $tahun;
        $this->jenis = $jenis;
    }

    public function model(array $row)
    {

        if ($row[0] > 0) {
            return Pkpt::updateOrCreate(
                [
                    'jenis' => $this->jenis,
                    'tahun' => $this->tahun,
                    'area_pengawasan' => $row[1],
                ],
                [
                    'jenis_pengawasan' => $row[2],
                    'tujuan' => $row[3],
                    'opd' => $row[4],
                    'rmp' => $row[5],
                    'rpl' => $row[6],
                    'koorwas' => $row[7],
                    'pt' => $row[8],
                    'kt' => $row[9],
                    'at' => $row[10],
                    'jumlah' => $row[11],
                    'jumlah_laporan' => $row[12],
                    'kategori' => $row[13],
                    'sarana_prasarana' => $row[14],
                    'tingkat_resiko' => $row[15],
                    'keterangan' => $row[16],
                ],
            );
        }
    }

    public function startRow(): int
    {
        return 3;
    }
}
