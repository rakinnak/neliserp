<?php

namespace App\Http\Controllers;

use Route;
use Illuminate\Http\Request;
use App\Doc;
use \Elibyy\TCPDF\TCPDF;
use GuzzleHttp;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Style;

class PrintController extends Controller
{
    public function preview(Request $request_a, $type, $uuid)
    {
        return view('print.print', compact('type', 'uuid'));
    }

    // WIP: to be refactor. move pdf page formatting to separate class
    public function pdf($type, $uuid)
    {
        // WIP: To be updated to call API
        // $url =  "http://127.0.0.1:8000/api/docs/so/6dc0aab6-79b0-486b-8f11-cc31924464eb?aaa=CH1asCMkEUAD3QupQCmPOJYApcqFM0kkt09VsXyJ4zVy4Mg6eMCLKLTQ3MC3";

        // // $url = route('api.docs.show', ['type' => $type, 'uuid' => $uuid]);

        // Store the original input of the request
        // $originalInput = Request::input();
        // $request = Request::create($url, 'GET');
        // , array(

        //     ));
        // $response = Route::dispatch($request)->getContent();
        // $res = json_decode($response);
        // $doc = $res->data;

        $doc = Doc::where('uuid', $uuid)
            ->first()
            ->load('doc_items');

        // get pwd template
        // $template = $doc->getDocTemplate();
        $template = [
            'body' => 'print.'.$doc->type.'_body',
            'header' => 'print.'.$doc->type.'_header',
            'footer' => 'print.'.$doc->type.'_footer'
        ];

        // render html
        $view = \View::make($template['body'], compact('type', 'uuid', 'doc'));
        $html_body = $view->render();
        $html_body .= '<style>'.file_get_contents('css/print.css').'</style>';

        $view = \View::make($template['header'], compact('type', 'uuid', 'doc'));
        $html_header = $view->render();

        $view = \View::make($template['footer'], compact('type', 'uuid', 'doc'));
        $html_footer = $view->render();

        // create new PDF document
        $pdf = new TCPDF('');

        // set document information
        $pdf->SetTitle($doc->type.'-'.$doc->name);
        $pdf->SetSubject('Document: '. $doc->type.'-'.$doc->name); // to be description in pdf
        $pdf->SetKeywords('Nelisys, Document');

        $pdf->SetFont(PDF_FONT_NAME_MAIN, '', 14);
        $pdf = $this->set_header($pdf, $html_header);
        $pdf = $this->set_footer($pdf, $html_footer);

        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $pdf->AddPage();

        $pdf->writeHTML($html_body, true, false, false, false, '');

        // Output PDF document
        $pdf->Output($doc->type.'-'.$doc->name.'pdf', 'I');

        return 1;
    }

    public function set_header($pdf, $html_header)
    {
        // $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, $html_header, array(0,0,0), array(0,64,128));
        $pdf->SetHeaderFont(Array(PDF_FONT_NAME_MAIN, '',14));

        define('PDF_HEADER_HTML', $html_header);

        $pdf->setHeaderCallback(function($pdf){
            // $data = $pdf->getHeaderData();
            // $html = $data['string'];

            $pdf->writeHTMLCell(
                $w = 0, $h = 0, $x = '', $y = '',
                PDF_HEADER_HTML, $border = 0, $ln = 1, $fill = 0,
                $reseth = true, $align = 'top', $autopadding = true);
        });

        return $pdf;
    }

    public function set_footer($pdf, $html_footer)
    {
        $pdf->SetFooterFont(Array(PDF_FONT_NAME_MAIN, '',14));

        define('PDF_FOOTER_HTML', $html_footer);

        $pdf->setFooterCallback(function($pdf){

            $pdf->writeHTMLCell(
                $w = 0, $h = 0, $x = '', $y = '',
                PDF_FOOTER_HTML, $border = 0, $ln = 1, $fill = 0,
                $reseth = true, $align = 'top', $autopadding = true);
        });

        return $pdf;
    }

    public function speadsheet($type, $uuid){

        // WIP: To change to get from API
        $doc = Doc::where('uuid', $uuid)
            ->first()
            ->load('doc_items');

        // Get template file name
        $template = resource_path() . '/views/print/' . $doc->type . '_speadsheet.xlsx';

        // Set output filename
        // WIP: To update how we get path name
        $output_path = resource_path() . '/views/print/';
        $output_filename = $doc->type . '-' .  $doc->name . '.xlsx';

        // Read Template file
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($template);
        $worksheet = $spreadsheet->getActiveSheet();

        // Set worksheet Style
        $worksheet->setShowGridlines(false);

        // Assign Data to Template
        // WIP: to update more data into template
        $worksheet->setCellValue('J4', $doc->name);
        $worksheet->setCellValue('J5', $doc->issued_at);
        $worksheet->setCellValue('D8', $doc->partner_name);
        $worksheet->setCellValue('H8', $doc->partner_name);

        // WIP: first column should be line_number or we regenerate?
        // What will happen to line_number when some line already move to next stage
        $baseRow = 17;
        $row = 0;

        foreach ($doc->doc_items as $r => $doc_item) {
            $row = $baseRow + $r;
            $worksheet->insertNewRowBefore($row, 1);

            $worksheet
                ->setCellValue('B'.$row, $r + 1)
                ->setCellValue('C'.$row, $doc_item['item_code'])
                ->setCellValue('E'.$row, $doc_item['item_name'])
                ->setCellValue('I'.$row, $doc_item['quantity'])
                ->setCellValue('J'.$row, $doc_item['unit_price'])
                ->setCellValue('K'.$row, '=I'.$row.'*J'.$row);

            // Merge Cell
            $worksheet->mergeCells('C'.$row.':D'.$row);
            $worksheet->mergeCells('E'.$row.':H'.$row);

            // Copy Style
            for ($col = 1; $col <= 50; ++$col) {
                $style = $worksheet->getStyleByColumnAndRow($col, 17);
                $coord = Coordinate::stringFromColumnIndex($col).(string) ($row); // Description
                $worksheet->duplicateStyle($style, $coord);
            }
        }


        $worksheet->removeRow($baseRow - 1, 1);

        $row = $row + 1;

        $worksheet
            ->setCellValue('K' . $row, '1000') // Sub Total
            ->setCellValue('K' . ($row + 1), '70') // VAT Total
            ->setCellValue('K' . ($row + 2), '1070'); // Total


        // Write Template file
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        // Save File
        // $writer->save($output_path.$output_filename);

        // Redirect output to client browser
        header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")                 ;
        header("Content-Disposition: inline; filename=".$output_filename);
        header("Cache-Control: max-age=1");
        header("cache-control:just-revalidate,post-check:0, pre-check:0");
        header("Pragma: public");
        $writer->save('php://output');


    }
}
