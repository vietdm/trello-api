<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\ProjectRepository;
use App\Repositories\UserRepository;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    private ProjectRepository $projectRepository;
    private UserRepository $userRepository;

    public function __construct(
        ProjectRepository $projectRepository,
        UserRepository $userRepository
    ) {
        parent::__construct();
        $this->projectRepository = $projectRepository;
        $this->userRepository = $userRepository;
    }

    public function getProjects(): JsonResponse
    {
        $projects = $this->projectRepository->getAll();
        return Response::success(['projects' => $projects]);
    }

    public function getProject($uuid): JsonResponse
    {
        $project = $this->projectRepository->first($uuid);
        return Response::success(['project' => $project]);
    }

    public function createProject(): JsonResponse
    {
        $validate = Validator::make($this->request->all(), [
            'title' => 'required',
            'description' => 'required',
            'user_uuid' => 'required|exists:users,uuid'
        ]);

        if ($validate->fails()) {
            return Response::paramError($validate->errors());
        }

        $user = $this->userRepository->first($this->request->user_uuid);

        $param = [
            'uuid' => Str::uuid()->toString(),
            'title' => $this->request->title,
            'description' => $this->request->description,
            'user_id' => $user->id
        ];

        return $this->projectRepository->create($param)
            ? Response::created('Create project success!')
            : Response::badRequest('Cannot create project');
    }

    public function editProject($uuid): JsonResponse
    {
        Validator::make($this->request->all(), [
            'title' => 'required',
            'description' => 'required'
        ]);
        $param = $this->request->only(['title', 'description']);
        return $this->projectRepository->update($uuid, $param)
            ? Response::success('Update project success!')
            : Response::badRequest('Cannot update project!');
    }

    public function removeProject($uuid): JsonResponse
    {
        return $this->projectRepository->delete($uuid)
            ? Response::success('Delete project success!')
            : Response::badRequest('Cannot delete project');
    }
}
