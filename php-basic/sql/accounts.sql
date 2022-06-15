CREATE TABLE `users` (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  role enum('admin','user','','') NOT NULL DEFAULT 'user',
  name varchar(50) NOT NULL,
  email varchar(50) UNIQUE NOT NULL,
  password varchar(50) NOT NULL,
  created_at timestamp NULL DEFAULT now(),
  updated_at timestamp NULL DEFAULT now()
);