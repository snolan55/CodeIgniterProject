<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class Pdf extends TCPDF
{
    function __construct()
    {
        parent::__construct();
    }
    public function Header(){
      $this->SetFont('helvetica', 'B', 20);
       // Title
       $this->Cell(0, 15, 'Patient Summary', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }
    public function ColoredTable($header,$data) {
        // Colors, line width and bold font
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(0.3);
        $this->SetFont('helvetica', 'B');
        // Header
        $w = array(25, 50, 25, 25, 25, 25);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = 0;

        foreach($data as $row) {
            $this->Cell($w[0], 6, number_format($row['activityMetricsId']), 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, number_format($row['activityMetricsInterventionSessionId']), 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, number_format($row['activityMetricsActivityId']), 'LR', 0, 'L', $fill);
            $this->Cell($w[3], 6, number_format($row['activityAttempt']), 'LR', 0, 'L', $fill);
            $this->Cell($w[4], 6, number_format($row['activityTime']), 'LR', 0, 'L', $fill);
            $this->Cell($w[5], 6, number_format($row['activityScore']), 'LR', 0, 'L', $fill);
            $this->Ln();
            $fill=!$fill;
        }
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}
