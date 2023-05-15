CREATE DATABASE survey;

USE survey;

CREATE TABLE users (
  user_id INT NOT NULL AUTO_INCREMENT,
  first_name VARCHAR(50) NOT NULL,
  last_name VARCHAR(50) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  phone_number VARCHAR(20) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (user_id)
);

CREATE TABLE surveys (
  survey_id INT NOT NULL AUTO_INCREMENT,
  code VARCHAR(50) NOT NULL UNIQUE,
  name VARCHAR(255) NOT NULL,
  description TEXT,
  start_datetime DATETIME NOT NULL,
  end_datetime DATETIME NOT NULL,
  user_id INT NOT NULL,	
  is_active BOOLEAN NOT NULL DEFAULT TRUE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  is_deleted BOOLEAN NOT NULL DEFAULT FALSE,
  PRIMARY KEY (survey_id),
  FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE questions (
  question_id INT NOT NULL AUTO_INCREMENT,
  survey_id INT NOT NULL,
  name VARCHAR(255) NOT NULL,
  description TEXT,
  type ENUM('multiple_answers', 'multiple_choice', 'yes_no', 'essay') NOT NULL,
  options TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (question_id),
  FOREIGN KEY (survey_id) REFERENCES surveys(survey_id)

);

CREATE TABLE answers (
  answer_id INT NOT NULL AUTO_INCREMENT,
  survey_id INT NOT NULL,
  question_id INT NOT NULL,
  respondent_id INT,
  answer TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (answer_id),
  FOREIGN KEY (survey_id) REFERENCES surveys(survey_id),
  FOREIGN KEY (question_id) REFERENCES questions(question_id),
  FOREIGN KEY (respondent_id) REFERENCES users(user_id)
);

CREATE TABLE anonymous_respondent (
  respondent_id INT NOT NULL AUTO_INCREMENT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (respondent_id)
);

CREATE TABLE registered_respondent (
  respondent_id INT NOT NULL AUTO_INCREMENT,
  user_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (respondent_id),
  FOREIGN KEY (user_id) REFERENCES users(user_id)
);

INSERT INTO USER(first_name, last_name, email, password_hash, phone_number) VALUES ('Admin', 'Database', '000@gmail.com', 'Abc@1234', '0000000000');