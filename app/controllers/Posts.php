<?php
    class Posts extends Controller {
        public function __construct() {
            $this->postModel = $this->model('Post');
        }

        public function index() {
            $posts = $this->postModel->getAllPosts();
            $data = [
                'posts' => $posts,
            ];
            return $this->view('/posts/index', $data);
        }

        public function create() {
            if(!isLoggedIn()) {
                header('Location: ' . URLROOT . '/users/login');
            }

            $data = [
                'title' => '',
                'body' => '',
                'titleError' => '',
                'bodyError' => '',
            ];

            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $data = [
                    'user_id' => $_SESSION['user_id'],
                    'title' => trim($_POST['title']),
                    'body' => trim($_POST['body']),
                    'titleError' => '',
                    'bodyError' => '',
                ];

                if(empty($data['title'])) {
                    $data['titleError'] = 'Sorry, Title can not be empty.';
                }

                if(empty($data['body'])) {
                    $data['bodyError'] = 'Sorry, Post content can not be empty.';
                }

                if(empty($data['titleError']) && empty($data['bodyError'])) {
                    if($this->postModel->createPost($data)) {
                        header('Location: ' . URLROOT . '/posts/index');
                    } else {
                        die('Sorry, something went wrong.');
                    }
                }
            } else {
                $data = [
                    'title' => '',
                    'body' => '',
                    'titleError' => '',
                    'bodyError' => '',
                ];
            }
            return $this->view('posts/create', $data);
        }

        public function update($id) {
            $post = $this->postModel->findPostById($id);
            
            if(!isLoggedIn()) {
                header('Location: ' . URLROOT . '/users/login');
            } else if($_SESSION['user_id'] != $post->user_id) {
                header('Location: ' . URLROOT . '/posts/index');
            }

            $data = [
                'id' => $post->id,
                'title' => $post->title,
                'body' => $post->body,
                'titleError' => '',
                'bodyError' => '',
            ];

            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $data = [
                    'id' => $post->id,
                    'user_id' => $_SESSION['user_id'],
                    'title' => trim($_POST['title']),
                    'body' => trim($_POST['body']),
                    'titleError' => '',
                    'bodyError' => '',
                ];

                if(empty($data['title'])) {
                    $data['titleError'] = 'Sorry, Title can not be empty.';
                }

                if(empty($data['body'])) {
                    $data['bodyError'] = 'Sorry, Post content can not be empty.';
                }

                if($data['title'] == $post->title && $data['body'] == $post->body) {
                    $data['bodyError'] = 'Atleast try to change one field.';
                }

                if(empty($data['titleError']) && empty($data['bodyError'])) {
                    if($this->postModel->updatePost($data)) {
                        header('Location: ' . URLROOT . '/posts/index');
                    } else {
                        die('Sorry, something went wrong.');
                    }
                }
            } else {
                $data = [
                    'id' => $post->id,
                    'title' => $post->title,
                    'body' => $post->body,
                    'titleError' => '',
                    'bodyError' => '',
                ];
            }
            return $this->view('posts/update', $data);
        }

        public function delete($id) {
            $post = $this->postModel->findPostById($id);
            
            if(!isLoggedIn()) {
                header('Location: ' . URLROOT . '/users/login');
            } else if($_SESSION['user_id'] != $post->user_id) {
                header('Location: ' . URLROOT . '/posts/index');
            }

            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                if($this->postModel->deletePost($id)) {
                    header('Location: ' . URLROOT . '/posts/index');
                } else {
                    die('Sorry, something went wrong.');
                }
            }
            header('Location: ' . URLROOT . '/posts/index');
        }
    }
?>