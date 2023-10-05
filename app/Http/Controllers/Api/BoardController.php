<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\BoardRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\TaskRepository;
use App\Utils\Response;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BoardController extends Controller
{
    private BoardRepository $boardRepository;
    private TaskRepository $taskRepository;
    private ProjectRepository $projectRepository;

    public function __construct(
        BoardRepository $boardRepository,
        TaskRepository $taskRepository,
        ProjectRepository $projectRepository
    ) {
        parent::__construct();
        $this->boardRepository = $boardRepository;
        $this->taskRepository = $taskRepository;
        $this->projectRepository = $projectRepository;
    }

    public function getAllBoards(): JsonResponse
    {
        $boards = $this->boardRepository->getAll();
        return Response::success(['boards' => $boards]);
    }

    public function getBoards($uuidProject): JsonResponse
    {
        $project = $this->projectRepository->first($uuidProject);
        if (!$project) {
            return Response::badRequest('Project not found!');
        }

        $boards = $this->boardRepository->find('project_id', $project->id);

        return Response::success(['boards' => $boards]);
    }

    public function getBoardPaths(): JsonResponse
    {
        $boards = $this->boardRepository->getAll()->toArray();
        return Response::success(['paths' => array_column($boards, 'uuid')]);
    }

    public function getBoard($uuid): JsonResponse
    {
        $board = $this->boardRepository->first($uuid);
        return Response::success(['board' => $board]);
    }

    public function getTaskOfBoard($uuid): JsonResponse
    {
        $board = $this->boardRepository->first($uuid);
        if (!$board) {
            return Response::badRequest('Board not found!');
        }

        $tasks = $this->taskRepository->find('board_id', $board->id);

        return Response::success(['tasks' => $tasks]);
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
