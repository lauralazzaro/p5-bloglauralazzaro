<?php
namespace LL\WS\controllers;

use LL\WS\Models as mdl;
use LL\WS\classes as cls;

class Comment extends Base
{
    private mdl\Comment $modelComment;

    public function __construct($logger, $config)
    {
        parent::__construct($logger, $config);

        $this->modelComment = new \LL\WS\models\Comment($this->logger);
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function createComment($postId)
    {
        $this->logger->info('create comment');

        $body = $this->getBodyRequest();

        $comment = new cls\Comment();
        $comment->setPostId($postId);
        $comment->setContent($body->content);
        $comment->setUserId($body->userid);

        $this->modelComment->insertComment($comment);

        echo true;
    }

    /**
     * @param $commentId
     * @return void
     * @throws \Exception
     */
    public function approveComment($commentId)
    {
        $this->logger->info('approve comment');

        $this->modelComment->approveComment($commentId);

        echo true;
    }

    /**
     * @param $postId
     * @return void
     * @throws \Exception
     */
    public function selectAllComments($postId)
    {
        $this->logger->info('select comments');

        $dbArray = $this->modelComment->selectAllComments($postId);

        echo json_encode($dbArray);
    }
}