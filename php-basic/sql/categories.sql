CREATE TABLE `categories` (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  title varchar(255) NOT NULL,
  description varchar (255),
  category_id int NOT NULL,   
  CONSTRAINT fk_category FOREIGN KEY (category_id) REFERENCES categories(id),
  created_at timestamp NULL DEFAULT now(),
  updated_at timestamp NULL DEFAULT now()
);