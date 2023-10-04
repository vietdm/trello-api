<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\BoardRepository;
use App\Utils\Response;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BoardController extends Controller
{
    protected BoardRepository $boardRepository;

    public function __construct(BoardRepository $boardRepository)
    {
        parent::__construct();
        $this->boardRepository = $boardRepository;
    }


    public function getBoards(): JsonResponse
    {
        $boards = $this->boardRepository->getAll();
        return Response::success(['boards' => $boards]);
    }

    public function getBoard($uuid): JsonResponse
    {
        $board = $this->boardRepository->first($uuid);
        return Response::success(['board' => $board]);
    }

    public function createBoard(): JsonResponse
    {
        Validator::make($this->request->all(), [
            'title' => 'required',
            'description' => 'required'
        ]);

        $param = $this->request->only(['title', 'description']);
        $param['user_id'] = 1;
        $param['uuid'] = Str::uuid()->toString();

        return $this->boardRepository->create($param) === false
            ? Response::badRequest('Cannot create board!')
            : Response::created('Created new board');
    }

    public function updateBoard($uuid): JsonResponse
    {
        Validator::make($this->request->all(), [
            'title' => 'required',
            'description' => 'required'
        ]);

        $param = $this->request->only(['title', 'description']);

        return $this->boardRepository->update($uuid, $param)
            ? Response::success('Update success!')
            : Response::badRequest('Cannot update!');
    }

    public function removeBoard($uuid): JsonResponse
    {
        return $this->boardRepository->delete($uuid)
            ? Response::success('Update success!')
            : Response::badRequest('Cannot update!');
    }
}
