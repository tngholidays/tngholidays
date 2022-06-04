<?php
namespace Modules\Lead\Exports;


use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;

class LeadExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents {
	use Exportable, RegistersEventListeners;
	private $data;

    public function __construct($data) {
        $this->data = $data;
    }
	public function headings(): array {
        return [];
    }
    public function registerEvents(): array
    {
        $firstRow = [
            'font' => [
                'bold' => true,
                'size' => 16
            ]
        ];
        $secondRow = [
            'font' => [
                'bold' => true,
                'size' => 12
            ]
        ];
        return [
            BeforeExport::class => function(BeforeExport $event) {
                $event->writer->getProperties()->setCreator('Sistema de alquileres');
            },
            AfterSheet::class => function(AfterSheet $event) use ($firstRow, $secondRow){
                $rowcol_1 = $event->sheet->getHighestColumn().'1';
                $rowcol_2 = $event->sheet->getHighestColumn().'2';
                $last_rowcol = $event->sheet->getHighestColumn().$event->sheet->getHighestRow();
                $event->sheet->getDelegate()->mergeCells("A1:$rowcol_1");
                $event->sheet->getStyle("A1:G1")->applyFromArray($firstRow);
                $event->sheet->getStyle("A2:{$rowcol_2}")->applyFromArray($secondRow);
                // $event->sheet->setCellValue('A'. ($event->sheet->getHighestRow()+1),"Total");
                
                // $event->sheet->getDelegate()->mergeCells("A{$event->sheet->getHighestRow()}:F{$event->sheet->getHighestRow()}");
            
            }
        ];
    }
	
	public function collection() {
        return collect($this->data);
    }
}