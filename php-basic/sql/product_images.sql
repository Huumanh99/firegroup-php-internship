CREATE TABLE product_images(
  id int PRIMARY KEY AUTO_INCREMENT,
  productID int NOT NULL,
  images varchar(255) NOT NULL,
  created_at timestamp NULL DEFAULT now(),
  updated_at timestamp NULL DEFAULT now()
);