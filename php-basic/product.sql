CREATE TABLE products(
  id int PRIMARY KEY AUTO_INCREMENT,
  name varchar(150) NOT NULL,
  quantity int  NOT NULL,
  price decimal(6,2) NOT NULL,
  produced_date Date
);

INSERT INTO `products` (`name`, `quantity`, `price`, `produced_date`) VALUES
('Product 1', '1', '15.00', '2022/02/15'), 
('Product 2', '8', '20.00', '2022/02/16'), 
('Product 3', '3', '50.00', '2022/02/17'), 
('Product 4', '7', '55.00', '2022/02/18'), 
('Product 5', '4', '54.00', '2022/02/19'), 
('Product 6', '5', '34.00', '2022/02/20');
