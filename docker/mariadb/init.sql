CREATE DATABASE IF NOT EXISTS blog;

CREATE TABLE IF NOT EXISTS categories (
    id bigint AUTO_INCREMENT PRIMARY KEY,
    title varchar(255) NOT NULL,
    description text
);

CREATE TABLE IF NOT EXISTS posts (
    id bigint AUTO_INCREMENT PRIMARY KEY,
    title varchar(255) NOT NULL,
    image varchar(255),
    description text,
    content text,
    view_count int DEFAULT 0 NOT NULL,
    created_at datetime NOT NULL
);

CREATE TABLE IF NOT EXISTS post_categories (
    id bigint AUTO_INCREMENT PRIMARY KEY,
    post_id bigint NOT NULL,
    category_id bigint NOT NULL,
    CONSTRAINT uq_post_categories UNIQUE (post_id, category_id),
    CONSTRAINT fk_post_categories_post FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_post_categories_category FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE ON UPDATE CASCADE
);