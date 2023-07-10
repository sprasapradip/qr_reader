#include <SoftwareSerial.h>
// Define the serial port pins
#define RX_PIN 10
#define TX_PIN 11

SoftwareSerial barcodeSerial(RX_PIN, TX_PIN); // Create a SoftwareSerial object

void setup() {
  Serial.begin(9600); // Initialize the Arduino serial port
  barcodeSerial.begin(9600); // Initialize the barcode scanner serial port
}

void loop() {
  if (barcodeSerial.available()) {
    String qrCode = barcodeSerial.readStringUntil('\n'); // Read the QR code from the scanner
    Serial.println(qrCode); // Print the QR code to the Arduino serial monitor
    // Send the QR code to the computer or web server via serial communication
    // You can use the Serial.print() or Serial.write() functions here
  }
}
