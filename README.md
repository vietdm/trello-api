# Task Management API

## Description

The Task Management API is built using Laravel and its primary function is to manage and distribute tasks among employees in your organization. This project allows you to create, update, delete, and track the status of tasks, as well as assign tasks to different employees.

## Key Features

1. **Task Management**:
    - Create new tasks with titles, descriptions, deadlines, and priorities.
    - View a list of existing tasks.
    - Update task information (title, description, deadline, priority).
    - Delete tasks from the system.

2. **Task Assignment**:
    - Assign tasks to one or multiple employees.
    - View a list of tasks assigned to each employee.
    - Unassign tasks from employees as needed.

3. **Task Status**:
    - Track the status of tasks (completed, in progress, not started).
    - Update task status upon completion.

4. **Employee Management**:
    - Create new employees with basic information (name, email, job position, etc.).
    - View a list of employees in the organization.
    - Update employee information.
    - Remove employees from the system.

## API Endpoints

This project provides the following API endpoints:

- `GET /api/tasks`: Retrieve a list of tasks.
- `POST /api/tasks`: Create a new task.
- `GET /api/tasks/{id}`: Retrieve detailed information about a task.
- `PUT /api/tasks/{id}`: Update a task.
- `DELETE /api/tasks/{id}`: Delete a task.
- `GET /api/employees`: Retrieve a list of employees.
- `POST /api/employees`: Create a new employee.
- `GET /api/employees/{id}`: Retrieve detailed information about an employee.
- `PUT /api/employees/{id}`: Update employee information.
- `DELETE /api/employees/{id}`: Remove an employee.
- `POST /api/tasks/{task_id}/assign/{employee_id}`: Assign a task to an employee.
- `DELETE /api/tasks/{task_id}/unassign/{employee_id}`: Unassign a task from an employee.
- `PATCH /api/tasks/{task_id}/status/{status}`: Update the status of a task.

## Authentication

To use this API, you need to authenticate using JSON Web Tokens (JWT). Make sure you are logged in and have a valid token before accessing protected endpoints.

## Installation

1. I will add this content in the near future.

## Usage

You can now use the API to manage and distribute tasks within your organization.

## Laravel Version

This project is built using Laravel [10.25.2](https://laravel.com/docs/10.x). Ensure you have the compatible Laravel version to smoothly run the project.

## Additional Documentation

For more details on how to use the API and additional setup instructions, please refer to the documentation within the project or add supplementary information to the README.md file.

### Prerequisites

- [Docker](https://www.docker.com/get-started) must be installed on your system.

### License

This project is licensed under the [MIT License](https://opensource.org/license/mit/).

### Author

- Minh Việt (VietD)
- GitHub: [https://github.com/vietdm](https://github.com/vietdm)
