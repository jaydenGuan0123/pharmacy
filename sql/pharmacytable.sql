CREATE TABLE IF NOT EXISTS `pharmacy`.`user` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(100) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `role` VARCHAR(100) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert into the `user` table
INSERT INTO `pharmacy`.`user` (`username`, `password`, `email`, `role`)
SELECT 'JaydenGuan', 'password123', 'jayden.guanid@example.com', 'doctor'
FROM DUAL
WHERE NOT EXISTS (
    SELECT 1 
    FROM `pharmacy`.`user` 
    WHERE `username` = 'JaydenGuan'
);

-- Create the `patient` table
CREATE TABLE IF NOT EXISTS `pharmacy`.`patient` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `DOB` VARCHAR(100) NOT NULL,
    `email` VARCHAR(255),
    `phone` VARCHAR(20) NOT NULL,
    `address` VARCHAR(255),
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert into the `medicine` table
INSERT INTO `pharmacy`.`medicine` (`name`, `price`, `stock`)
SELECT 'Paracetamol', 10.00, 100
WHERE NOT EXISTS (
    SELECT 1 
    FROM `pharmacy`.`medicine` 
    WHERE `name` = 'Paracetamol'
);

INSERT INTO `pharmacy`.`medicine` (`name`, `price`, `stock`)
SELECT 'Ibuprofen', 15.00, 100
WHERE NOT EXISTS (
    SELECT 1 
    FROM `pharmacy`.`medicine` 
    WHERE `name` = 'Ibuprofen'
);

INSERT INTO `pharmacy`.`medicine` (`name`, `price`, `stock`)
SELECT 'Aspirin', 5.00, 100
WHERE NOT EXISTS (
    SELECT 1 
    FROM `pharmacy`.`medicine` 
    WHERE `name` = 'Aspirin'
);

-- Create the `medicine` table
CREATE TABLE IF NOT EXISTS `pharmacy`.`medicine` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `description` TEXT,
    `price` DECIMAL(10, 2) NOT NULL,
    `stock` INT NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create the `prescription` table
CREATE TABLE IF NOT EXISTS `pharmacy`.`prescription` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `patient_id` INT NOT NULL,
    `doctor_id` INT NOT NULL,
    `medicine_id` INT NOT NULL,
    `date` DATE NOT NULL,
    `note` TEXT,
    `quantity` INT NOT NULL,
    `status` VARCHAR(100) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `accepted_by` INT,
    FOREIGN KEY (`accepted_by`) REFERENCES `user`(`id`),
    FOREIGN KEY (`patient_id`) REFERENCES `patient`(`id`),
    FOREIGN KEY (`doctor_id`) REFERENCES `user`(`id`),
    FOREIGN KEY (`medicine_id`) REFERENCES `medicine`(`id`)
);

-- Create the `message` table
CREATE TABLE IF NOT EXISTS `pharmacy`.`message` (
    `Receiver` VARCHAR(100) NOT NULL,
    `Sender` VARCHAR(100) NOT NULL,
    `Message` TEXT NOT NULL,
    `Date` DATE NOT NULL,
    `subject` VARCHAR(100) NOT NULL,
    FOREIGN KEY (`Receiver`) REFERENCES `pharmacist`(`username`),
    FOREIGN KEY (`Sender`) REFERENCES `pharmacist`(`username`)
);