-- create and select the database

CREATE DATABASE ShopEase;
USE ShopEase;

-- create the tables for the database
CREATE TABLE customers (
  customerID        INT            NOT NULL   AUTO_INCREMENT,
  emailAddress      VARCHAR(255)   NOT NULL,
  password          VARCHAR(60)    NOT NULL,
  firstName         VARCHAR(60)    NOT NULL,
  lastName          VARCHAR(60)    NOT NULL,
  shipAddressID     INT                       DEFAULT NULL,
  billingAddressID  INT                       DEFAULT NULL,  
  PRIMARY KEY (customerID),
  UNIQUE INDEX emailAddress (emailAddress)
);

CREATE TABLE addresses (
  addressID         INT            NOT NULL   AUTO_INCREMENT,
  customerID        INT            NOT NULL,
  line1             VARCHAR(60)    NOT NULL,
  line2             VARCHAR(60)               DEFAULT NULL,
  city              VARCHAR(40)    NOT NULL,
  province            VARCHAR(2)     NOT NULL,
  postalCode           VARCHAR(10)    NOT NULL,
  phone             VARCHAR(12)    NOT NULL,
  disabled          TINYINT(1)     NOT NULL   DEFAULT 0,
  PRIMARY KEY (addressID),
  INDEX customerID (customerID)
);

CREATE TABLE orders (
  orderID           INT            NOT NULL   AUTO_INCREMENT,
  customerID        INT            NOT NULL,
  orderDate         DATETIME       NOT NULL,
  shipAmount        DECIMAL(10,2)  NOT NULL,
  taxAmount         DECIMAL(10,2)  NOT NULL,
  shipDate          DATETIME                  DEFAULT NULL,
  shipAddressID     INT            NOT NULL,
  cardType          CHAR(1)        NOT NULL,
  cardNumber        CHAR(16)       NOT NULL,
  cardExpires       CHAR(7)        NOT NULL,
  billingAddressID  INT            NOT NULL,
  PRIMARY KEY (orderID), 
  INDEX customerID (customerID)
);

CREATE TABLE orderItems (
  itemID            INT            NOT NULL   AUTO_INCREMENT,
  orderID           INT            NOT NULL,
  productID         INT            NOT NULL,
  itemPrice         DECIMAL(10,2)  NOT NULL,
  discountAmount    DECIMAL(10,2)  NOT NULL,
  quantity          INT NOT NULL,
  PRIMARY KEY (itemID), 
  INDEX orderID (orderID), 
  INDEX productID (productID)
);

CREATE TABLE products (
  productID         INT            NOT NULL   AUTO_INCREMENT,
  categoryID        INT            NOT NULL,
  productCode       VARCHAR(10)    NOT NULL,
  productName       VARCHAR(255)   NOT NULL,
  description       TEXT           NOT NULL,
  listPrice         DECIMAL(10,2)  NOT NULL,
  discountPercent   DECIMAL(10,2)  NOT NULL   DEFAULT 0.00,
  dateAdded         DATETIME       NOT NULL,
  PRIMARY KEY (productID), 
  INDEX categoryID (categoryID), 
  UNIQUE INDEX productCode (productCode)
);

CREATE TABLE categories (
  categoryID        INT            NOT NULL   AUTO_INCREMENT,
  categoryName      VARCHAR(255)   NOT NULL,
  PRIMARY KEY (categoryID)
);

CREATE TABLE administrators (
  adminID           INT            NOT NULL   AUTO_INCREMENT,
  emailAddress      VARCHAR(255)   NOT NULL,
  password          VARCHAR(255)   NOT NULL,
  firstName         VARCHAR(255)   NOT NULL,
  lastName          VARCHAR(255)   NOT NULL,
  PRIMARY KEY (adminID)
);

-- Insert data into the tables
INSERT INTO categories (categoryID, categoryName) VALUES
(1, 'TV & Home Theatre'),
(2, 'Computers & Tablets'),
(3, 'Gaming & Consoles');

INSERT INTO products (productID, categoryID, productCode, productName, description, listPrice, discountPercent, dateAdded) VALUES
-- Products for 'TV & Home Theatre'
INSERT INTO products (productID, categoryID, productCode, productName, description, listPrice, discountPercent) VALUES
(1, 1, 'TV01', 'Samsung 65" QLED TV', '4K Ultra HD Smart TV with Quantum Dot technology.', 1200.00, 10),
(2, 1, 'HT01', 'Sony Soundbar 5.1', 'High-quality soundbar with Dolby Atmos and wireless subwoofer.', 500.00, 15),
(3, 1, 'TV02', 'LG 55" OLED TV', 'Stunning OLED display with AI-powered 4K resolution.', 1400.00, 12),
(4, 1, 'HT02', 'Bose Home Theatre System', 'Premium 7.1 surround sound system for immersive experience.', 2000.00, 8);

