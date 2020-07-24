<?php

namespace App\Console\Commands;
;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class SetupModel extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'model:setup {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a model and all the files around it!';

    /**
     * The config options for all the files we're creating
     *
     * @var array
     */
    protected $config = [
        'model' => [
            'name' => '',
            'folder' => 'Models',
            'stub' => '/app/Stubs/Model.stub',
            'namespace' => '\\App\\Models\\',
        ],
        'repo' => [
            'name' => 'Repository',
            'folder' => 'Repositories',
            'stub' => '/app/Stubs/Repository.stub',
            'register_stub' => '/app/Stubs/RegisterRepository.stub',
            'register_file' => '/app/Providers/RepositoryServiceProvider.php',
            'namespace' => '\\App\\Repositories\\',
        ],
        'service' => [
            'name' => 'Service',
            'folder' => 'Services',
            'stub' => '/app/Stubs/Service.stub',
            'register_stub' => '/app/Stubs/RegisterService.stub',
            'register_file' => '/app/Providers/ServiceDeclarationServiceProvider.php',
            'namespace' => '\\App\\Services\\',
        ],
    ];

    /**
     * What kind of type we're creating at the moment
     *
     * @var string
     */
    protected $currentType;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // create and register the files
        $this->createFile('model');
        $this->createFile('repo');
        $this->register('repo');
        $this->createFile('service');
        $this->register('service');

        // generate a migration
        $migrationName = Str::snake(lcfirst(trim($this->argument('name'))) . 's');
        $this->call('make:migration', [
            'name' => 'create_' . $migrationName . '_table',
            '--create' => $migrationName,
        ]);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->resolveStubPath(
            $this->config[$this->currentType]['stub']
        );
    }

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function resolveStubPath($stub)
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__.$stub
        ;
    }

    /**
     * Get the destination class path.
     *
     * @return string
     */
    protected function getDestination(): string
    {
        // get the end file name
        $name = $this->getFileName();

        // get the folder
        $folder = $this->config[$this->currentType]['folder'];

        // return the destination
        return $folder . '/' . $name;
    }

    /**
     * Set the stub we're creating.
     * Create and file and print done.
     *
     * @param  string $type
     * @return void
     */
    protected function createFile($type): void
    {
        // set the type we're building
        $this->currentType = $type;

        // get name, destination and full file path
        $name = $this->getFileName();
        $destination = $this->getDestination();
        $fullPath = $this->getPath($destination);

        // create the file 
        $this->files->put($fullPath, $this->sortImports($this->buildClass($name)));

        // say it's done
        $this->info(ucfirst($this->currentType) .' created successfully.');
    }

    /**
     * Get the file name we're trying the build right now.
     * $currentType should be set for this to work
     *
     * @param  string"null $type - pass a type or use the global one
     * @return string
     */
    protected function getFileName(string $type = null): string
    {
        // get the type
        $type = !is_null($type) ? $type : $this->currentType;

        // load the options
        $name = trim($this->argument('name'));
        $options = $this->config[$type];

        // add the name from the options and return it
        $name .= $options['name'];
        return $name;
    }

    /**
     * Register the repository/service/other type to the
     * dependency injection container
     *
     * @param  string $type
     * @return void
     */
    protected function register(string $type): void
    {
        // get the registration stub
        $stub = $this->resolveStubPath(
            $this->config[$type]['register_stub']
        );

        // get namespaces
        $modelNamespace = $this->config['model']['namespace'];
        $repoNamespace = $this->config['repo']['namespace'];
        $serviceNamespace = $this->config['service']['namespace'];

        // get names
        $modelName = $this->getFileName('model');
        $repoName = $this->getFileName('repo');
        $serviceName = $this->getFileName('service');

        // build the classnames
        $modelClass = $modelNamespace . $modelName;
        $repoClass = $repoNamespace . $repoName;
        $serviceClass = $serviceNamespace . $serviceName;

        // configure the repo stub
        $repoRegStub = file_get_contents($stub);
        $repoRegStub = str_replace('{{ service }}', $serviceClass, $repoRegStub);
        $repoRegStub = str_replace('{{ repo }}', $repoClass, $repoRegStub);
        $repoRegStub = str_replace('{{ model }}', $modelClass, $repoRegStub);

        // file open tests
        $filename = $this->laravel->basePath() . $this->config[$type]['register_file'];
        $contents = file_get_contents($filename);
        $replaceableComment = "// DO NOT REMOVE THIS COMMENT AS IT'S USED FOR AUTO-REGISTRATION"; 
        $strToInsert = $replaceableComment."\n".$repoRegStub;
        $contents = str_replace(
            $replaceableComment,
            $strToInsert,
            $contents
        );
        file_put_contents($filename, $contents);

        // say you're happy
        $this->info(ucfirst($type) .' registered successfully.');
    }
}
