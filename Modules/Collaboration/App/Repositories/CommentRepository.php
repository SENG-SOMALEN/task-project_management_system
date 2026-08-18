<?php

namespace Modules\Collaboration\App\Repositories;

use Modules\Collaboration\App\Interfaces\CommentRepositoryInterface;
use Modules\Collaboration\App\Models\Comment;

class CommentRepository implements CommentRepositoryInterface
{
    public function __construct(private Comment $comment){}

    public function all()
    {
        return $this->comment->all();
    }
    public function find(int $id)
    {
        return $this->comment->findOrFail($id);
    }
    public function create(array $data)
    {
        return $this->comment->create($data);
    }
    public function update(int $id, array $data)
    {
        $comment = $this->comment->findOrFail($id);

        $comment->update($data);

        return $comment;
    }
    public function delete(int $id)
    {
        $comment = $this->comment->findOrFail($id);

        return $comment->delete();
    }
}