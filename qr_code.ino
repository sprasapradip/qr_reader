// #include <SoftwareSerial.h>
// // RX, TX pins connected to the QR code reader module
// String studentName = "";
// String rollNumber = "";
// void setup() {
//   Serial.begin(9600);
//   qrSerial.begin(9600);
// }
// void loop() {
//   if (qrSerial.available()) {
//     char receivedChar = qrSerial.read(); 
//     if (receivedChar == '\n') {
//       if (studentName.length() > 0 && rollNumber.length() > 0) {
//         sendToHTML(studentName, rollNumber);
//         studentName = "";
//         rollNumber = "";
//       }
//     }
//     else {
//       studentName += receivedChar;
//     }
//   }
// }
// void sendToHTML(String name, String roll) {
//   Serial.print("<html><body>");
//   Serial.print("<h1>Student Information:</h1>");
//   Serial.print("<p>Name: " + name + "</p>");
//   Serial.print("<p>Roll Number: " + roll + "</p>");
//   Serial.print("</body></html>");
// }


#include <SoftwareSerial.h>

// RX, TX pins connected to the QR code reader module
SoftwareSerial qrSerial(10, 11);  // Change the pins as per your setup

String studentName = "";
String rollNumber = "";

void setup() {
  Serial.begin(9600);
  qrSerial.begin(9600);
}
void loop() {
  if (qrSerial.available()) {
    char receivedChar = qrSerial.read();
    if (receivedChar == '\n') {
      if (studentName.length() > 0 && rollNumber.length() > 0) {
        sendToHTML(studentName, rollNumber);
        studentName = "";
        rollNumber = "";
      }
    } else {
      studentName += receivedChar;
    }
  }

  // Additional feature: Check for serial input from the computer
  if (Serial.available()) {
    char inputChar = Serial.read();
    if (inputChar == 'r' || inputChar == 'R') {
      resetData();
    }
  }
}

void sendToHTML(String name, String roll) {
  Serial.print("<html><body>");
  Serial.print("<h1>Student Information:</h1>");
  Serial.print("<p>Name: " + name + "</p>");
  Serial.print("<p>Roll Number: " + roll + "</p>");
  Serial.print("</body></html>");
}




