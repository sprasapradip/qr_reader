<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Path to the CSV file
$csvFile = 'data.csv';

// Retrieve the QR code data from the POST request
$qrCode = $_POST['qr_code'];

// Read the CSV file
$lines = file($csvFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$header = str_getcsv(array_shift($lines));
$studentData = [];
foreach ($lines as $line) {
    $row = array_combine($header, str_getcsv($line));
    $studentData[] = $row;
}

// Find the student information based on the QR code
$studentInfo = findStudentInfo($studentData, $qrCode);

// Prepare the student information as an associative array
if ($studentInfo !== null) {
    $studentName = $studentInfo['name'];
    $studentClass = $studentInfo['class'];
    $rollNumber = $studentInfo['roll'];
    $status = 'Valid QR Code';
} else {
    $studentName = 'Unknown';
    $studentClass = 'Unknown';
    $rollNumber = '';
    $status = 'Invalid QR Code';
}

// Prepare the student information as an associative array
$studentInfo = [
    'name' => $studentName,
    'class' => $studentClass,
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
