<?php

namespace Modules\Collaboration\App\Services;

use Modules\Collaboration\App\Interfaces\CommentRepositoryInterface;

class CommentService
{
    public function __construct(private CommentRepositoryInterface $commentRepository){}

    public function getAllComments()
    {
        return $this->commentRepository->all();
    }
    public function getCommentById(int $id)
    {
        return $this->commentRepository->find($id);
    }
    public function createComment(array $data)
    {
        return $this->commentRepository->create($data);
    }
    public function updateComment(int $id, array $data)
    {
        return $this->commentRepository->update($id, $data);
    }
    public function deleteComment(int $id)
    {
        return $this->commentRepository->delete($id);
    }
}