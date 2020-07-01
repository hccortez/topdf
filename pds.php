<?php
require "fpdf.php";
$db = new PDO('mysql:host=localhost;dbname=hrms','root','donz17');

class myPDF extends FPDF{

	function PDSPage01($db){
		$this->SetFont('Arial','B',8);
		$this->Text(11,13,'CS Form No. 212');
		$this->Text(11,16,'Revised 2017');
		$this->SetFont('Arial','B',18);		
		$this->Text(66,21,'PERSONAL DATA SHEET');
		$this->SetFont('Arial','',18);
		$this->Cell(196,30.5,'',1,0,'C');
		$this->Ln();
		$this->SetFont('Arial','B',6.3);
		$this->Text(11,30,'WARNING: Any misinterpretation made in the Personal Data Sheet and the Work Experience Sheet shall cause the filing of administrative/criminal case/s against the person concerned.');
		$this->Text(11,36,'READ THE ATTACHED GUIDE TO FILLING THE PERSONAL DATA SHEET (PDS) BEFORE ACCOMPLISHING THE PDS FORM.');
		$this->SetFont('Arial','',6.3);
		$this->Text(11,39,'Print legibly. Tick appropriate boxes and use separate sheet if necesary. Indicate N/A if not applicable.  DO NOT ABBREVIATE.');
		$this->Text(144,39, '1. CS ID No.');
		$this->Text(172,39, '(Do not fill up. For CSC use only)');
		$this->Line(143, 36, 206, 36);
		$this->Line(143, 36, 143, 42);
		$this->Line(157, 36, 157, 42);
		//$this->Cell(50,7,'',1,0,'C');
		$this->SetFont('Arial','',9);
		$this->setFillColor(152,152,152);
		$this->setTextColor(255,255,255);
		$this->Cell(196,5,'I. PERSONAL INFORMATION',1,0,'L','1');
	$eedata = $db->query("select * from information where employee_no='$_GET[prtid]' limit 1");
	$data = $eedata->fetch(PDO::FETCH_OBJ);
		$this->Ln();
		$this->SetFont('Arial','',7);
		$this->setTextColor(0,0,0);
		$this->Cell(40,19.5,'',1,0,'L');
		$this->Text(11,50, '2. SURNAME');
		$this->Text(12,56, 'FIRST NAME');
		$this->Text(12,62, 'MIDDLE NAME');
		$this->Cell(156,6.5,$data->surname,1,0,'L');
		$this->Ln();
		$this->Cell(40,6.5,'',0,0,'L');
		$this->Cell(98,6.5,$data->fname,1,0,'L');
		$this->Cell(58,6.5,'NAME EXTENSION (JR., SR)',1,0,'L');
		$this->Ln();
		$this->Cell(40,6.5,$data->n_ext,0,0,'L');
		$this->Cell(156,6.5,$data->mname,1,0,'L');

		$this->Ln();
		$this->Cell(40,13,'',1,0,'L');
		$this->Text(11,69, '3. DATE OF BIRTH');
		$this->Text(14,72, '(mm/dd/yyyy)');
		$newDate = date("m/d/Y", strtotime($data->dbirth));
		$this->Cell(48,13,$newDate,1,0,'L');
		$this->Cell(40,26,'',1,0,'L');
		$this->Text(100,69, '16. CITIZENSHIP');
		$this->Cell(68,19.5,'',1,0,'L');
		$this->Text(148,69, 'Filipino');
		$this->Text(170,69, 'Dual Citizenship');
		$this->Text(148,74, 'by Birth');
		$this->Text(170,74, 'by Naturalizaton');
		$this->Cell(1,13,'',0,0,'L');
		$this->Ln();
		$this->Cell(40,6.5,'4. PLACE OF BIRTH',1,0,'L');
		$this->Cell(48,6.5,$data->pbirth,1,0,'L');
		$this->Cell(40,6.5,'',0,0,'L');
		$this->Text(103,81.5, 'If holder of dual citizenship,');
		$this->Cell(68,6.5,'',0,0,'L');
		$this->Text(143,81.5, 'Pls. indicate country:');
		$this->Ln();
		$this->Cell(40,6.5,'5. SEX',1,0,'L');
		$this->Cell(48,6.5,'',1,0,'L');
		$this->Text(57,88.5, 'Male');
		$this->Text(84,88.5, 'Female');
		$this->Cell(40,6.5,'',0,0,'L');
		$this->Text(103,88.5, 'please indicate the details.');
		$this->Cell(68,6.5,'',1,0,'L');

		$this->Rect(144.5,67,2.5,2.5); //citizenship
		$this->Rect(166.5,67,2.5,2.5);
		$this->Rect(144.5,72,2.5,2.5);
		$this->Rect(166.5,72,2.5,2.5);
		$this->Rect(53.5,86.5,2.5,2.5); //sex
		$this->Rect(80.5,86.5,2.5,2.5);

		$this->Line(145,69.5,147,67.5); //citizenship

		if($data->gender=='MALE'){
		$this->Line(54,89,56,87); //sex
		}
		if($data->gender=='FEMALE'){
		$this->Line(81,89,83,87); //sex
		}

		$this->Text(100,94.5, '17. RESIDENTIAL ADDRESS');
		$this->Text(104,115, 'ZIP CODE');
		$this->Text(100,120.5, '18. PERMANENT ADDRESS');
		$this->Text(104,141, 'ZIP CODE');


		$this->Ln();
		$this->Cell(40,13,'6. CIVIL STATUS',1,0,'L');
		$this->Cell(48,13,'',1,0,'L');
		$this->Cell(40,26,'',1,0,'L');


		$add11 = substr($data->res_address,0,45);
		$this->Cell(68,6.5,$add11.',',1,0,'L');
		$this->Text(57,94.5, 'Single');
		$this->Text(84,94.5, 'Married');
		$this->Text(57,98.5, 'Widowed');
		$this->Text(84,98.5, 'Separated');
		$this->Text(57,102.5, 'Other/s:');

		$this->Rect(53.5,92.5,2.5,2.5); //status
		$this->Rect(80.5,92.5,2.5,2.5);
		$this->Rect(53.5,96.5,2.5,2.5);
		$this->Rect(80.5,96.5,2.5,2.5);
		$this->Rect(53.5,100.5,2.5,2.5);

		if($data->status=='SINGLE'){
		$this->Line(54,95,56,93); //status
		}
		if($data->status=='MARRIED'){
		$this->Line(81,95,83,93); //status
		}
		if($data->status=='WIDOWED'){
		$this->Line(54,99,56,97); //status
		}
		if($data->status=='SEPARATED'){
		$this->Line(81,99,83,97); //status
		}
		if($data->status=='OTHERS'){
		$this->Line(54,103,56,101); //status
		}

		$this->Ln();
		$this->Cell(40,6.5,'',0,0,'L');
		$this->Cell(48,6.5,'',0,0,'L');
		$this->Cell(40,6.5,'',0,0,'L');

		$add12 = substr($data->res_address,45,45);
		$this->Cell(68,6.5,$add12,1,0,'L');
		$this->Ln();
		$this->Cell(40,6.5,'7. HEIGHT (m)',1,0,'L');
		$this->Cell(48,6.5,$data->height,1,0,'L');
		$this->Cell(40,6.5,'',0,0,'L');
		$this->Cell(68,6.5,'',1,0,'L');
		$this->Ln();
		$this->Cell(40,6.5,'8. WEIGHT (kg)',1,0,'L');
		$this->Cell(48,6.5,$data->weight,1,0,'L');
		$this->Cell(40,6.5,'',0,0,'L');
		$this->Cell(68,6.5,$data->res_zipcode,1,0,'L');

		$this->Ln();
		$this->Cell(40,6.5,'9. BLOOD TYPE',1,0,'L');
		$this->Cell(48,6.5,$data->btype,1,0,'L');
		$this->Cell(40,26,'',1,0,'L');

		$add21 = substr($data->per_address,0,45);
		$this->Cell(68,6.5,$add21,1,0,'L');
		$this->Ln();
		$this->Cell(40,6.5,'10. GSIS ID NO.',1,0,'L');
		$this->Cell(48,6.5,$data->gsis_no,1,0,'L');
		$this->Cell(40,6.5,'',0,0,'L');

		$add22 = substr($data->per_address,45,45);
		$this->Cell(68,6.5,$add22,1,0,'L');
		$this->Ln();
		$this->Cell(40,6.5,'11. PAG-IBIG ID NO.',1,0,'L');
		$this->Cell(48,6.5,$data->pagibig_no,1,0,'L');
		$this->Cell(40,6.5,'',0,0,'L');
		$this->Cell(68,6.5,'',1,0,'L');
		$this->Ln();
		$this->Cell(40,6.5,'12. PHILHEALTH NO.',1,0,'L');
		$this->Cell(48,6.5,$data->philhealth_no,1,0,'L');
		$this->Cell(40,6.5,'',0,0,'L');
		$this->Cell(68,6.5,$data->per_zipcode,1,0,'L');

		$this->Ln();
		$this->Cell(40,6.5,'13. SSS NO.',1,0,'L');
		$this->Cell(48,6.5,$data->sss_no,1,0,'L');
		$this->Cell(40,6.5,'19. TELEPHONE NO.',1,0,'L');
		$this->Cell(68,6.5,'',1,0,'L');
		$this->Ln();
		$this->Cell(40,6.5,'14. TIN NO.',1,0,'L');
		$this->Cell(48,6.5,$data->tin,1,0,'L');
		$this->Cell(40,6.5,'20. MOBILE NO.',1,0,'L');
		$this->Cell(68,6.5,$data->mobile_no,1,0,'L');
		$this->Ln();
		$this->Cell(40,6.5,'15. AGENCY EMPLOYEE NO.',1,0,'L');
		$this->Cell(48,6.5,$data->employee_no,1,0,'L');
		$this->Cell(40,6.5,'21. E-MAIL ADDRESS (if any)',1,0,'L');
		$this->Cell(68,6.5,$data->per_email,1,0,'L');

		$this->Ln();
		$this->SetFont('Arial','',9);
		$this->setFillColor(152,152,152);
		$this->setTextColor(255,255,255);
		$this->Cell(196,5,'II. FAMILY BACKGROUND',1,0,'L','1');
	$eefam = $db->query("select * from family where employee_no='$_GET[prtid]' limit 1");
	if($fam = $eefam->fetch(PDO::FETCH_OBJ)){
		$famspousesurname=$fam->spouse_surname;
		$famspousefname=$fam->spouse_fname;
		$famspousemname=$fam->spouse_mname;
		$famoccupation=$fam->occupation;
		$famemployer=$fam->employer;
		$famemployer_add=$fam->employer_add;
		$famemployer_telno=$fam->employer_telno;
		$famfather_surname=$fam->father_surname;
		$famfather_fname=$fam->father_fname;
		$famfather_mname=$fam->father_mname;
		$fammother_surname=$fam->mother_surname;
		$fammother_fname=$fam->mother_fname;
		$fammother_mname=$fam->mother_mname;
	} else {
		$famspousesurname=" ";
		$famspousefname=" ";
		$famspousemname=" ";
		$famoccupation=" ";
		$famemployer=" ";
		$famemployer_add=" ";
		$famemployer_telno=" ";
		$famfather_surname=" ";
		$famfather_fname=" ";
		$famfather_mname=" ";
		$fammother_surname=" ";
		$fammother_fname=" ";
		$fammother_mname=" ";
	}

		$this->Ln();
		$this->SetFont('Arial','',7);
		$this->setTextColor(0,0,0);
		$this->Cell(40,18,'',1,0,'L');
		$this->Text(11,172.5, '22. SPOUSE SURNAME');
		$this->Text(15,177.5, 'FIRST NAME');
		$this->Text(15,182.5, 'MIDDLE NAME');
		$this->Cell(88,6,$famspousesurname,1,0,'L');
		$this->Cell(40,6,'23. NAME of CHILDREN',1,0,'L');
		$this->Cell(28,6,'DATE OF BIRTH',1,0,'L');
		$this->Ln();		
		$this->Cell(40,6,'',0,0,'L');
		$this->Cell(48,6,$famspousefname,1,0,'L');
		$this->Cell(40,6,'NAME EXTENSION (Jr., Sr.)',1,0,'L');
		$this->Cell(40,6,'',1,0,'L');
		$this->Cell(28,6,'',1,0,'L');
		$this->Ln();		
		$this->Cell(40,6,'',0,0,'L');
		$this->Cell(88,6,$famspousemname,1,0,'L');
		$this->Cell(40,6,'',1,0,'L');
		$this->Cell(28,6,'',1,0,'L');
		$this->Ln();		
		$this->Cell(40,6,'OCCUPATION',1,0,'L');
		$this->Cell(88,6,$famoccupation,1,0,'L');
		$this->Cell(40,6,'',1,0,'L');
		$this->Cell(28,6,'',1,0,'L');
		$this->Ln();		
		$this->Cell(40,6,'EMPLOYER/BUSINESS NAME',1,0,'L');
		$this->Cell(88,6,$famemployer,1,0,'L');
		$this->Cell(40,6,'',1,0,'L');
		$this->Cell(28,6,'',1,0,'L');
		$this->Ln();		
		$this->Cell(40,6,'BUSINESS ADDRESS',1,0,'L');
		$this->Cell(88,6,$famemployer_add,1,0,'L');
		$this->Cell(40,6,'',1,0,'L');
		$this->Cell(28,6,'',1,0,'L');
		$this->Ln();		
		$this->Cell(40,6,'TELEPHONE NO',1,0,'L');
		$this->Cell(88,6,$famemployer_telno,1,0,'L');
		$this->Cell(40,6,'',1,0,'L');
		$this->Cell(28,6,'',1,0,'L');
		$this->Ln();
		$this->Cell(40,18,'',1,0,'L');
		$this->Text(11,213.5, '24. FATHER SURNAME');
		$this->Text(15,219.5, 'FIRST NAME');
		$this->Text(15,225.5, 'MIDDLE NAME');
		$this->Cell(88,6,$famfather_surname,1,0,'L');
		$this->Cell(40,6,'',1,0,'L');
		$this->Cell(28,6,'',1,0,'L');
		$this->Ln();		
		$this->Cell(40,6,'',0,0,'L');
		$this->Cell(48,6,$famfather_fname,1,0,'L');
		$this->Cell(40,6,'NAME EXTENSION (Jr., Sr.)',1,0,'L');
		$this->Cell(40,6,'',1,0,'L');
		$this->Cell(28,6,'',1,0,'L');
		$this->Ln();		
		$this->Cell(40,6,'',0,0,'L');
		$this->Cell(88,6,$famfather_mname,1,0,'L');
		$this->Cell(40,6,'',1,0,'L');
		$this->Cell(28,6,'',1,0,'L');
		$this->Ln();
		$this->Cell(40,24,'',1,0,'L');
		$this->Text(11,231.5, '25. MOTHER MAINDEN NAME');
		$this->Text(15,237.5, 'SURNAME');
		$this->Text(15,243.5, 'FIRST NAME');
		$this->Text(15,249.5, 'MIDDLE NAME');
		$this->Cell(88,6,'',1,0,'L');
		$this->Cell(40,6,'',1,0,'L');
		$this->Cell(28,6,'',1,0,'L');
		$this->Ln();		
		$this->Cell(40,6,'',0,0,'L');
		$this->Cell(88,6,$fammother_surname,1,0,'L');
		$this->Cell(40,6,'',1,0,'L');
		$this->Cell(28,6,'',1,0,'L');
		$this->Ln();		
		$this->Cell(40,6,'',0,0,'L');
		$this->Cell(88,6,$fammother_fname,1,0,'L');
		$this->Cell(40,6,'',1,0,'L');
		$this->Cell(28,6,'',1,0,'L');
		$this->Ln();
		$this->Cell(40,6,'',0,0,'L');
		$this->Cell(88,6,$fammother_mname,1,0,'L');
		$this->Cell(40,6,'',1,0,'L');
		$this->Cell(28,6,'',1,0,'L');

	$eechild = $db->query("select * from child where employee_no='$_GET[prtid]'");
		$ychild = 177.3;
	while($child = $eechild->fetch(PDO::FETCH_OBJ)){
		$newdob = date("m/d/Y", strtotime($child->dob));
		$this->Text(139,$ychild,$child->fullname);
		$this->Text(185,$ychild,$newdob);
		$ychild=$ychild + 6;
	}

		$this->Ln();
		$this->SetFont('Arial','',9);
		$this->setFillColor(152,152,152);
		$this->setTextColor(255,255,255);
		$this->Cell(196,5,'III. EDUCATIONAL BACKGROUND',1,0,'L','1');

		$this->Ln();
		$this->SetFont('Arial','',7);
		$this->setTextColor(0,0,0);
		$this->Cell(40,15,'26. LEVEL',1,0,'L');
		$this->Cell(48,15,'',1,0,'L');
		$this->Cell(40,15,'',1,0,'L');
		$this->Cell(22,10,'',1,0,'L');
		$this->Cell(18,15,'',1,0,'L');
		$this->Cell(14,15,'',1,0,'L');
		$this->Cell(14,15,'',1,0,'L');
		$this->Cell(1,10,'',0,0,'L');
		$this->Ln();

		$this->SetFont('Arial','',6);
		$this->Text(62.5,263,'NAME OF SCHOOL');
		$this->Text(67,266,'(Write in full)');
		$this->Text(98.6,263,'BASIC EDUCATION/DEGREE/COURSE');
		$this->Text(112,266,'(Write in full)');
		$this->Text(143,260.5,'PERIOD OF');
		$this->Text(142,263.5,'ATTENDANCE');
		$this->SetFont('Arial','',5.5);
		$this->Text(161.5,261,'HIGHEST LEVEL');
		$this->Text(162.5,264,'UNIT EARNED');
		$this->Text(161.5,267,'(if not graduated)');
		$this->Text(182.5,263,'YEAR');
		$this->Text(179,266,'GRADUATED');
		$this->SetFont('Arial','',5);
		$this->Text(192.6,260,'SCHOLARSHIP');
		$this->SetFont('Arial','',5.5);
		$this->Text(194,263,'ACADEMIC');
		$this->Text(194.5,266,'HONORS');
		$this->Text(194,269,'RECEIVED');

		$this->SetFont('Arial','',7);
		$this->Cell(40,5,'',0,0,'L');
		$this->Cell(48,5,'',0,0,'L');
		$this->Cell(40,5,'',0,0,'L');
		$this->Cell(11,5,'From',1,0,'C');
		$this->Cell(11,5,'To',1,0,'C');
		$this->Ln();
		$this->Cell(40,8,'ELEMENTARY',1,0,'L');
		$this->Cell(48,8,'',1,0,'L');
		$this->Cell(40,8,'',1,0,'L');
		$this->Cell(11,8,'',1,0,'C');
		$this->Cell(11,8,'',1,0,'C');
		$this->Cell(18,8,'',1,0,'L');
		$this->Cell(14,8,'',1,0,'C');
		$this->Cell(14,8,'',1,0,'C');

		$eeeduc = $db->query("select * from basic_ed where employee_no='$_GET[prtid]' && type='ELEMENTARY' limit 1");
		if($educ = $eeeduc->fetch(PDO::FETCH_OBJ)){
			$this->Text(51,274.5,substr($educ->school, 0,29));
			$this->Text(51,277.5,substr($educ->school, 29,29));
			$this->Text(140.5,276,$educ->s_from);
			$this->Text(151.5,276,$educ->s_to);
			$this->Text(182,276,$educ->year_grad);
			$this->Text(193,276,$educ->received);
		}

		$this->Ln();
		$this->Cell(40,8,'SECONDARY',1,0,'L');
		$this->Cell(48,8,'',1,0,'L');
		$this->Cell(40,8,'',1,0,'L');
		$this->Cell(11,8,'',1,0,'C');
		$this->Cell(11,8,'',1,0,'C');
		$this->Cell(18,8,'',1,0,'L');
		$this->Cell(14,8,'',1,0,'C');
		$this->Cell(14,8,'',1,0,'C');
		$this->Ln();

		$eeeduc2 = $db->query("select * from basic_ed where employee_no='$_GET[prtid]' && type='SECONDARY' limit 1");
		if($educ2 = $eeeduc2->fetch(PDO::FETCH_OBJ)){
			$this->Text(51,282.5,substr($educ2->school, 0,29));
			$this->Text(51,285.5,substr($educ2->school, 29,29));
			//$this->Text(98.6,274.5,'');
			//$this->Text(98.6,277.5,'');
			$this->Text(140.5,284,$educ2->s_from);
			$this->Text(151.5,284,$educ2->s_to);
			//$this->Text(161,276,'1234');
			$this->Text(182,284,$educ2->year_grad);
			$this->Text(193,284,$educ2->received);
		}
		$this->Cell(40,8,'COLLEGE',1,0,'L');
		$this->Cell(48,8,'',1,0,'L');
		$this->Cell(40,8,'',1,0,'L');
		$this->Cell(11,8,'',1,0,'L');
		$this->Cell(11,8,'',1,0,'L');
		$this->Cell(18,8,'',1,0,'L');
		$this->Cell(14,8,'',1,0,'L');
		$this->Cell(14,8,'',1,0,'L');
		$this->Ln();
		$this->Cell(40,8,'',1,0,'L');
		$this->Cell(48,8,'',1,0,'L');
		$this->Cell(40,8,'',1,0,'L');
		$this->Cell(11,8,'',1,0,'L');
		$this->Cell(11,8,'',1,0,'L');
		$this->Cell(18,8,'',1,0,'L');
		$this->Cell(14,8,'',1,0,'L');
		$this->Cell(14,8,'',1,0,'L');

	$eeeduc3 = $db->query("select * from high_ed where employee_no='$_GET[prtid]' && level='COLLEGE' limit 2");
		$coly = 290.5;
	while($educ3 = $eeeduc3->fetch(PDO::FETCH_OBJ)){
			$this->Text(51,$coly,substr($educ3->school, 0,29));
			$this->Text(51,$coly+3,substr($educ3->school, 29,29));
			$this->Text(98.6,$coly,substr($educ3->degree, 0,25));
			$this->Text(98.6,$coly+3,substr($educ3->degree, 25,25));
			$this->Text(140.5,$coly+1.5,$educ3->hfrom);
			$this->Text(151.5,$coly+1.5,$educ3->hto);
			$this->Text(167,$coly+1.5,$educ3->units);
			$this->Text(182,$coly+1.5,$educ3->year_grad);
			$this->Text(193,$coly+1.5,$educ3->aca_received);
			$coly = $coly + 8;
	}
		$this->Ln();
		$this->Cell(40,8,'GRADUATE STUDIES',1,0,'L');
		$this->Cell(48,8,'',1,0,'L');
		$this->Cell(40,8,'',1,0,'L');
		$this->Cell(11,8,'',1,0,'C');
		$this->Cell(11,8,'',1,0,'C');
		$this->Cell(18,8,'',1,0,'C');
		$this->Cell(14,8,'',1,0,'C');
		$this->Cell(14,8,'',1,0,'C');		

	$eeeduc4 = $db->query("select * from high_ed where employee_no='$_GET[prtid]' && level='GRADUATE' limit 1");
	if($educ4 = $eeeduc4->fetch(PDO::FETCH_OBJ)){
			$this->Text(51,306.5,substr($educ4->school, 0,29));
			$this->Text(51,309.5,substr($educ4->school, 29,29));
			$this->Text(98.6,306.5,substr($educ4->degree, 0,25));
			$this->Text(98.6,309.5,substr($educ4->degree, 25,25));
			$this->Text(140.5,308,$educ4->hfrom);
			$this->Text(151.5,308,$educ4->hto);
			$this->Text(167,308,$educ4->units);
			$this->Text(182,308,$educ4->year_grad);
			$this->Text(193,308,$educ4->aca_received);
	}
		$this->Ln();
		$this->SetFont('Arial','',7);
		$this->setFillColor(152,152,152);
		$this->setTextColor(255,10,10);
		$this->Cell(196,4.5,'(Continue on separate sheet if necessary)',1,0,'C','1');
		$this->Ln();
		$this->SetFont('Arial','B',8);
		$this->setTextColor(0,0,0);
		$this->Cell(40,8,'SIGNATURE',1,0,'C');
		$this->Cell(60,8,'',1,0,'C');
		$this->Cell(12,8,'DATE',1,0,'C');
		$this->Cell(38,8,'',1,0,'C');
		$this->SetFont('Arial','',6.2);
		$this->Cell(46,8,'CS FORM 212(Revised 2017), ',1,0,'L');
		$this->Ln();
	}

