<?php

namespace Modules\Collaboration\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Collaboration\App\Services\CommentService;
use Modules\Collaboration\App\Http\Requests\StoreCommentRequest;
use Modules\Collaboration\App\Http\Requests\UpdateCommentRequest;
use Modules\Collaboration\App\Http\Resources\CommentResource;

class CommentController extends Controller
{
    public function __construct(private CommentService $commentService){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = $this->commentService->getAllComments();

        return CommentResource::collection($comments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request)
    {
        $comment = $this->commentService->createComment(
            $request->validated()
        );

        return new CommentResource($comment);
    }

    public function show(int $id)
    {
        $comment = $this->commentService->getCommentById($id);

        return new CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request,int $id)
    {
        $comment = $this->commentService->updateComment(
            $id,
            $request->validated()
        );

        return new CommentResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $this->commentService->deleteComment($id);

        return response()->json([
            'status' => true,
            'message' => 'Comment deleted successfully.',
        ]);
    }
}
