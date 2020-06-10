<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateRepositoryFileCommand extends Command
{
    /**
     * @const string dir Infrastructure path
     */
    const INFRASTRUCTURE_PATH = 'packages/Infrastructure/';

    /**
     * @const string dir domain path
     */
    const DOMAIN_PATH = 'packages/Domain/Domain/';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {repository : name of repository name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create repository files';
    private $repository;
    private $domainDirectory;
    private $InfraDirectory;
    private $repositoryInterfaceFileName;
    private $repositoryFileName;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->repository      = $this->argument('repository');
        $this->domainDirectory = self::DOMAIN_PATH.'/'.$this->repository.'/';
        $this->InfraDirectory  = self::INFRASTRUCTURE_PATH . 'Repository' . '/';

        if (is_null($this->repository)) {
            $this->error('Name invalid');
        }

        if (!$this->isExistDirectory($this->domainDirectory)) {
            $this->createDirectory($this->domainDirectory);
        }

        if (!$this->isExistDirectory($this->InfraDirectory)) {
            $this->createDirectory($this->InfraDirectory);
        }

        $this->repositoryInterfaceFileName = $this->domainDirectory.$this->repository.'RepositoryInterface.php';
        $this->repositoryFileName = $this->InfraDirectory . $this->repository . 'Repository.php';

        if ($this->isExistFiles()) {
            $this->error('already exist');
            return;
        }

        $this->createRepositoryInterface();
        $this->createRepositoryFile();

        $this->info('create successfully');
        $this->line('');
        $this->comment('Add the following route to app/Providers/RepositoryServiceProvider.php:');
        $this->line('');
        $this->info("    \$this->app->bind(
            \\packages\\Domain\\Domain\\$this->repository\\$this->repository". "RepositoryInterface::class,
            \\packages\\Infrastructure\\Repository\\$this->repository". "Repository::class
        );");
        $this->line('');
    }

    /**
     * Repositoryのfileを作成する
     * @return void
     */
    private function createRepositoryFile(): void
    {
        $domainPath = "packages\\Domain\\Domain\\$this->repository\\$this->repository";
        $repositoryInterfacePath = "packages\\Domain\\Domain\\$this->repository\\$this->repository". 'RepositoryInterface';

        $eloquent   = "\$eloquent".$this->repository;
        $construct  = "\\App\\Models\\".$this->repository." ".$eloquent;
        $construct2 = "\$this->eloquent".$this->repository." = ".$eloquent.";";


        $content = "<?php\n\nnamespace packages\\Infrastructure\\Repository;\n\nUse $domainPath;\nuse $repositoryInterfacePath;\n\nclass $this->repository" . "Repository implements $this->repository" . "RepositoryInterface\n{\n\t\tprivate $eloquent;\n\n\t\tpublic function __construct($construct)\n\t\t{\n\t\t\t\t$construct2\n\t\t}\n}\n";
        file_put_contents($this->repositoryFileName, $content);
    }

    /**
     * @return void
     */
    private function createRepositoryInterface(): void
    {
        $content = "<?php\n\nnamespace packages\\Domain\\Domain\\$this->repository;\n\ninterface $this->repository" . "RepositoryInterface\n{\n\n}\n";
        file_put_contents($this->repositoryInterfaceFileName, $content);
    }

    /**
     * 同名fileの確認
     * @return bool
     */
    private function isExistFiles(): bool
    {
        return file_exists($this->repositoryInterfaceFileName)
            || file_exists($this->repositoryFileName);
    }

    /**
     * directoryの存在確認
     * @return bool
     */
    private function isExistDirectory($directory): bool
    {
        return file_exists($directory);
    }

    /**
     * 指定名でdirectoryの作成
     * @return void
     */
    private function createDirectory($directory): void
    {
        mkdir($directory, 0755, true);
    }
}