	function PDSPage02($db){
		$this->SetFont('Arial','',9);
		$this->setFillColor(152,152,152);
		$this->setTextColor(255,255,255);
		$this->Cell(196,5,'IV. CIVIL SERVICE ELIGIBILITY',1,0,'L','1');
		$this->Ln();
		$this->SetFont('Arial','',7);
		$this->setTextColor(0,0,0);
		$this->Cell(62,14,'',1,0,'L');
		$this->Cell(20,14,'',1,0,'L');
		$this->Cell(20,14,'',1,0,'L');
		$this->Cell(58,14,'PLACE OF EXAMINATION / CONFERMENT',1,0,'C');
		$this->Cell(36,5,'LICENSE (if applicable)',1,0,'C');
		$this->Cell(1,5,'',0,0,'C');
		$this->Ln();

		$this->SetFont('Arial','',6.5);
		$this->Text(11,19,'27. CAREER SERVICE/ RA 1080 (BOARD/BAR) UNDER');
		$this->Text(28,23,'SPECIAL LAWS/ CES/ CSEE');
		$this->Text(18,27,'BARANGAY ELIGIBILITY/ DRIVERS LICENSE');
		$this->Text(77.5,20.5,'RATING');
		$this->Text(75,24.5,'(if applicable)');
		$this->Text(97,19,'DATE OF');
		$this->Text(94,23,'EXAMINATION/');
		$this->Text(94,27,'CONFERMENT');

		$this->SetFont('Arial','',7);
		$this->Text(193,23.5,'Date of');
		$this->Text(193,26.5,'Validity');

		$this->Cell(62,14,'',0,0,'L');
		$this->Cell(20,14,'',0,0,'L');
		$this->Cell(20,14,'',0,0,'L');
		$this->Cell(58,14,'',0,0,'C');		
		$this->Cell(18,9,'NUMBER',1,0,'C');
		$this->Cell(18,9,'',1,0,'C');
		$this->Ln();

	$eeelig = $db->query("select * from eligibility where employee_no='$_GET[prtid]'");
		$yelig = 34;
	while($elig = $eeelig->fetch(PDO::FETCH_OBJ)){
		$newexam = date("m/d/Y", strtotime($elig->date_exam));
		$this->Text(13,$yelig,$elig->career_service);
		$this->Text(80,$yelig,$elig->rating);
		$this->Text(96,$yelig,$newexam);
		$this->Text(115,$yelig,$elig->place_exam);
		$this->Text(172,$yelig,$elig->license_no);
		$this->Text(194,$yelig,$elig->validity_date);
		$this->Text(194,$yelig,'xxxx');
		$yelig=$yelig + 8;
	}

		$this->Cell(62,8,'',1,0,'L');
		$this->Cell(20,8,'',1,0,'C');
		$this->Cell(20,8,'',1,0,'C');
		$this->Cell(58,8,'',1,0,'C');		
		$this->Cell(18,8,'',1,0,'C');
		$this->Cell(18,8,'',1,0,'C');
		$this->Ln();
		$this->Cell(62,8,'',1,0,'L');
		$this->Cell(20,8,'',1,0,'C');
		$this->Cell(20,8,'',1,0,'C');
		$this->Cell(58,8,'',1,0,'C');		
		$this->Cell(18,8,'',1,0,'C');
		$this->Cell(18,8,'',1,0,'C');
		$this->Ln();
		$this->Cell(62,8,'',1,0,'L');
		$this->Cell(20,8,'',1,0,'C');
		$this->Cell(20,8,'',1,0,'C');
		$this->Cell(58,8,'',1,0,'C');		
		$this->Cell(18,8,'',1,0,'C');
		$this->Cell(18,8,'',1,0,'C');
		$this->Ln();
		$this->Cell(62,8,'',1,0,'L');
		$this->Cell(20,8,'',1,0,'C');
		$this->Cell(20,8,'',1,0,'C');
		$this->Cell(58,8,'',1,0,'C');		
		$this->Cell(18,8,'',1,0,'C');
		$this->Cell(18,8,'',1,0,'C');
		$this->Ln();
		$this->Cell(62,8,'',1,0,'L');
		$this->Cell(20,8,'',1,0,'C');
		$this->Cell(20,8,'',1,0,'C');
		$this->Cell(58,8,'',1,0,'C');		
		$this->Cell(18,8,'',1,0,'C');
		$this->Cell(18,8,'',1,0,'C');
		$this->Ln();
		$this->Cell(62,8,'',1,0,'L');
		$this->Cell(20,8,'',1,0,'C');
		$this->Cell(20,8,'',1,0,'C');
		$this->Cell(58,8,'',1,0,'C');		
		$this->Cell(18,8,'',1,0,'C');
		$this->Cell(18,8,'',1,0,'C');
		$this->Ln();
		$this->Cell(62,8,'',1,0,'L');
		$this->Cell(20,8,'',1,0,'C');
		$this->Cell(20,8,'',1,0,'C');
		$this->Cell(58,8,'',1,0,'C');		
		$this->Cell(18,8,'',1,0,'C');
		$this->Cell(18,8,'',1,0,'C');
		$this->Ln();
		$this->SetFont('Arial','',7);
		$this->setFillColor(152,152,152);
		$this->setTextColor(255,10,10);
		$this->Cell(196,4.5,'(Continue on separate sheet if necessary)',1,0,'C','1');

		$this->Ln();
		$this->SetFont('Arial','',9);
		$this->setFillColor(152,152,152);
		$this->setTextColor(255,255,255);
		$this->Cell(196,9.8,'',1,0,'L','1');
		$this->Text(11,94, 'V. WORK EXPERIENCE');
		$this->SetFont('Arial','I',8);
		$this->Text(11,97, '(Include private employment. Start from your recent work) Description of duties should be indicated in the attached Work Experience sheet.');
		$this->Ln();
		$this->SetFont('Arial','',7);
		$this->setTextColor(0,0,0);

		$this->Text(11,102.5,'28.');
		$this->Text(17,102.5,'INCLUSIVE DATES');
		$this->Text(21,106,'(mm/dd/yyyy)');
		$this->Text(60,106,'POSITION TITLE');
		$this->Text(52,110,'(Write in full/ Do not abbreviate)');
		$this->SetFont('Arial','',6.4);
		$this->Text(94.4,106,'DEPARTMENT/ AGENCY/ OFFICE/ COMPANY');
		$this->Text(105,110,'(Write in full/ Do not abbreviate)');
		$this->Text(146,106,'MONTHLY');
		$this->Text(147.5,110,'SALARY');

		$this->SetFont('Arial','',5);
		$this->Text(160,103,'SALARY/JOB/PAY');
		$this->Text(162,105.4,'GRADE (if');
		$this->Text(160,107.9,'appicable) & STEP');
		$this->Text(162,110.4,'Format *00-0*/');
		$this->Text(162.5,113,'INCREMENT');

		$this->SetFont('Arial','',6.5);
		$this->Text(178,106,'STATUS OF');
		$this->SetFont('Arial','',6);
		$this->Text(176.8,110,'APPOINTMENT');
		$this->SetFont('Arial','',6.5);
		$this->Text(196,103,'GOVT');
		$this->Text(194.5,107,'SERVICE');
		$this->Text(196.5,111,'(Y/N)');

		$this->SetFont('Arial','',7);
		$this->Cell(34,9,'',1,0,'L');
		$this->Cell(50,15,'',1,0,'L');
		$this->Cell(50,15,'',1,0,'L');
		$this->Cell(15,15,'',1,0,'L');
		$this->Cell(17,15,'',1,0,'L');
		$this->Cell(17,15,'',1,0,'L');
		$this->Cell(13,15,'',1,0,'L');
		$this->Cell(1,9,'',0,0,'L');
		$this->Ln();
		$this->Cell(17,6,'FROM',1,0,'C');
		$this->Cell(17,6,'TO',1,0,'C');


	$eework = $db->query("select * from service_record where employee_no='$_GET[prtid]'");
		$ywork = 119;
	while($work = $eework->fetch(PDO::FETCH_OBJ)){
		$newsrfrom = date("m/d/Y", strtotime($work->srfrom));
		$newsrto = date("m/d/Y", strtotime($work->srto));
		$this->Text(13,$ywork,$newsrfrom);
		$this->Text(30,$ywork,$newsrto);
		$this->Text(46,$ywork-1.7,substr($work->designation,0,30));
		$this->Text(46,$ywork+1.7,substr($work->designation,30,30));		
		$this->Text(95,$ywork-1.7,substr($work->assignment,0,31));
		$this->Text(95,$ywork+1.7,substr($work->assignment,31,31));
		$this->SetFont('Arial','',7);
		$this->Text(147.5,$ywork,$work->salary);
		$this->Text(163,$ywork,'XX-XX');

		$this->Text(177,$ywork,substr($work->status,0,10));
		$this->Text(197,$ywork,'Y/N');
		$ywork=$ywork + 7.58;
	}
		for ($ctr1 = 1; $ctr1 <= 26; $ctr1++) {
		$this->Ln();
		$this->Cell(17,7.6,'',1,0,'C');
		$this->Cell(17,7.6,'',1,0,'C');
		$this->Cell(50,7.6,'',1,0,'L');
		$this->Cell(50,7.6,'',1,0,'L');
		$this->Cell(15,7.6,'',1,0,'L');
		$this->Cell(17,7.6,'',1,0,'L');
		$this->Cell(17,7.6,'',1,0,'L');
		$this->Cell(13,7.6,'',1,0,'L');
		}
		$this->Ln();
		$this->SetFont('Arial','',7);
		$this->setFillColor(152,152,152);
		$this->setTextColor(255,10,10);
		$this->Cell(196,4.5,'(Continue on separate sheet if necessary)',1,0,'C','1');
		$this->Ln();
		$this->SetFont('Arial','B',8);
		$this->setTextColor(0,0,0);
		$this->Cell(40,8,'SIGNATURE',1,0,'C');
		$this->Cell(60,8,'',1,0,'C');
		$this->Cell(12,8,'DATE',1,0,'C');
		$this->Cell(38,8,'',1,0,'C');
		$this->SetFont('Arial','',6.2);
		$this->Cell(46,8,'CS FORM 212(Revised 2017), ',1,0,'L');
		$this->Ln();
	}
	function PDSPage03($db) {
		$this->SetFont('Arial','',9);
		$this->setFillColor(152,152,152);
		$this->setTextColor(255,255,255);
		$this->Cell(196,5,'VI. VOLUNTARY WORK OR INVOLVEMENT IN CIVIC/ NON-GOVERNMENT/ PEOPLE/ VOLUNTARY ORGANIZATION/S',1,0,'L','1');
		$this->Ln();
		$this->SetFont('Arial','',7);
		$this->setTextColor(0,0,0);
		$this->Cell(90,15,'',1,0,'L');
		$this->Cell(30,10,'',1,0,'L');
		$this->Cell(17,15,'',1,0,'C');
		$this->Cell(59,15,'POSITION/ NATURE OF WORK',1,0,'C');
		$this->Cell(1,10,'',0,0,'L');
		$this->Ln();
		$this->Cell(90,5,'',0,0,'L');
		$this->Cell(15,5,'FROM',1,0,'C');
		$this->Cell(15,5,'TO',1,0,'C');
		$this->Ln();

		$this->Text(11,19,'29.');
		$this->Text(35,19,'NAME & ADDRESS OF ORGANIZATION');
		$this->Text(49,23,'(Write in full)');
		$this->Text(104,18.5,'INCLUSIVE DATES');
		$this->Text(108,22,'(mm/dd/yyyy)');
		$this->Text(133.3,21.5,'NUMBER');
		$this->Text(132,25,'OF HOURS');

	$eevol = $db->query("select * from voluntary_work where employee_no='$_GET[prtid]'");
		$yvol = 34;
	while($vol = $eevol->fetch(PDO::FETCH_OBJ)){
		$newvwfrom = date("m/d/Y", strtotime($vol->vwfrom));
		$newvwto = date("m/d/Y", strtotime($vol->vwto));
		$this->Text(13,$yvol,$vol->name_add);
		$this->Text(102,$yvol,$newvwfrom);
		$this->Text(116.2,$yvol,$newvwto);		
		$this->Text(138,$yvol,$vol->hours);
		$this->Text(148.2,$yvol,$vol->position);
		$yvol=$yvol + 6.5;
	}
		for ($ctr2 = 1; $ctr2 <= 7; $ctr2++) {
		$this->Cell(90,6.5,'',1,0,'L');
		$this->Cell(15,6.5,'',1,0,'L');
		$this->Cell(15,6.5,'',1,0,'L');
		$this->Cell(17,6.5,'',1,0,'L');
		$this->Cell(59,6.5,'',1,0,'L');
		$this->Ln();
		}

		$this->SetFont('Arial','',7);
		$this->setFillColor(152,152,152);
		$this->setTextColor(255,10,10);
		$this->Cell(196,4.5,'(Continue on separate sheet if necessary)',1,0,'C','1');
		$this->Ln();
		$this->SetFont('Arial','',9);
		$this->setFillColor(152,152,152);
		$this->setTextColor(255,255,255);
		$this->Cell(196,10,'',1,0,'L','1');
		$this->Text(11,84, 'VII. LEARNING AND DEVELOPMENT (L&D) INTERVENTIONS/ TRAINING PROGRAMS ATTENDED');
		$this->SetFont('Arial','I',6);
		$this->Text(11,88, '(Start from the most recent L&D training program and include only the relevant L&D/ training taken for the last five (5) years for Division Chief/Executive/Managerial positions)');

		$this->Text(11,96,'30.');
		$this->SetFont('Arial','',6);
		$this->setTextColor(0,0,0);
		$this->Text(11,96,'30.');
		$this->Text(15,96,'TITLE OF LEARNING AND DEVELOPMENT INTERVENTIONS/ TRAINING PROGRAMS');
		$this->Text(49,99,'(Write in full)');
		$this->SetFont('Arial','',7);
		$this->Text(104,96,'INCLUSIVE DATES');
		$this->Text(108,100,'(mm/dd/yyyy)');
		$this->Text(133.3,98,'NUMBER');
		$this->Text(132,102,'OF HOURS');
		$this->SetFont('Arial','',6.5);
		$this->Text(150,95,'Type of ID');
		$this->Text(149,98,'(Managerial/');
		$this->Text(149.3,101,'Supervisory/');
		$this->Text(148,104,'Technical/etc)');
		$this->SetFont('Arial','',7);
		$this->Text(166,98,'CONDUCTED/ SPONSORED BY');
		$this->Text(178,102,'(Write in full)');

		$this->Ln();
		$this->SetFont('Arial','',7);
		$this->Cell(90,19,'',1,0,'L');
		$this->Cell(30,14,'',1,0,'L');
		$this->Cell(17,19,'',1,0,'L');
		$this->Cell(17,19,'',1,0,'0');
		$this->Cell(42,19,'',1,0,'0');
		$this->Cell(1,14,'',0,0,'L');
		$this->Ln();
		$this->Cell(90,5,'',0,0,'L');
		$this->Cell(15,5,'FROM',1,0,'C');
		$this->Cell(15,5,'TO',1,0,'C');
		$this->Ln();

		for ($ctr3 = 1; $ctr3 <= 20; $ctr3++) {
		$this->Cell(90,6.7,'',1,0,'L');
		$this->Cell(15,6.7,'',1,0,'L');
		$this->Cell(15,6.7,'',1,0,'L');
		$this->Cell(17,6.7,'',1,0,'L');
		$this->Cell(17,6.7,'',1,0,'L');
		$this->Cell(42,6.7,'',1,0,'L');
		$this->Ln();
		}

		$this->SetFont('Arial','',7);
		$this->setFillColor(152,152,152);
		$this->setTextColor(255,10,10);
		$this->Cell(196,4.5,'(Continue on separate sheet if necessary)',1,0,'C','1');
		$this->Ln();
		$this->SetFont('Arial','',9);
		$this->setFillColor(152,152,152);
		$this->setTextColor(255,255,255);
		$this->Cell(196,5,'VIII. OTHER INFORMATION',1,0,'L','1');
		$this->Ln();
		$this->SetFont('Arial','',7);
		$this->setTextColor(0,0,0);
		$this->Cell(50,12,'',1,0,'L');
		$this->Cell(92,12,'',1,0,'L');
		$this->Cell(54,12,'',1,0,'L');
		$this->Ln();		

		$this->Text(11,257,'31.');
		$this->Text(17,257,'SPECIAL SKILLS and HOBBIES');
		$this->Text(61,257,'32.');
		$this->Text(80,257,'NON-ACADEMIC DISTINCTIONS/ RECOGNITION');
		$this->Text(99,261,'(Write in full)');
		$this->Text(153,257,'33.');
		$this->SetFont('Arial','',6);

		$this->Text(156.5,257,'MEMBERSHIP IN ASSOCIATION/ORGANIZATION');
		$this->Text(174,260.5,'(Write in full)');
		$this->SetFont('Arial','',7);

	$eeother = $db->query("select * from other_info where employee_no='$_GET[prtid]' limit 1");
	if($other = $eeother->fetch(PDO::FETCH_OBJ)){
		$this->Text(13,267,substr($other->skill1,0,30));
		$this->Text(13,270,substr($other->skill1,30,30));
		$this->Text(62,267,substr($other->recog1,0,30));
		$this->Text(62,270,substr($other->recog1,30,30));
		$this->Text(154,267,substr($other->mem1,0,30));
		$this->Text(154,270,substr($other->mem1,30,30));

		$this->Text(13,273.7,substr($other->skill2,0,30));
		$this->Text(13,276.7,substr($other->skill2,30,30));
		$this->Text(62,273.7,substr($other->recog2,0,30));
		$this->Text(62,276.7,substr($other->recog2,30,30));
		$this->Text(154,273.7,substr($other->mem2,0,30));
		$this->Text(154,276.7,substr($other->mem2,30,30));

		$this->Text(13,280.4,substr($other->skill3,0,30));
		$this->Text(13,283.4,substr($other->skill3,30,30));
		$this->Text(62,280.4,substr($other->recog3,0,30));
		$this->Text(62,283.4,substr($other->recog3,30,30));
		$this->Text(154,280.4,substr($other->mem3,0,30));
		$this->Text(154,283.4,substr($other->mem3,30,30));

		$this->Text(13,287.3,substr($other->skill4,0,30));
		$this->Text(13,290.3,substr($other->skill4,30,30));
		$this->Text(62,287.3,substr($other->recog4,0,30));
		$this->Text(62,290.3,substr($other->recog4,30,30));
		$this->Text(154,287.3,substr($other->mem4,0,30));
		$this->Text(154,290.3,substr($other->mem4,30,30));

		$this->Text(13,294.7,substr($other->skill5,0,30));
		$this->Text(13,297.7,substr($other->skill5,30,30));
		$this->Text(62,293.7,substr($other->recog5,0,30));
		$this->Text(62,297.7,substr($other->recog5,30,30));
		$this->Text(154,293.7,substr($other->mem5,0,30));
		$this->Text(154,297.7,substr($other->mem5,30,30));
	}

		for ($ctr4 = 1; $ctr4 <= 7; $ctr4++) {
		$this->Cell(50,6.7,'',1,0,'L');
		$this->Cell(92,6.7,'',1,0,'L');
		$this->Cell(54,6.7,'',1,0,'L');
		$this->Ln();
		}
		$this->SetFont('Arial','',7);
		$this->setFillColor(152,152,152);
		$this->setTextColor(255,10,10);
		$this->Cell(196,4.5,'(Continue on separate sheet if necessary)',1,0,'C','1');
		$this->Ln();
		$this->SetFont('Arial','B',8);
		$this->setTextColor(0,0,0);
		$this->Cell(40,8,'SIGNATURE',1,0,'C');
		$this->Cell(60,8,'',1,0,'C');
		$this->Cell(12,8,'DATE',1,0,'C');
		$this->Cell(38,8,'',1,0,'C');
		$this->SetFont('Arial','',6.2);
		$this->Cell(46,8,'CS FORM 212(Revised 2017), ',1,0,'L');
		$this->Ln();


	$eetrain = $db->query("select * from training where employee_no='$_GET[prtid]'");
		$ytrain = 113;
		$ctrtrain = 1;
	while($train = $eetrain->fetch(PDO::FETCH_OBJ)){
		$newtfrom = date("m/d/Y", strtotime($train->tfrom));
		$newtto = date("m/d/Y", strtotime($train->tto));

		$this->Text(13,$ytrain-1.5,substr($train->title,0,50));
		$this->Text(13,$ytrain+1.5,substr($train->title,50,50));
		$this->Text(102,$ytrain,$newtfrom);
		$this->Text(116.2,$ytrain,$newtto);		
		$this->Text(137,$ytrain,$train->hours);
		$this->Text(148.2,$ytrain,'XXX');
		$this->Text(166,$ytrain-1.5,substr($train->conducted_by,0,24));
		$this->Text(166,$ytrain+1.5,substr($train->conducted_by,24,24));
		$ytrain=$ytrain + 6.7;
		$ctrtrain=$ctrtrain + 1;

		if ($ctrtrain==21) {
			$this->Addpage('P','legal',0);
			$this->SetFont('Arial','',9);
			$this->setFillColor(152,152,152);
			$this->setTextColor(255,255,255);
			$this->Cell(196,10,'',1,0,'L','1');
			$this->Text(11,14, 'VII. LEARNING AND DEVELOPMENT (L&D) INTERVENTIONS/ TRAINING PROGRAMS ATTENDED');
			$this->SetFont('Arial','I',6);
			$this->Text(11,18, '(Start from the most recent L&D training program and include only the relevant L&D/ training taken for the last five (5) years for Division Chief/Executive/Managerial positions)');

			$this->SetFont('Arial','',6);
			$this->setTextColor(0,0,0);
			$this->Text(11,26,'30.');
			$this->Text(15,26,'TITLE OF LEARNING AND DEVELOPMENT INTERVENTIONS/ TRAINING PROGRAMS');
			$this->Text(49,29,'(Write in full)');
			$this->Text(15,37,'(Cont...)');
			$this->SetFont('Arial','',7);
			$this->Text(104,26,'INCLUSIVE DATES');
			$this->Text(108,30,'(mm/dd/yyyy)');
			$this->Text(133.3,28,'NUMBER');
			$this->Text(132,32,'OF HOURS');
			$this->SetFont('Arial','',6.5);
			$this->Text(150,25,'Type of ID');
			$this->Text(149,28,'(Managerial/');
			$this->Text(149.3,31,'Supervisory/');
			$this->Text(148,34,'Technical/etc)');
			$this->SetFont('Arial','',7);
			$this->Text(166,28,'CONDUCTED/ SPONSORED BY');
			$this->Text(178,32,'(Write in full)');

			$this->Ln();
			$this->SetFont('Arial','',7);
			$this->Cell(90,19,'',1,0,'L');
			$this->Cell(30,14,'',1,0,'L');
			$this->Cell(17,19,'',1,0,'L');
			$this->Cell(17,19,'',1,0,'0');
			$this->Cell(42,19,'',1,0,'0');
			$this->Cell(1,14,'',0,0,'L');
			$this->Ln();
			$this->Cell(90,5,'',0,0,'L');
			$this->Cell(15,5,'FROM',1,0,'C');
			$this->Cell(15,5,'TO',1,0,'C');
			$this->Ln();
			$ytrain = 43;

			for ($ctr3 = 1; $ctr3 <= 41; $ctr3++) {
			$this->Cell(90,6.7,'',1,0,'L');
			$this->Cell(15,6.7,'',1,0,'L');
			$this->Cell(15,6.7,'',1,0,'L');
			$this->Cell(17,6.7,'',1,0,'L');
			$this->Cell(17,6.7,'',1,0,'L');
			$this->Cell(42,6.7,'',1,0,'L');
			$this->Ln();
			}
			$this->Cell(196,2.3,'',1,0,'C','1');
			$this->Ln();
			$this->SetFont('Arial','B',8);
			$this->setTextColor(0,0,0);
			$this->Cell(40,8,'SIGNATURE',1,0,'C');
			$this->Cell(60,8,'',1,0,'C');
			$this->Cell(12,8,'DATE',1,0,'C');
			$this->Cell(38,8,'',1,0,'C');
			$this->SetFont('Arial','',6.2);
			$this->Cell(46,8,'CS FORM 212(Revised 2017), ',1,0,'L');
		}
	}

	}

