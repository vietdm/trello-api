<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\BoardRepository;
use App\Repositories\TaskRepository;
use App\Repositories\UserRepository;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TaskController extends Controller
{
    private TaskRepository $taskRepository;
    private BoardRepository $boardRepository;
    private UserRepository $userRepository;

    public function __construct(
        TaskRepository $taskRepository,
        BoardRepository $boardRepository,
        UserRepository $userRepository
    ) {
        parent::__construct();
        $this->taskRepository = $taskRepository;
        $this->boardRepository = $boardRepository;
        $this->userRepository = $userRepository;
    }

    public function getTasks(): JsonResponse
    {
        $tasks = $this->taskRepository->getAll();
        return Response::success(['tasks' => $tasks]);
    }

    public function getTask($uuid): JsonResponse
    {
        $task = $this->taskRepository->first($uuid);
        return Response::success(['task' => $task]);
    }

    public function addTask(): JsonResponse
    {
        Validator::make($this->request->all(), [
            'title' => 'required',
            'description' => 'required',
            'user_uuid' => 'required|exists:users,uuid',
            'board_uuid' => 'required|exists:boards,uuid'
        ]);

        $user = $this->userRepository->first($this->request->user_uuid);
        if (!$user) {
            return Response::badRequest('User not found!');
        }

        $board = $this->boardRepository->first($this->request->board_uuid);
        if (!$board) {
            return Response::badRequest('Board not found!');
        }

        $param = [
            'uuid' => Str::uuid()->toString(),
            'title' => $this->request->title,
            'description' => $this->request->description,
            'user_id' => $user->id,
            'board_id' => $board->id
        ];

        return $this->taskRepository->create($param)
            ? Response::created('Create new task success!')
            : Response::badRequest('Cannot create new task!');
    }

    public function updateTask($uuid): JsonResponse
    {
        $rule = [
            'title' => 'required',
            'description' => 'required'
        ];

        Validator::make($this->request->all(), $rule);

        $param = $this->request->only(array_keys($rule));

        return $this->taskRepository->update($uuid, $param)
            ? Response::success('Update task success!')
            : Response::badRequest('Cannot update task!');
    }

    public function removeTask($uuid): JsonResponse
    {
        return $this->taskRepository->delete($uuid)
            ? Response::success('Deleted!')
            : Response::badRequest('Cannot delete task!');
    }

    public function moveBoardOfTask($uuid, $boardUuid): JsonResponse
    {
        $board = $this->boardRepository->first($boardUuid);
        if (!$board) {
            return Response::badRequest('Board not found!');
        }

        return $this->taskRepository->update($uuid, ['board_id' => $board->id])
            ? Response::success('Move task success!')
            : Response::badRequest('Cannot move task!');
    }
}
