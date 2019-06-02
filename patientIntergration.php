<?php
/////////////////////////////////////////////////////////////////////
// Autor:Jean Janvier -> Singular Medical Technology (SMT)       ///
// Date: 2/1/18                                                 ///
// Purpose: compare old and new data, check for duplicate data ///
// Purpose: insert new data in database                       ///
// /////////////////////////////////////////////////////////////

echo "<br>";
error_reporting(E_ALL);
//ini_set('display_errors', 1);
include 'inc/db.php'; 

///////////////////////////////////////////////////////////////////////////////////////////
//covert dot CSV file to SQL query and import new data into the database              ////
//import file to the parent table                                                    ////
////////////////////////////////////////////////////////////////////////////////////////


///////////////////////////////////////////////////////////////////////////////////////////
// import file to the Parent table                                                    ////
// create a temporary child table "LIKE" parent to search for duplicate data         ////
// insert non duplicate data into the parent table                                  ////
///////////////////////////////////////////////////////////////////////////////////////

$parent = "temp1";

$sql= "CREATE TEMPORARY TABLE $parent LIKE account";
$result = $conn->query($sql);

//asign input to a variable
//im using this variable to name the input
//this should take the file and upload it 
$fileName = $_POST['fileName'];

//load data to hashedpassword
//$sql="LOAD DATA LOCAL INFILE 'edme.csv' INTO TABLE $parent
//this is my change on line 37
$sql="LOAD DATA LOCAL INFILE 'fileName' INTO TABLE $parent  
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '\"' 
LINES TERMINATED BY '\n'  IGNORE 1 LINES

(@col1,@col2,@col3)
set 
Patient_account = @col1,
patient_LN = @col2,
patient_FN  = @col3
";

$result = $conn->query($sql);
if ($result === TRUE) {
	

}
else echo mysqli_error($conn)."<br>";

///////////////////////////////////////////////////////////
// /////////////// PARENTS TABLE   ///////////////////////
/////////////////////////////////////////////////////////

$sql="INSERT INTO account
 SELECT  Patient_account, patient_LN, patient_FN FROM $parent group by Patient_account

ON DUPLICATE KEY UPDATE  patient_LN = VALUES(patient_LN), patient_FN = VALUES(patient_FN)";

$result = $conn->query($sql); //execute query

	if ($result === TRUE) {
echo "New data successfully entered!! <span>  </span> <img src='../images/check.png' height='15' width='15'>"."<br>";
}
else
 echo mysqli_error($conn)."<br>";
	
$sql="DROP TEMPORARY TABLE $parent";
$result = $conn->query($sql); //execute query
if($result==TRUE){
echo '<h3>Congratulations, You are the MVP of the team!!!!</h3>';
}

$conn->close();

?>