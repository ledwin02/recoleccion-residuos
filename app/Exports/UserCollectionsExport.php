<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserCollectionsExport implements FromCollection, WithHeadings, WithMapping
{
    protected Collection $collections;

    /**
     * Constructor para inicializar la colección a exportar.
     *
     * @param Collection $collections
     */
    public function __construct(Collection $collections)
    {
        $this->collections = $collections;
    }

    /**
     * Define las cabeceras de las columnas del archivo Excel.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID de Recolección',
            'Nombre del Usuario',
            'Fecha de Recolección',
            'Tipo de Residuo',
            'Cantidad',
            'Estado',
        ];
    }

    /**
     * Mapea cada registro de la colección a una fila del Excel.
     *
     * @param mixed $collection
     * @return array
     */
    public function map($collection): array
    {
        return [
            $collection->id ?? 'N/A',
            optional($collection->user)->name ?? 'No asignado',
            $this->formatDate($collection->date),
            $collection->waste_type ?? 'No especificado',
            $collection->amount ?? '0',
            ucfirst($collection->status ?? 'pendiente'),
        ];
    }

    /**
     * Devuelve la colección a exportar.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection(): Collection
    {
        return $this->collections;
    }

    /**
     * Formatea la fecha si es válida.
     *
     * @param mixed $date
     * @return string
     */
    protected function formatDate($date): string
    {
        try {
            return Carbon::parse($date)->format('d/m/Y');
        } catch (\Exception $e) {
            return 'Fecha inválida';
        }
    }
}
