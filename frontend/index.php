<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';


use Toolbox\Functions;
use Toolbox\Renderer;

parse_str(filter_input(INPUT_SERVER, 'QUERY_STRING', FILTER_SANITIZE_STRING), $query_array);

if (!isset($query_array['page'])) {
    $query_array['page'] = '';
}

$twigRenderer = new Renderer();
$function = new Functions();

switch ($query_array['page']) {
    case '':
    case 'home':
        $twigRenderer->home();
        break;
    case 'posts':
        $twigRenderer->posts();
        break;
    case 'post':
        $id = $query_array['postid'];
        $twigRenderer->post($id);
        break;
    case 'login':
        $twigRenderer->login();
        break;
    case 'sendlogin':
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $function->login($post);
        break;
    case 'sendsignup':
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $function->signup($post);
        break;
    case 'signup':
        $twigRenderer->signup();
        break;
    case 'logout':
        $_SESSION['connected'] = false;
        $_SESSION['role'] = '';
        header('location: ?page=home');
        break;
    case 'admin':
        $twigRenderer->adminPage();
        break;
    case 'approvecomment':
        $commentId = $query_array['commentid'];
        $function->approveComment($commentId);
        header('location: ?page=admin');
        break;
    case 'deletecomment':
        $commentId = $query_array['commentid'];
        $function->deleteComment($commentId);
        header('location: ?page=admin');
        break;
    case 'addcomment':
        $comment = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $function->addComment($comment);
        break;
    case 'deletepost':
        $postId = $query_array['postid'];
        $function->deletePost($postId);
        break;
    default:
        echo('page not found');
}
