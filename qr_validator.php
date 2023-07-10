<?php
// Retrieve the QR code data from the POST request
$qrCode = $_POST['qrCode'];
// Path to the CSV file
$csvFile = 'data.csv';
// Read the CSV file
$csvData = file_get_contents($csvFile);
// Convert CSV data to an associative array
$lines = explode(PHP_EOL, $csvData);
$header = str_getcsv(array_shift($lines));
$studentData = [];
foreach ($lines as $line) {
    $row = array_combine($header, str_getcsv($line));
    $studentData[] = $row;
}
// Find the student information based on the QR code
$studentInfo = findStudentInfo($studentData,  $qrCode);
// Prepare the student information as an associative array
if ($studentInfo !== null) {
    $studentName = $studentInfo['name'];
    $studentClass = $studentClass['class'];
    $rollNumber = $studentInfo['roll'];
    $status = 'Valid QR Code';
} else {
    $studentName = 'Unknown';
    $studentClass = 'Unknown';
    $rollNumber = '';
    $status = 'Invalid QR Code';
}
$studentInfo = [
    'name' => $studentName,
    'class'=> $studentClass,
    'roll' => $rollNumber,
    'status' => $status
];

// Send the student information back as JSON
echo json_encode($studentInfo);

/**
 * Find the student information in the given data based on the QR code.
 *
 * @param array $studentData An array containing the student data
 * @param string $qrCode The QR code to search for
 * @return array|null The student information if found, null otherwise
 */
function findStudentInfo($studentData, $qrCode)
{
    foreach ($studentData as $student) {
        if ($student['qr_code'] === $qrCode) {
            return $student;
        }
    }
    return null;
}
?>
