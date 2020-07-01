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
		$this->Cell(191,5,'SERVICE RECORD',0,0,'C');
		$this->Ln(8);
		$this->SetFont('Times','',10);
		$this->Cell(25,4,'NAME: ',0,0,'L');
		$this->Cell(70,4,$getname->surname.', '.$getname->fname.' '.$getname->mname,0,0,'L');
		$this->Ln(8);
		$this->Cell(25,4,'BIRTHDAY: ',0,0,'L');
		$date = new DateTime($getname->dbirth);
		$this->Cell(70,4,$date->format("F d, Y"),0,0,'L');
		$this->Ln(8);
		$this->Cell(191,4,'                         This is to certify that the employees named herewith actually rendered services in this Office as shown by the Service',0,0,'L');
		$this->Ln(4);
		$this->Cell(191,4,'Record below, each line of which is supported by appointment and the other papers actually issued by this Office and approved by the',0,0,'L');
		$this->Ln(4);
		$this->Cell(191,4,'autorities concerned.',0,0,'L');
		$this->Ln(6);
	}
	function footer(){
		$this->SetY(-15);
		$this->SetFont('Arial','',8);
		$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
	function headerTable(){
		$x = $this->GetX();
		$y = $this->GetY();
		$this->SetFont('Times','',10);
		$this->Cell(42,5,'SERVICE',1,0,'C');
		$this->Cell(92,5,'RECORD OF APPOINTMENT/OFFICE ENTITY DIVISION',1,0,'C');
		$this->SetXY($x+134,$y);
		$this->Cell(20,15,'BRANCH',1,0,'C');
		$this->SetXY($x+154,$y);
		$this->MultiCell(18,7.5,'LEAVE W/O PAY',1,'C');		
		$this->SetXY($x+172,$y);
		$this->Cell(19,15,'REMARKS',1,'C');
		$this->Ln(5);
		$this->Cell(21,10,'FROM',1,0,'C');
		$this->Cell(21,10,'TO',1,0,'C');
		$this->Cell(26,10,'DESIGNATION',1,0,'C');
		$this->Cell(20,10,'STATUS',1,0,'C');
		$this->Cell(21,10,'SALARY',1,0,'C');
		$this->MultiCell(25,5,'STATION PLACE',1,'C');
	}
	function viewTable($db){
		$LnY = 95.2; $ctrPage = 1;
		$this->SetFont('Times','',10);
		$stmt = $db->query("select * from service_record where employee_no='$_GET[srid]' order by srfrom desc");
		while($data = $stmt->fetch(PDO::FETCH_OBJ)){

			$this->Cell(21,9,' ',1,0,'C');
			$this->Cell(21,9,' ',1,0,'C');
			$this->Cell(26,9,' ',1,0,'C');
			$this->Cell(20,9,' ',1,0,'C');
			$this->Cell(21,9,' ',1,0,'C');
			$this->Cell(25,9,' ',1,0,'C');
			$this->Cell(20,9,' ',1,0,'L');
			$this->Cell(18,9,' ',1,0,'L');
			$this->Cell(19,9,' ',1,0,'L');
			$this->Ln();



			$this->SetFont('Arial','',7);
			$this->Text(13,$LnY,$data->srfrom);
			$this->Text(35,$LnY,$data->srto);
			$this->SetFont('Arial','',6);
			$this->Text(53,$LnY-2.2,substr($data->designation,0,18));
			$this->Text(53,$LnY,substr($data->designation,18,18));
			$this->Text(53,$LnY+2.2,substr($data->designation,36,18));
			$this->SetFont('Arial','',7);
			$this->Text(79,$LnY,$data->status);
			$this->Text(103,$LnY,number_format($data->salary,2));
			$this->SetFont('Arial','',6);
			$this->Text(120,$LnY-2.2,substr($data->assignment,0,16));
			$this->Text(120,$LnY,substr($data->assignment,16,16));
			$this->Text(120,$LnY+2.2,substr($data->assignment,32,16))	;
			$this->SetFont('Arial','',7);
			$this->Text(145,$LnY,' ');
			$this->Text(170,$LnY,' ');
			$this->Text(183,$LnY,' ');
			$LnY=$LnY+9;
			$ctrPage=$ctrPage+1;
			if ($ctrPage>20) {
				$this->Addpage('P','A4',0);
				$this->TopContent($db);
				$this->headerTable();
				$LnY=95.2;
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