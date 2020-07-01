<?php
require "fpdf.php";
$db = new PDO('mysql:host=localhost;dbname=hrms','root','donz17');

class myPDF extends FPDF{
	function header(){
	}
	function TopContent($db){
		$name = $db->query("select * from information where employee_no='$_GET[srid]' limit 1");
		$getname = $name->fetch(PDO::FETCH_OBJ);
		$this->Image('logo.png',10,6);
		$this->SetFont('Times','',10);
		$this->Cell(191,4,'Republic of the Philippines',0,0,'C');
		$this->Ln();
		$this->Cell(191,4,'Department of Education',0,0,'C');
		$this->Ln();
		$this->Cell(191,4,'Region IV-A, CALABARZON',0,0,'C');
		$this->Ln();
		$this->SetFont('Times','B',10);
		$this->Cell(191,5,'SCHOOLS DIVISION OFFICE OF THE CITY OF TAYABAS',0,0,'C');
		$this->Ln();
		$this->SetFont('Times','',10);
		$this->Cell(191,4,'City of Tayabas',0,0,'C');
		$this->Ln(10);
		$this->SetFont('Times','B',12);
		$this->Cell(191,5,'TRAININGS AND SEMINARS',0,0,'C');
		$this->Ln(8);
		$this->SetFont('Times','',10);
		$this->Cell(25,4,'NAME: ',0,0,'L');
		$this->Cell(70,4,$getname->surname.', '.$getname->fname.' '.$getname->mname,0,0,'L');
		$this->Ln(8);
		$this->Cell(25,4,'BIRTHDAY: ',0,0,'L');
		$date = new DateTime($getname->dbirth);
		$this->Cell(70,4,$date->format("F d, Y"),0,0,'L');
		$this->Ln(8);

/*		$this->Cell(191,4,'                         This is to certify that the employees named herewith actually rendered services in this Office as shown by the Service',0,0,'L');
		$this->Ln(4);
		$this->Cell(191,4,'Record below, each line of which is supported by appointment and the other papers actually issued by this Office and approved by the',0,0,'L');
		$this->Ln(4);
		$this->Cell(191,4,'autorities concerned.',0,0,'L');
		$this->Ln(6);
*/
	}
	function footer(){
		$this->SetY(-15);
		$this->SetFont('Arial','',8);
		$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
	function headerTable(){
		$x = $this->GetX();
		$y = $this->GetY();
		$this->MultiCell(90,5,'TITLE OF SEMINAR/ CONFERENCE/ WORKSHOP/ SHORT COURSES',1,'C');
		$this->SetXY($x+90,$y);
		$this->Cell(18,10,'FROM',1,0,'C');
		$this->Cell(18,10,'TO',1,0,'C');
		$this->MultiCell(17,5,'NO. OF HOURS',1,'C');
		$this->SetXY($x+143,$y);
		$this->MultiCell(48,5,'CONDUCTED/ SPONSORED BY',1,'C');
	}
	function viewTable($db){
		$LnY = 76.5; $ctrPage = 1;
		$this->SetFont('Times','',10);
		$stmt = $db->query("select * from training where employee_no='$_GET[srid]' order by tfrom desc");
		while($data = $stmt->fetch(PDO::FETCH_OBJ)){

			$this->Cell(90,9,' ',1,0,'C');
			$this->Cell(18,9,' ',1,0,'C');
			$this->Cell(18,9,' ',1,0,'C');
			$this->Cell(17,9,' ',1,0,'C');
			$this->Cell(48,9,' ',1,0,'C');
			$this->Ln();

			$this->SetFont('Arial','',8);
			$this->Text(13,$LnY-2,substr($data->title,0,47));
			$this->Text(13,$LnY+2,substr($data->title,47,47));
			$this->Text(102,$LnY,$data->tfrom);
			$this->Text(120,$LnY,$data->tto);
			$this->Text(143,$LnY,$data->hours);
			$this->Text(154.5,$LnY-2,substr($data->conducted_by,0,25));
			$this->Text(154.5,$LnY+2,substr($data->conducted_by,25,25));
			$LnY=$LnY+9;
			$ctrPage=$ctrPage+1;
			if ($ctrPage>22) {
				$this->Addpage('P','A4',0);
				$this->TopContent($db);
				$this->headerTable();
				$LnY=76.5;
				$ctrPage=1;
			}
		}
	}
}

$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->Addpage('P','A4',0);
$pdf->TopContent($db);
$pdf->headerTable();
$pdf->viewTable($db);
$pdf->Output();