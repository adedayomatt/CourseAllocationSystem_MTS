<?php
/*******************This part is to set up the database and the tables****************/
$_connection = mysqli_connect(config::$db_host,config::$db_user,config::$db_password);
	$db_name = str_replace(array(' ',','),'_',config::$department);
	mysqli_select_db($_connection,config::$department);
if($_connection){
	$_create_db = mysqli_query($_connection,"CREATE DATABASE IF NOT EXISTS ".$db_name." DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci");
	
	if($_create_db){
		
	mysqli_select_db($_connection,$db_name);
	
	$_create_courses_table = mysqli_query($_connection,"CREATE TABLE `courses`
						   (`course_code` char(20) NOT NULL,
						  `course_title` char(255) NOT NULL,
						  `course_unit` int(1) NOT NULL,
						  `level` int(3) NOT NULL,
						  `course_scope` varchar(1000) NOT NULL,
						  `lecturer_in_charge` char(255) NOT NULL)
						ENGINE=InnoDB DEFAULT CHARSET=latin1;");
						
	
	$_add_course_primary_key = mysqli_query($_connection,"ALTER TABLE `courses` ADD PRIMARY KEY (`course_code`)");
		

	
	$_create_lecturer_table = mysqli_query($_connection,"CREATE TABLE `lecturer` 
							(`id` int(50) NOT NULL,
							  `title` char(10) NOT NULL,
							  `last_name` char(255) NOT NULL,
							  `initial` char(5) NOT NULL,
							  `specialization` char(255) NOT NULL)
							  ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Lecturer''s entity'");
	
	$_add_lecturer_primary_key = mysqli_query($_connection,"ALTER TABLE `lecturer` ADD PRIMARY KEY (`id`)");
	
	if(mysqli_num_rows(mysqli_query($_connection,"SELECT id FROM lecturer")) == 0){//if no lecturer record exist yet
//Add all lecturers initially
$lecturers = array(
				array('title' => 'Prof.','last_name' => 'Omeike', 'initial' => 'M.O.', 'specialization' => 'Differntial Equations'),
				array('title' => 'Prof.','last_name' => 'Oguntuase', 'initial' => 'J.A.', 'specialization' => 'Inequality'),
				array('title' => 'Prof.','last_name' => 'Adeniran', 'initial' => 'O.J.', 'specialization' => 'Theory of Loops, Non Associative Algebra'),
				array('title' => 'Prof.','last_name' => 'Agboola', 'initial' => 'A.A.A.', 'specialization' => 'Fuzzy Set and Fuzzy Algebraic Structures'),
				array('title' => 'Prof.','last_name' => 'Ayoola', 'initial' => 'E.O.', 'specialization' => 'Stochastic Differntial Equations'),
				array('title' => 'Prof.','last_name' => 'Olajuwon', 'initial' => 'B.I.', 'specialization' => 'Fluid Mechanics'),
				array('title' => 'Dr.','last_name' => 'Enioluwafe', 'initial' => 'M.', 'specialization' => 'Pure Mechanics, Theory of P-Groups'),
				array('title' => 'Dr.','last_name' => 'Osinuga', 'initial' => 'I.A.', 'specialization' => 'Optimization Theory'),
				array('title' => 'Dr.','last_name' => 'Akinleye', 'initial' => 'S.A.', 'specialization' => 'Modelling, Theory of Loops'),
				array('title' => 'Dr.','last_name' => 'Adeleke', 'initial' => 'E.O.', 'specialization' => 'Probability Theory'),
				array('title' => 'Dr.','last_name' => 'Ilojide', 'initial' => 'E.', 'specialization' => 'Algebra'),
				array('title' => 'Dr.','last_name' => 'Sonubi', 'initial' => 'A.A.', 'specialization' => 'Financial Mathematics'),
				array('title' => 'Dr.','last_name' => 'Ogunsola', 'initial' => 'O.J.', 'specialization' => 'Banach Algebra'),
				array('title' => 'Mr.','last_name' => 'Adams', 'initial' => 'D.O', 'specialization' => 'Ordinary Differntial Equation'),
				array('title' => 'Mr.','last_name' => 'Oyelakin', 'initial' => 'I.S.', 'specialization' => 'Fluid Dynamics'),
				array('title' => 'Mr.','last_name' => 'Adeyanju', 'initial' => 'A.A.', 'specialization' => 'Financial Mathematics'),
				array('title' => 'Mr.','last_name' => 'Yusuf', 'initial' => 'A.A.', 'specialization' => 'Complex Analysis')
				);

	$_add_lecturer_stmt = mysqli_prepare($_connection,"INSERT INTO `lecturer` (`id`, `title`, `last_name`, `initial`, `specialization`) VALUES(?,?,?,?,?)");
							mysqli_stmt_bind_param($_add_lecturer_stmt, 'issss', $id,$title,$last_name,$initial,$spec);
		for($l = 0; $l< count($lecturers); $l++){
			$id = time() + rand(1000,9999);
			$title = $lecturers[$l]['title'];
			$last_name = $lecturers[$l]['last_name'];
			$initial = $lecturers[$l]['initial'];
			$spec = $lecturers[$l]['specialization'];
		mysqli_stmt_execute($_add_lecturer_stmt);
		}
	}

	if(mysqli_num_rows(mysqli_query($_connection,"SELECT course_code FROM courses")) == 0){//if no course exist yet	
//Add all courses initially
$courses = array(
//100 Level Courses
		array('code' => 'MTS 101','title' => 'Algebra','unit' => '3','level' => '100','scope' => '','lecturer' => ''),
		array('code' => 'MTS 103','title' => 'Vectors and Geometry','unit' => '2','level' => '100','scope' => '','lecturer' => ''),
		array('code' => 'MTS 105','title' => 'Algebra and Trigonometry for Biological Sciences','unit' => '3','level' => '100','scope' => '','lecturer' => ''),
		array('code' => 'MTS 102','title' => 'Calculus and Trigonometry','unit' => '3','level' => '100','scope' => '','lecturer' => ''),
		array('code' => 'MTS 104','title' => 'Introduction to Mechanics','unit' => '3','level' => '100','scope' => '','lecturer' => ''),
		array('code' => 'MTS 106','title' => 'Calculus for Biological Sciences','unit' => '3','level' => '100','scope' => '','lecturer' => ''),
//200 Level Courses
		array('code' => 'MTS 201','title' => 'Mathematical Foundation','unit' => '3','level' => '200','scope' => '','lecturer' => ''),
		array('code' => 'MTS 211','title' => 'Abstract Algebra','unit' => '3','level' => '200','scope' => '','lecturer' => ''),
		array('code' => 'MTS 223','title' => 'Real Analysis I','unit' => '3','level' => '200','scope' => '','lecturer' => ''),
		array('code' => 'MTS 241','title' => 'Mathematical Method I','unit' => '3','level' => '200','scope' => '','lecturer' => ''),
		array('code' => 'MTS 251','title' => 'Numerical Analysis I','unit' => '2','level' => '200','scope' => '','lecturer' => ''),
		array('code' => 'MTS 206','title' => 'Mechanics','unit' => '3','level' => '200','scope' => '','lecturer' => ''),
		array('code' => 'MTS 212','title' => 'Linear Algebra','unit' => '3','level' => '200','scope' => '','lecturer' => ''),
		array('code' => 'MTS 242','title' => 'Ordinary Differntial Equation','unit' => '3','level' => '200','scope' => '','lecturer' => ''),
		array('code' => 'MTS 214','title' => 'Complex Analysis I','unit' => '3','level' => '200','scope' => '','lecturer' => ''),
//300 Level Courses
		array('code' => 'MTS 311','title' => 'Groups and Rings','unit' => '3','level' => '300','scope' => '','lecturer' => ''),
		array('code' => 'MTS 323','title' => 'Real Analysis II','unit' => '3','level' => '300','scope' => '','lecturer' => ''),
		array('code' => 'MTS 363','title' => 'Operations Research I','unit' => '2','level' => '300','scope' => '','lecturer' => ''),
		array('code' => 'MTS 351','title' => 'Numerical Analysis II','unit' => '2','level' => '300','scope' => '','lecturer' => ''),
		array('code' => 'MTS 313','title' => 'Theory of Modules','unit' => '2','level' => '300','scope' => '','lecturer' => ''),
		array('code' => 'MTS 361','title' => 'Metric Spaces','unit' => '3','level' => '300','scope' => '','lecturer' => ''),
		array('code' => 'MTS 315','title' => 'Hydrodynamics','unit' => '2','level' => '300','scope' => '','lecturer' => ''),
		array('code' => 'MTS 351','title' => 'Numerical Analysis II','unit' => '3','level' => '300','scope' => '','lecturer' => ''),
		array('code' => 'MTS 307','title' => 'Analytical Dynamics','unit' => '2','level' => '300','scope' => '','lecturer' => ''),
		array('code' => 'MTS 392','title' => 'Industrial Training','unit' => '4','level' => '300','scope' => '','lecturer' => ''),
		array('code' => 'MTS 394','title' => 'Visitation','unit' => '4','level' => '300','scope' => '','lecturer' => ''),
		array('code' => 'MTS 396','title' => 'Industrial Training Report','unit' => '4','level' => '300','scope' => '','lecturer' => ''),
		array('code' => 'MTS 398','title' => 'Industrial Training Seminar','unit' => '4','level' => '300','scope' => '','lecturer' => ''),
//400 Level Courses
		array('code' => 'MTS 405','title' => 'Theory of Ordinary Differntial Equations','unit' => '3','level' => '400','scope' => '','lecturer' => ''),
		array('code' => 'MTS 421','title' => 'Complex Analysis II','unit' => '3','level' => '400','scope' => '','lecturer' => ''),
		array('code' => 'MTS 423','title' => 'Functional Analysis','unit' => '3','level' => '400','scope' => '','lecturer' => ''),
		array('code' => 'MTS 461','title' => 'General Topology','unit' => '3','level' => '400','scope' => '','lecturer' => ''),
		array('code' => 'MTS 411','title' => 'Commutative Algebra','unit' => '3','level' => '400','scope' => '','lecturer' => ''),
		array('code' => 'MTS 433','title' => 'Non-Associative Algebra I','unit' => '3','level' => '400','scope' => '','lecturer' => ''),
		array('code' => 'MTS 465','title' => 'Fuzzy Set I','unit' => '3','level' => '400','scope' => '','lecturer' => ''),
		array('code' => 'MTS 431','title' => 'Fluid mechanics I','unit' => '3','level' => '400','scope' => '','lecturer' => ''),
		array('code' => 'MTS 435','title' => 'Elasticity','unit' => '3','level' => '400','scope' => '','lecturer' => ''),
		array('code' => 'MTS 451','title' => 'Numerical Analysis III','unit' => '3','level' => '400','scope' => '','lecturer' => ''),
		array('code' => 'MTS 463','title' => 'Operations Research II','unit' => '3','level' => '400','scope' => '','lecturer' => ''),
		array('code' => 'MTS 469','title' => 'Optimization Theory','unit' => '3','level' => '400','scope' => '','lecturer' => ''),
		array('code' => 'MTS 424','title' => 'Lesbeque Measure and Theory of Integration','unit' => '3','level' => '400','scope' => '','lecturer' => ''),
		array('code' => 'MTS 442','title' => 'Partial Differntial Equations','unit' => '3','level' => '400','scope' => '','lecturer' => ''),
		array('code' => 'MTS 454','title' => 'Mathematical Modelling','unit' => '3','level' => '400','scope' => '','lecturer' => ''),
		array('code' => 'MTS 412','title' => 'Galois Theory','unit' => '3','level' => '400','scope' => '','lecturer' => ''),
		array('code' => 'MTS 434','title' => 'Non-Associative Algebra II','unit' => '3','level' => '400','scope' => '','lecturer' => ''),
		array('code' => 'MTS 466','title' => 'Fuzzy Sets II','unit' => '3','level' => '400','scope' => '','lecturer' => ''),
		array('code' => 'MTS 432','title' => 'Fluid Mechanics II','unit' => '3','level' => '400','scope' => '','lecturer' => ''),
		array('code' => 'MTS 436','title' => 'Elasticity II','unit' => '3','level' => '400','scope' => '','lecturer' => ''),
		array('code' => 'MTS 446','title' => 'Calculus of Variation','unit' => '3','level' => '400','scope' => '','lecturer' => ''),
		array('code' => 'MTS 499','title' => 'Project','unit' => '6','level' => '400','scope' => '','lecturer' => ''),

		);
		
	$_add_course_stmt = mysqli_prepare($_connection,"INSERT INTO `courses` (`course_code`, `course_title`, `course_unit`, `level`, `course_scope`, `lecturer_in_charge`) VALUES(?,?,?,?,?,?)");
					mysqli_stmt_bind_param($_add_course_stmt, 'ssiiss', $code,$title,$unit,$level,$scope,$lecturer);
		
		for($c = 0; $c< count($courses); $c++){
			$code = $courses[$c]['code'];
			$title = $courses[$c]['title'];
			$unit = $courses[$c]['unit'];
			$level = $courses[$c]['level'];
			$scope = $courses[$c]['scope'];
			$lecturer = $courses[$c]['lecturer'];
		mysqli_stmt_execute($_add_course_stmt);
		}		
	}	
		
		}
		mysqli_close($_connection);
}
else{
	echo "<h2 class=\"text-center\">Something went wrong</h2>";
}
/*******************************************************************************************/
