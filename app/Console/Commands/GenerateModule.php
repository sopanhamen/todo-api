<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GenerateModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:generate {module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a crud module';

    private $disk;
    private $moduleDirectoryName = 'Modules';
    private $serviceNameSuffix = 'Service';
    private $repositoryNameSuffix = 'Repository';
    private $requestNameSuffix = 'Request';
    private $resourceNameSuffix = 'Resource';
    private $policyNameSuffix = 'Policy';
    private $modelNameSuffix = '';
    private $controllerNameSuffix = 'Controller';
    private $resourcesDirectoryName = 'Resources';
    private $requestsDirectoryName = 'Requests';
    private $eventsDirectoryName = 'Events';
    private $listenersDirectoryName = 'Listeners';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->disk = Storage::createLocalDriver(['root' => app_path()]);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $moduleName = $this->getModuleName();
        $modulePath = $this->moduleDirectoryName . DIRECTORY_SEPARATOR . $moduleName;

        try {
            $this->disk->makeDirectory($modulePath);
            $this->makeModelClass($modulePath);
            $this->makeControllerClass($modulePath);
            $this->makeRepositoryClass($modulePath);
            $this->makeServiceClass($modulePath);
            $this->makeResourceClass($modulePath);
            $this->makeRequestClass($modulePath);
            $this->makePolicyClass($modulePath);
            $this->makeEventsDirectory($modulePath);
            $this->makeListenersDirectory($modulePath);
            $this->info('Module ' . $moduleName . ' created successfully!');
        } catch (\Exception $e) {
            $this->disk->deleteDirectory($modulePath);
            $this->error('Failed to create module');
            $this->line($e->getMessage());
        }
    }

    public function makeEventsDirectory($path)
    {
        $path = $path . DIRECTORY_SEPARATOR . $this->eventsDirectoryName;
        $this->disk->makeDirectory($path);
    }

    public function makeListenersDirectory($path)
    {
        $path = $path . DIRECTORY_SEPARATOR . $this->listenersDirectoryName;
        $this->disk->makeDirectory($path);
    }

    public function makeControllerClass($path)
    {
        $moduleName = $this->getModuleName();
        $moduleNameCamelCase = Str::camel($moduleName);
        $moduleTitle = $this->getModuleTitle();
        $modelName = $this->getModelName();
        $controllerName = $this->getControllerName();
        $routeParameterName = Str::snake($moduleName);
        $serviceName = $this->getServiceName();
        $resourceName = $this->getResourceName();
        $serviceNameCamelCase = Str::camel($serviceName);
        $pluralModuleTitle = Str::plural($moduleTitle);
        $pluralModuleNameCamelCase = Str::camel($pluralModuleTitle);
        $moduleUrlPath = Str::slug($pluralModuleTitle);
        $storeFunctionRequestName = $this->getRequestStoreName();
        $updateFunctionRequestName = $this->getRequestUpdateName();

        $content = <<<XML
        <?php

        namespace App\\$this->moduleDirectoryName\\$moduleName;

        use App\Http\Controllers\Controller;
        use Illuminate\Http\Request;
        use App\\$this->moduleDirectoryName\\$moduleName\\$serviceName;
        use App\\$this->moduleDirectoryName\\$moduleName\\$this->resourcesDirectoryName\\$resourceName;
        use App\\$this->moduleDirectoryName\\$moduleName\\$this->requestsDirectoryName\\$storeFunctionRequestName;
        use App\\$this->moduleDirectoryName\\$moduleName\\$this->requestsDirectoryName\\$updateFunctionRequestName;

        class $controllerName extends Controller
        {
            protected \$$serviceNameCamelCase;

            public function __construct($serviceName \$$serviceNameCamelCase)
            {
                \$this->middleware('auth');
                \$this->$serviceNameCamelCase = \$$serviceNameCamelCase;
            }

            /**
             * @OA\GET(
             *     path="/api/$moduleUrlPath",
             *     tags={"$pluralModuleTitle"},
             *     summary="Get $pluralModuleTitle list",
             *     description="Get $pluralModuleTitle List as Array",
             *     @OA\Response(response=400, description="Bad request"),
             *     @OA\Response(response=404, description="Resource Not Found"),
             * )
             */
            public function index(Request \$request)
            {
                \$this->authorize('viewAny', $modelName::class);

                \$$pluralModuleNameCamelCase = \$this->{$serviceNameCamelCase}->paginate(\$request->all());
                return $resourceName::collection(\$$pluralModuleNameCamelCase);
            }

            /**
             * @OA\GET(
             *     path="/api/$moduleUrlPath/{id}",
             *     tags={"$pluralModuleTitle"},
             *     summary="Get $moduleTitle detail",
             *     @OA\Response(response=400, description="Bad request"),
             *     @OA\Response(response=404, description="Resource Not Found"),
             * )
             */
            public function show(Request \$request, int \$id)
            {
                \$this->authorize('view', $modelName::class);

                \$$moduleNameCamelCase = \$this->{$serviceNameCamelCase}->getOneOrFail(\$id, \$request->all());
                return new $resourceName(\$$moduleNameCamelCase);
            }

            /**
             * @OA\POST(
             *     path="/api/$moduleUrlPath",
             *     tags={"$pluralModuleTitle"},
             *     summary="Create a new $moduleTitle",
             *     @OA\Response(response=400, description="Bad request"),
             *     @OA\Response(response=422, description="Unprocessable Entity"),
             * )
             */
            public function store($storeFunctionRequestName \$request)
            {
                \$this->authorize('create', $modelName::class);

                \$$moduleNameCamelCase = \$this->{$serviceNameCamelCase}->createOne(\$request->all());
                return new $resourceName(\$$moduleNameCamelCase);
            }

            /**
             * @OA\PUT(
             *     path="/api/$moduleUrlPath/{id}",
             *     tags={"$pluralModuleTitle"},
             *     summary="Update an existing $moduleTitle",
             *     @OA\Response(response=400, description="Bad request"),
             *     @OA\Response(response=422, description="Unprocessable Entity"),
             * )
             */
            public function update($updateFunctionRequestName \$request, int \$id)
            {
                \$this->authorize('update', $modelName::class);

                \$$moduleNameCamelCase = \$this->{$serviceNameCamelCase}->updateOne(\$id, \$request->all());
                return new $resourceName(\$$moduleNameCamelCase);
            }

            /**
             * @OA\DELETE(
             *     path="/api/$moduleUrlPath/{id}",
             *     tags={"$pluralModuleTitle"},
             *     summary="Delete a $moduleTitle",
             *     @OA\Response(response=400, description="Bad request"),
             *     @OA\Response(response=404, description="Resource Not Found"),
             * )
             */
            public function destroy(int \$id)
            {
                \$this->authorize('delete', $modelName::class);

                \$$moduleNameCamelCase = \$this->{$serviceNameCamelCase}->deleteOne(\$id);
                return new $resourceName(\$$moduleNameCamelCase);
            }

            /**
             * @OA\POST(
             *     path="/api/$moduleUrlPath/{id}/restore",
             *     tags={"$pluralModuleTitle"},
             *     summary="Restore a $moduleTitle from trash",
             *     @OA\Response(response=400, description="Bad request"),
             *     @OA\Response(response=404, description="Resource Not Found"),
             * )
             */
            public function restore(int \$id)
            {
                \$this->authorize('restore', $modelName::class);

                \$$moduleNameCamelCase = \$this->{$serviceNameCamelCase}->restoreOne(\$id);
                return new $resourceName(\$$moduleNameCamelCase);
            }
        }

        XML;

        $this->disk->put($path . '/' . $controllerName . '.php', $content);
    }

    public function makeRepositoryClass($path)
    {
        $moduleName = $this->getModuleName();
        $modelName = $this->getModelName();
        $modelNameCamelCase = Str::camel($modelName);
        $repositoryName = $this->getRepositoryName();

        $content = <<<XML
        <?php

        namespace App\\$this->moduleDirectoryName\\$moduleName;

        use App\Libraries\Crud\CrudRepository;
        use App\\$this->moduleDirectoryName\\$moduleName\\$modelName;

        class $repositoryName extends CrudRepository
        {
            public function __construct($modelName \$$modelNameCamelCase)
            {
                parent::__construct(\$$modelNameCamelCase);
            }
        }

        XML;

        $this->disk->put($path . '/' . $repositoryName . '.php', $content);
    }

    public function makeServiceClass($path)
    {
        $moduleName = $this->getModuleName();
        $repositoryName = $this->getRepositoryName();
        $serviceName = $this->getServiceName();

        $content = <<<XML
        <?php

        namespace App\\$this->moduleDirectoryName\\$moduleName;

        use App\Libraries\Crud\CrudService;

        class $serviceName extends CrudService
        {
            protected array \$allowedRelations = [];

            public function __construct($repositoryName \$repo)
            {
                parent::__construct(\$repo);
            }
        }

        XML;

        $this->disk->put($path . '/' . $serviceName . '.php', $content);
    }

    public function makeModelClass($path)
    {
        $moduleName = $this->getModuleName();
        $modelName = $this->getModelName();

        $content = <<<XML
        <?php

        namespace App\\$this->moduleDirectoryName\\$moduleName;

        use App\Libraries\Crud\CrudModel;
        use Illuminate\Database\Eloquent\Factories\HasFactory;
        use Illuminate\Database\Eloquent\SoftDeletes;
        use App\Libraries\Database\Traits\HasAuthors;
        use OwenIt\Auditing\Contracts\Auditable;

        class $modelName extends CrudModel implements Auditable
        {
            use HasFactory, SoftDeletes, HasAuthors, \OwenIt\Auditing\Auditable;
        }

        XML;

        $this->disk->put($path . '/' . $modelName . '.php', $content);
    }

    public function makeResourceClass($path)
    {
        $moduleName = $this->getModuleName();
        $resourceName = $this->getResourceName();

        $content = <<<XML
        <?php

        namespace App\\$this->moduleDirectoryName\\$moduleName\\$this->resourcesDirectoryName;

        use Illuminate\Http\Resources\Json\JsonResource;

        class $resourceName extends JsonResource
        {
            /**
             * Transform the resource into an array.
             *
             * @param  \Illuminate\Http\Request  \$request
             * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
             */
            public function toArray(\$request)
            {
                return parent::toArray(\$request);
            }
        }

        XML;

        $filePath = $path . '/' . $this->resourcesDirectoryName . '/' . $resourceName . '.php';
        $this->disk->put($filePath, $content);
    }

    public function makeRequestClass($path)
    {
        $this->makeMainRequestClass($path);
        $this->makeStoreDataRequestClass($path);
        $this->makeUpdateDataRequestClass($path);
    }

    public function makeMainRequestClass($path)
    {
        $moduleName = $this->getModuleName();
        $requestName = $this->getRequestName();

        $content = <<<XML
        <?php

        namespace App\\$this->moduleDirectoryName\\$moduleName\\$this->requestsDirectoryName;

        use Illuminate\Foundation\Http\FormRequest;

        class $requestName extends FormRequest
        {
            /**
             * Determine if the user is authorized to make this request.
             *
             * @return bool
             */
            public function authorize()
            {
                return false;
            }

            /**
             * Get the validation rules that apply to the request.
             *
             * @return array
             */
            public function rules()
            {
                return [
                    //
                ];
            }
        }

        XML;

        $filePath = $path . '/' . $this->requestsDirectoryName . '/' . $requestName . '.php';
        $this->disk->put($filePath, $content);
    }

    public function makeStoreDataRequestClass($path)
    {
        $moduleName = $this->getModuleName();
        $requestName = $this->getRequestName();
        $className = $this->getRequestStoreName();

        $content = <<<XML
        <?php

        namespace App\\$this->moduleDirectoryName\\$moduleName\\$this->requestsDirectoryName;

        class $className extends $requestName
        {
            /**
             * Determine if the user is authorized to make this request.
             *
             * @return bool
             */
            public function authorize()
            {
                return false;
            }

            /**
             * Get the validation rules that apply to the request.
             *
             * @return array
             */
            public function rules()
            {
                return [
                    ...parent::rules(),
                ];
            }
        }

        XML;

        $filePath = $path . '/' . $this->requestsDirectoryName . '/' . $className . '.php';
        $this->disk->put($filePath, $content);
    }

    public function makeUpdateDataRequestClass($path)
    {
        $moduleName = $this->getModuleName();
        $requestName = $this->getRequestName();
        $className = $this->getRequestUpdateName();

        $content = <<<XML
        <?php

        namespace App\\$this->moduleDirectoryName\\$moduleName\\$this->requestsDirectoryName;

        class $className extends $requestName
        {
            /**
             * Determine if the user is authorized to make this request.
             *
             * @return bool
             */
            public function authorize()
            {
                return false;
            }

            /**
             * Get the validation rules that apply to the request.
             *
             * @return array
             */
            public function rules()
            {
                return [
                    ...parent::rules(),
                ];
            }
        }

        XML;

        $filePath = $path . '/' . $this->requestsDirectoryName . '/' . $className . '.php';
        $this->disk->put($filePath, $content);
    }

    public function makePolicyClass($path)
    {
        $moduleName = $this->getModuleName();
        $moduleTitle = $this->getModuleTitle();
        $modelName = $this->getModelName();
        $policyName = $this->getPolicyName();

        $content = <<<XML
        <?php

        namespace App\\$this->moduleDirectoryName\\$moduleName;

        use App\\$this->moduleDirectoryName\User\User;
        use Illuminate\Auth\Access\HandlesAuthorization;
        use App\\$this->moduleDirectoryName\Permission\Enum\Permission;

        class $policyName
        {
            use HandlesAuthorization;

            /**
             * Determine whether the user can view any $moduleTitle.
             *
             * @param  \App\\$this->moduleDirectoryName\User\User  \$user
             * @return \Illuminate\Auth\Access\Response|bool
             */
            public function viewAny(User \$user)
            {
                // return \$user->can(Permission::VIEW_USER);
                return true;
            }

            /**
             * Determine whether the user can view the $moduleTitle.
             *
             * @param  \App\\$this->moduleDirectoryName\User\User  \$user
             * @return \Illuminate\Auth\Access\Response|bool
             */
            public function view(User \$user)
            {
                // return \$user->can(Permission::VIEW_USER->value);
                return true;
            }

            /**
             * Determine whether the user can create $moduleTitle.
             *
             * @param  \App\\$this->moduleDirectoryName\User\User  \$user
             * @return \Illuminate\Auth\Access\Response|bool
             */
            public function create(User \$user)
            {
                // return \$user->can(Permission::CREATE_USER->value);
                return true;
            }

            /**
             * Determine whether the user can update the $moduleTitle.
             *
             * @param  \App\\$this->moduleDirectoryName\User\User  \$user
             * @return \Illuminate\Auth\Access\Response|bool
             */
            public function update(User \$user)
            {
                // return \$user->can(Permission::UPDATE_USER->value);
                return true;
            }

            /**
             * Determine whether the user can delete the $modelName.
             *
             * @param  \App\\$this->moduleDirectoryName\User\User  \$user
             * @return \Illuminate\Auth\Access\Response|bool
             */
            public function delete(User \$user)
            {
                // return \$user->can(Permission::DELETE_USER->value);
                return true;
            }

            /**
             * Determine whether the user can restore the $modelName.
             *
             * @param  \App\\$this->moduleDirectoryName\User\User  \$user
             * @return \Illuminate\Auth\Access\Response|bool
             */
            public function restore(User \$user)
            {
                // return \$user->can(Permission::RESTORE_USER->value);
                return true;
            }

            /**
             * Determine whether the user can permanently delete the $modelName.
             *
             * @param  \App\\$this->moduleDirectoryName\User\User  \$user
             * @return \Illuminate\Auth\Access\Response|bool
             */
            public function forceDelete(User \$user)
            {
                // return \$user->can(Permission::FORCE_DELETE_USER->value);
                return true;
            }
        }

        XML;

        $filePath = $path . '/' . $policyName . '.php';
        $this->disk->put($filePath, $content);
    }

    public function getModuleName()
    {
        return ucwords($this->argument('module'));
    }

    public function getModuleTitle()
    {
        return Str::title(
            Str::replace('_', ' ', Str::of($this->argument('module'))->snake())
        );
    }

    public function getControllerName()
    {
        return $this->getModuleName() . $this->controllerNameSuffix;
    }

    public function getModelName()
    {
        return $this->getModuleName() . $this->modelNameSuffix;
    }

    public function getServiceName()
    {
        return $this->getModuleName() . $this->serviceNameSuffix;
    }

    public function getRepositoryName()
    {
        return $this->getModuleName() . $this->repositoryNameSuffix;
    }

    public function getRequestName()
    {
        return $this->getModuleName() . $this->requestNameSuffix;
    }

    public function getRequestStoreName()
    {
        return 'Create' . $this->getModuleName() . $this->requestNameSuffix;
    }

    public function getRequestUpdateName()
    {
        return 'Update' . $this->getModuleName() . $this->requestNameSuffix;
    }

    public function getResourceName()
    {
        return $this->getModuleName() . $this->resourceNameSuffix;
    }

    public function getPolicyName()
    {
        return $this->getModuleName() . $this->policyNameSuffix;
    }
}
