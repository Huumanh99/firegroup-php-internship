CREATE TABLE `products` (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  name varchar(50) NOT NULL,
  price decimal(6,2) NOT NULL,
  quantity int  NOT NULL,
  category_id INT NOT NULL,
  CONSTRAINT fk_categories FOREIGN KEY (category_id)  REFERENCES categories(id),
  account_id INT NOT NULL,
  CONSTRAINT fk_accounts FOREIGN KEY (account_id)  REFERENCES categories(id),
  created_at timestamp NULL DEFAULT now(),
  updated_at timestamp NULL DEFAULT now()
);