	function PDSPage04(){
		$this->SetFont('Arial','',7.4);
		$this->Text(11,13,'34. Are you related by consanguinity or affinity to the appointing or recommending authority, or to the');
		$this->Text(15.5,17,'chief of bureau or office or to the person who has immediate supervision over you in the Office,');
		$this->Text(15.5,21,'Bureau or Department where you will be appointed.');
		$this->Text(15.5,25,'a. within the third degree?');
			$this->Rect(140,23,2.5,2.5); $this->Rect(160,23,2.5,2.5);
			$this->Text(145,25,'YES'); $this->Text(165,25,'NO');
			$this->Rect(140,27,2.5,2.5); $this->Rect(160,27,2.5,2.5);
			$this->Text(145,29,'YES'); $this->Text(165,29,'NO');
			$this->Text(140,35,'If YES, give details:');
			$this->Text(140,40,'___________________________________________');
		$this->Text(15.5,29,'b. within the fourth degree (for Local Government Unit - Career Employment)?');
		$this->Text(11,46,'35. a. Have you ever been found guilty of any administrative offense?');
		$this->Text(15.5,66,'b. Have you been criminally charged before any court');
			$this->Rect(140,44,2.5,2.5); $this->Rect(160,44,2.5,2.5);
			$this->Text(145,46,'YES'); $this->Text(165,46,'NO');
			$this->Text(140,52,'If YES, give details:');
			$this->Text(140,57,'___________________________________________');
			$this->Line(134,61,209,61);
			$this->Rect(140,64,2.5,2.5); $this->Rect(160,64,2.5,2.5);
			$this->Text(145,66,'YES'); $this->Text(165,66,'NO');
			$this->Text(140,72,'If YES, give details:');
			$this->Text(140,77,'___________________________________________');
		$this->Text(11,83.3,'36. Have you ever been convicted of any crime or violation of any law, decree, ordinance or regulation by');
		$this->Text(15.5,87.3,'any court or tribunal?');
			$this->Rect(140,81.3,2.5,2.5); $this->Rect(160,81.3,2.5,2.5);
			$this->Text(145,83.3,'YES'); $this->Text(165,83.3,'NO');
			$this->Text(140,89.3,'If YES, give details:');
			$this->Text(140,94.3,'___________________________________________');
		$this->Text(11,100,'37. Have you ever been separated from the service in any of the following modes: resignation,');
		$this->Text(15.5,104,'retirement, dropped from the rolls, dismissal, termination, end of term, finished contract or phased out');
		$this->Text(15.5,108,'(abolition) in the public or private sector?');
			$this->Rect(140,98.2,2.5,2.5); $this->Rect(160,98.2,2.5,2.5);
			$this->Text(145,100.2,'YES'); $this->Text(165,100.2,'NO');
			$this->Text(140,106.2,'If YES, give details:');
			$this->Text(140,111.2,'___________________________________________');
		$this->Text(11,117.5,'38. a. Have you ever been candidate in a national or local election held within the last year (except');
		$this->Text(15.5,121.5,'Barangay election)?');
		$this->Text(15.5,128.5,'b. Have you resigned from the government service during the three (3)-month period before the last');
		$this->Text(15.5,132.5,'election to promote/actively campaign for a national or local candidate?');
			$this->Rect(140,115.5,2.5,2.5); $this->Rect(160,115.5,2.5,2.5);
			$this->Text(145,117.5,'YES'); $this->Text(165,117.5,'NO');
			$this->Text(140,122,'If YES, give details: ___________________________');
			$this->Rect(140,126.5,2.5,2.5); $this->Rect(160,126.5,2.5,2.5);
			$this->Text(145,128.5,'YES'); $this->Text(165,128.5,'NO');
			$this->Text(140,133,'If YES, give details: ___________________________');
		$this->Text(11,138.5,'39. Have you acquired the status of an immigrant or permanent rsident of another country?');
			$this->Rect(140,136.5,2.5,2.5); $this->Rect(160,136.5,2.5,2.5);
			$this->Text(145,138.5,'YES'); $this->Text(165,138.5,'NO');
			$this->Text(140,143,'If YES, give details (country):');
			$this->Text(140,148,'___________________________________________');
		$this->Text(11,153,'40. Pursuant to: (a) Indigenous Peoples Act (RA 8371); (b) Magna Carta for Disabled Persons (RA');
		$this->Text(15.5,157,'7277); and (c) Solo Parents Welfare Act of 2000 (RA 8972), please answer the following items:');
		$this->Text(11,161,'a. Are you member of any indigenous group?');
		$this->Text(11,170,'b. Are you a person with disability?');
		$this->Text(11,179,'c. Are you a solo parent?');
			$this->Rect(140,159,2.5,2.5); $this->Rect(160,159,2.5,2.5);
			$this->Text(145,161,'YES'); $this->Text(165,161,'NO');
			$this->Text(140,165,'If YES, please specify: ________________________');
			$this->Rect(140,168,2.5,2.5); $this->Rect(160,168,2.5,2.5);
			$this->Text(145,170,'YES'); $this->Text(165,170,'NO');
			$this->Text(140,174,'If YES, please specify ID No: ___________________');
			$this->Rect(140,177,2.5,2.5); $this->Rect(160,177,2.5,2.5);
			$this->Text(145,179,'YES'); $this->Text(165,179,'NO');
			$this->Text(140,183,'If YES, please specify ID No: ___________________');

		$this->SetFont('Arial','',7);
		$this->Cell(124,33,'',1,0,'L');
		$this->Cell(75,33,'',1,0,'L');
		$this->Ln();
		$this->Cell(124,37,'',1,0,'L');
		$this->Cell(75,37,'',1,0,'L');
		$this->Ln();
		$this->Cell(124,17,'',1,0,'L');
		$this->Cell(75,17,'',1,0,'L');
		$this->Ln();
		$this->Cell(124,17,'',1,0,'L');
		$this->Cell(75,17,'',1,0,'L');
		$this->Ln();
		$this->Cell(124,21,'',1,0,'L');
		$this->Cell(75,21,'',1,0,'L');
		$this->Ln();
		$this->Cell(124,15,'',1,0,'L');
		$this->Cell(75,15,'',1,0,'L');
		$this->Ln();
		$this->Cell(124,37,'',1,0,'L');
		$this->Cell(75,37,'',1,0,'L');
		$this->Ln();
		$this->Cell(145,8,'41. REFERENCES',1,0,'L');
		$this->setTextColor(255,10,10);
		$this->Text(33,191.6,'(Person not related by consanquinity or affinity to applicant/ appointee)');
		$this->Ln();
		$this->setTextColor(0,0,0);
		$this->Cell(65,7,'NAME',1,0,'C');
		$this->Cell(50,7,'ADDRESS',1,0,'C');
		$this->Cell(30,7,'TEL. NO.',1,0,'C');
		$this->Ln();
		for ($ctr4 = 1; $ctr4 <= 3; $ctr4++) {
		$this->Cell(65,8,'',1,0,'C');
		$this->Cell(50,8,'',1,0,'C');
		$this->Cell(30,8,'',1,0,'C');
		$this->Ln();
		}
		$this->SetFont('Arial','',7.4);	
		$this->Text(11,230,'42. I declare under oath that I have personally accomplished this Personal Data Sheet which is a true, correct and complete');
		$this->Text(15.5,234,'statement pursuant to the provisions of pertinent laws, rules and regulations of the Republic of the Philippines. I');
		$this->Text(15.5,238,'authorize the agency head/ authorized representative to verify/validate the contents stated herein. I agree that any');
		$this->Text(15.5,242,'misrepresentation made in this document and its attachments shall cause the filing of administrative/criminal case/s');
		$this->Text(15.5,246,'against me.');
		$this->SetFont('Arial','',7);	

		$this->Text(15,259,'Government Issued ID');
		$this->SetFont('Arial','',4.8);	
		$this->Text(40.1,258.8,'(i.e. Passport, GSIS, SSS, PRC, Drivers License, etc.)');
		$this->SetFont('Arial','',7.4);	
		$this->Text(15,262.2,'PLEASE INDICATE ID Number and Date of Issuance');

		$this->Text(20,294.5,'SUBSCRIBED AND SWORN to before me this __________________________, affiant exhibiting his/her validly issued government ID as indicated above.');

		$this->Cell(145,27,'',1,0,'C');
		$this->Ln();
		$this->Cell(145,3,'',0,0,'C');
		$this->Ln();	
		$this->Cell(4,8,'',0,0,'C');
		$this->Cell(67.5,8,'',1,0,'C');
		$this->Cell(6,8,'',0,0,'C');
		$this->Cell(67.5,18,'',1,0,'C');
		$this->Cell(1,8,'',0,0,'C');
		$this->Ln();
		$this->SetFont('Arial','',6);
		$this->Cell(4,8,'',0,0,'C');
		$this->Cell(67.5,7,'Government Issued ID:',1,0,'L');
		$this->Ln();
		$this->Cell(4,8,'',0,0,'C');
		$this->Cell(67.5,7,'ID/License/Passport No.:',1,0,'L');
		$this->Cell(6,4,'',0,0,'C');
		$this->Cell(67.5,3,'',0,0,'C');
		$this->Cell(1,3,'',0,0,'C');
		$this->Ln();
		$this->Cell(4,4,'',0,0,'C');
		$this->Cell(67.5,4,'',0,0,'L');
		$this->Cell(6,4,'',0,0,'C');
		$this->Cell(67.5,4,'Signature (Sign inside the box)',1,0,'C');
		$this->Ln();
		$this->Cell(4,8,'',0,0,'C');
		$this->Cell(67.5,7,'Date/Place of Issuance:',1,0,'L');
		$this->Cell(6,4,'',0,0,'C');
		$this->Cell(67.5,3,'',1,0,'C');
		$this->Ln();
		$this->Cell(4,4,'',0,0,'C');
		$this->Cell(67.5,4,'',0,0,'C');
		$this->Cell(6,4,'',0,0,'C');
		$this->Cell(67.5,4,'Date Accomplished',1,0,'C');
		$this->Cell(6,4,'',0,0,'C');
		$this->Cell(42,4,'Right Thumbmark',1,0,'C');
		$this->Ln();
		$this->Cell(196,4,'',0,0,'C');
		$this->Ln();
		$this->Cell(199,34,'',1,0,'C');
		$this->Cell(1,8,'',0,0,'C');
		$this->Ln();
		$this->Cell(66,17,'',0,0,'C');
		$this->Cell(66,17,'',1,0,'C');
		$this->Ln();
		$this->Cell(66,6,'',0,0,'C');
		$this->Cell(66,6,'',1,0,'C');

		$this->Line(166, 195, 166, 238);
		$this->Line(198, 195, 198, 238);
		$this->Line(166, 195, 198, 195);
		$this->Line(166, 238, 198, 238);
		$this->Text(179,242,'PHOTO');

		$this->Line(10, 253, 10, 289);
		$this->Line(209, 187, 209, 289);
		$this->Line(161, 250, 161, 281);
		$this->Line(203, 250, 203, 281);
		$this->Line(161, 250, 203, 250);
		$this->SetFont('Arial','',9);		
		$this->Text(89.5,317.7,'Person Administering Oath');

		//$this->Line(10, 253, 10, 289);
		//$this->Line(10, 253, 10, 289);


	}

	function header(){
	}
	function footer(){
		$this->SetY(-40.5);
		$this->SetFont('Arial','',6.7);
		$this->Cell(198,10,'Page '.$this->PageNo().' of {nb}',0,0,'R');
	}

}


$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->Addpage('P','legal',0);
$pdf->PDSPage01($db);
$pdf->Addpage('P','legal',0);
$pdf->PDSPage02($db);
$pdf->Addpage('P','legal',0);
$pdf->PDSPage03($db);
$pdf->Addpage('P','legal',0);
$pdf->PDSPage04();
$pdf->Output();