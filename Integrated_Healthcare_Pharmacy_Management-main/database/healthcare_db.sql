-- Table: patients
CREATE TABLE patients (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  age INT,
  gender VARCHAR(10),
  contact VARCHAR(15),
  address VARCHAR(255)
);

-- Table: doctors
CREATE TABLE doctors (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  specialization VARCHAR(100),
  contact VARCHAR(15),
  email VARCHAR(100)
);

-- Table: medicines
CREATE TABLE medicines (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  category VARCHAR(100),
  stock INT,
  price DECIMAL(10,2)
);

-- Table: prescriptions
CREATE TABLE prescriptions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  patient_id INT,
  doctor_id INT,
  medicine_id INT,
  dosage VARCHAR(100),
  date DATE,
  FOREIGN KEY (patient_id) REFERENCES patients(id),
  FOREIGN KEY (doctor_id) REFERENCES doctors(id),
  FOREIGN KEY (medicine_id) REFERENCES medicines(id)
);

-- Table: reports
CREATE TABLE reports (
  id INT AUTO_INCREMENT PRIMARY KEY,
  patient_id INT,
  report_type VARCHAR(100),
  report_date DATE,
  details TEXT,
  FOREIGN KEY (patient_id) REFERENCES patients(id)
);