-- Products for 'Computers & Tablets'
INSERT INTO products (productID, categoryID, productCode, productName, description, listPrice, discountPercent) VALUES
(5, 2, 'PC01', 'Apple MacBook Pro 14"', 'M2 chip, 16GB RAM, 512GB SSD, Silver', 2400.00, 5),
(6, 2, 'TB01', 'Microsoft Surface Pro 9', '12.3" 2-in-1 tablet with Intel i7, 16GB RAM, and 256GB SSD.', 1500.00, 7),
(7, 2, 'PC02', 'Dell XPS 13', 'Ultra-portable laptop with Intel i5, 8GB RAM, and 512GB SSD.', 1100.00, 10),
(8, 2, 'TB02', 'iPad Pro 12.9"', 'Apple iPad Pro with M2 chip, 128GB storage, and Liquid Retina display.', 1100.00, 5);

-- Products for 'Gaming & Consoles'
INSERT INTO products (productID, categoryID, productCode, productName, description, listPrice, discountPercent) VALUES
(9, 3, 'GM01', 'Sony PlayStation 5', 'Next-gen gaming console with 4K gaming and ultra-fast SSD.', 500.00, 0),
(10, 3, 'GM02', 'Xbox Series X', 'Powerful gaming console with 1TB SSD and 4K gaming.', 500.00, 0),
(11, 3, 'GM03', 'Nintendo Switch OLED', 'Hybrid console with 7" OLED screen and enhanced audio.', 350.00, 5),
(12, 3, 'GM04', 'Razer Kishi Mobile Controller', 'Universal gaming controller for mobile devices.', 100.00, 10);

-- pwd for each: P2ssw0rd
INSERT INTO customers (customerID, emailAddress, password, firstName, lastName, shipAddressID, billingAddressID) VALUES
(1, 'allan.sherwood@yahoo.com', '$2y$10$sSwVEIaeLp6or4DG37l5xuh3./PRNLZzntsbneQmkRUTMyyBzkgyW', 'Allan', 'Sherwood', 1, 2),  
(2, 'barryz@gmail.com', '$2y$10$sSwVEIaeLp6or4DG37l5xuh3./PRNLZzntsbneQmkRUTMyyBzkgyW', 'Barry', 'Zimmer', 3, 4),
(3, 'christineb@solarone.com', '$2y$10$sSwVEIaeLp6or4DG37l5xuh3./PRNLZzntsbneQmkRUTMyyBzkgyW', 'Christine', 'Brown', 5, 6);

INSERT INTO addresses (addressID, customerID, line1, line2, city, state, zipCode, phone, disabled) VALUES
(1, 1, '100 East Ridgewood Ave.', '', 'Paramus', 'NJ', '07652', '201-653-4472', 0),
(2, 1, '21 Rosewood Rd.', '', 'Woodcliff Lake', 'NJ', '07677', '201-653-4472', 0),
(3, 2, '16285 Wendell St.', '', 'Omaha', 'NE', '68135', '402-896-2576', 0),
(4, 2, '16285 Wendell St.', '', 'Omaha', 'NE', '68135', '402-896-2576', 0),
(5, 3, '19270 NW Cornell Rd.', '', 'Beaverton', 'OR', '97006', '503-654-1291', 0),
(6, 3, '19270 NW Cornell Rd.', '', 'Beaverton', 'OR', '97006', '503-654-1291', 0);

INSERT INTO orders (orderID, customerID, orderDate, shipAmount, taxAmount, shipDate, shipAddressID, cardType, cardNumber, cardExpires, billingAddressID) VALUES
(1, 1, '2022-01-31 09:40:28', '5.00', '32.32', '2022-02-03 09:43:13', 1, 'v', '4111111111111111', '04/2022', 2),
(2, 2, '2022-02-01 11:23:20', '5.00', '0.00', NULL, 3, 'v', '4111111111111111', '08/2025', 4),
(3, 1, '2022-02-03 09:44:58', '10.00', '89.92', NULL, 1, 'm', '4111111111111111', '04/2026', 2);

INSERT INTO orderItems (itemID, orderID, productID, itemPrice, discountAmount, quantity) VALUES
(1, 1, 2, '399.00', '39.90', 1),
(2, 2, 4, '699.00', '69.90', 1),
(3, 3, 3, '499.00', '49.90', 1),
(4, 3, 6, '549.99', '0.00', 1);

-- pwd for admin@myguitarshop.com: s3sam3
INSERT INTO administrators (adminID, emailAddress, password, firstName, lastName) VALUES
(1, 'admin@myguitarshop.com', '$2y$10$xIqN2cVy8HVuKNKUwxFQR.xRP9oRj.FF8r52spVc.XCaEFy7iLHmu', 'Admin', 'User'),
(2, 'joel@murach.com', '$2y$10$xIqN2cVy8HVuKNKUwxFQR.xRP9oRj.FF8r52spVc.XCaEFy7iLHmu', 'Joel', 'Murach'),
(3, 'mike@murach.com', '$2y$10$xIqN2cVy8HVuKNKUwxFQR.xRP9oRj.FF8r52spVc.XCaEFy7iLHmu', 'Mike', 'Murach');

-- create the user
CREATE USER IF NOT EXISTS mgs_user@localhost 
IDENTIFIED BY 'pa55word';

-- grant privileges to the user
GRANT SELECT, INSERT, UPDATE, DELETE
ON * 
TO mgs_user@localhost;