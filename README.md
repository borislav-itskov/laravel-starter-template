## Laravel starter template

This is a Laravel starter template that just adds the service->repository patter to the project along with a nice command to automate the writing of boilerplate code when creating a Model, Repository and Service.

## How to use

This template is good if you follow these principles:
- The repository layer is only for database operations.
- The service layer is for your business logic.
- Use extension over override when you want to add to the main methods in the BaseService/BaseRepository. This means calling parent::methodName() at the end of a concrete Service/Repository.

## Command

php artisan model:setup {modelName}

This command creates a Model, Repository, Service and a Migration file for the specified model name, following template naming conventions. Also, it registers the Repository and the Service in the service container so you could start using the base methods immediatelly.

### Example

- run php artisan model:setup Comment.
- go to the created create_comments_table migration file and setup your database table.
- run php artisan migrate.
- go to a controller and start using the CommentService immediatelly.