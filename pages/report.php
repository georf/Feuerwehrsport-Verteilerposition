<?php

require_once('classes/tcpdf/tcpdf.php');

// Extend the TCPDF class to create custom Header and Footer
class Report extends TCPDF {
	protected $eventId;
	protected $event;
	protected $cacheDir;

	public function __construct($team, $list) {
		$this->team  = $team;
		$this->list = $list;

		parent::__construct(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	}


	// Page header
	public function Header() {

		// Position at 15 mm from top
		$this->SetY(3);
		$this->SetX(44);
		// Set font
		$this->SetFont('freemono', '', 8);
		// Page number
		$this->Cell(0, 10,
		'Bahnmitte',
		0, false, 'C', 0, '', 0, false, 'T', 'M');
	}

	// Page footer
	public function Footer() {
		// Position at 15 mm from top
		$this->SetY(-15);
		// Set font
		$this->SetFont('freemono', '', 8);
		// Page number
		$this->Cell(0, 10,
		sprintf('Seite %s/%s', $this->getAliasNumPage(), $this->getAliasNbPages()),
		0, false, 'C', 0, '', 0, false, 'T', 'M');
	}


	protected function putInformation() {
		global $l;

		// set JPEG quality
		$this->setJPEGQuality(100);

		// set document information
		$this->SetCreator('MGVmedia - Feuerwehrsport - Team MV');
		$this->SetAuthor('Feuerwehrsport - Team MV');
		$this->SetTitle(sprintf(_('Verteiler für %s'), $this->team));

		// set default monospaced font
		$this->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		//set margins
		//$this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		//$this->SetHeaderMargin(PDF_MARGIN_HEADER);
		$this->SetFooterMargin(PDF_MARGIN_FOOTER);

		//set auto page breaks
		$this->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		//set image scale factor
		$this->setImageScale(PDF_IMAGE_SCALE_RATIO);

		//set some language-dependent strings
		$this->setLanguageArray($l);
	}

	public function generate($filename = false, $toBrowser = false) {

		$this->putInformation();

		$this->AddPage();


		for($i = 0; $i < count($this->list); $i++) {
			$row = $this->list[$i];

			if ($i%10 == 0) {
				if ($i != 0) {
					$html .= '</table>';
					$this->writeHtml($html);
					$this->addPage();
				}

				$html = '
		<style>
td{
border-top:1px solid grey;
border-bottom:1px solid grey;
}
.info{
    width:220px;
}
.name{
    font-size:56px;
}
.comment{
    font-size:40px;
    font-style:italic;
}
.cm, .degree{
    width:30px;
    font-size:30px;
}
.verteiler1{
width:180px;
height:90px;
border-left:3px solid #E6E6FA;
border-right:2px dotted #E6E6FA;
}
.verteiler2{
width:180px;
height:90px;
border-right:3px solid #E6E6FA;
}
		</style><table>';
			}

			$html.= '<tr>
				<td class="info">
					<span class="name">'.htmlspecialchars($row['name']).'</span><br/>
                    <span class="comment">'.htmlspecialchars($row['comment']).'</span><br/>
					<span class="degree">'.$row['degree'].'</span>
					<span class="cm">'.$row['cm'].'</span>
				</td>
				<td class="verteiler1"></td>
				<td class="verteiler2"></td>
			</tr>';
		}

		$html .= '</table>';

		$this->writeHtml($html);

		for($i = 0; $i < count($this->list); $i++) {
			$row = $this->list[$i];

			// new page
			if ($i%10 == 0) {
				$this->setPage(floor($i/10) + 1);
				$y = 8;
			}

// Image method signature:
// Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)

			if ($row['degree'] < 0) {
				$row['degree'] = 360 + $row['degree'];
			}

			$row['degree'] = (360 - $row['degree']) %360;

			$this->Image('report/'.$row['degree'].'-verteiler.png', 113 + ($row['cm']*0.5), $y, 25);
			$y += 25;
		}

		// set font
		$this->SetFont('dejavusans', '', 10);

		// Close and output PDF document
		$this->Output($filename, 'I');
		//return $this->Output($filename, 'S');

	}
}

if (isset($_GET['team']) && $_GET['team'] == 'men') {
	$name = 'Maenner';
} elseif (isset($_GET['team']) && $_GET['team'] == 'women') {
	$name = 'Frauen';
} else {
	exit();
}


$rows = $db->getRows("
	SELECT *
	FROM (
		SELECT *
		FROM `verteiler` v
		WHERE `team` = '".$_GET['team']."'
		ORDER BY `set` DESC
	) n
	GROUP BY n.`name`
	ORDER BY n.`name`;");

$pdf = new Report($name, $rows);
ob_end_clean();
$pdf->generate('Liste-'.$name.'.pdf', true);
exit();

