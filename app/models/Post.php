<?php
    class Post {
        private $db;

        public function __construct() {
            $this->db = new Database();
        }

        public function findPostById($id) {
            $this->db->query('SELECT * FROM posts WHERE id = :id');
            $this->db->bind(':id', $id);
            $post = $this->db->single();
            return $post;
        }

        public function getAllPosts() {
            $this->db->query('SELECT * FROM posts INNER JOIN users ON posts.user_id = users.user_id ORDER BY posts.created_at DESC');
            $posts = $this->db->resultSet();
            return $posts;
        }

        public function createPost($data) {
            $this->db->query('INSERT INTO posts (title, body, user_id) VALUES (:title, :body, :user_id)');
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':body', $data['body']);
            $this->db->bind(':user_id', $data['user_id']);
            
            if($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }

        public function updatePost($data) {
            $this->db->query('UPDATE posts SET title = :title, body = :body WHERE id = :id');
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':body', $data['body']);
            $this->db->bind(':id', $data['id']);
            
            if($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }

        public function deletePost($id) {
            $this->db->query('DELETE FROM posts WHERE id = :id');
            $this->db->bind(':id', $id);
            
            if($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }
    }
?>