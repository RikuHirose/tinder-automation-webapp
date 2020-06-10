<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateUseCaseFileCommand extends Command
{
    /**
     * @const string dir usecase path
     */
    const USE_CASE_PATH = 'packages/Usecase/';

    /**
     * @const string dir domain path
     */
    const DOMAIN_PATH = 'packages/Domain/Application/';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:usecase {domain : name of domain name} {usecaseName : The name of usecase}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create usecase files including usecase, usecase`s interface, inputdata, outputdata';
    private $domain;
    private $usecaseName;
    private $fullName;
    private $usecaseBasePath;
    private $usecaseInterfaceFileName;
    private $usecaseResponseFileName;
    private $usecaseInputFileName;
    private $interactorFileName;

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
        $this->domain      = $this->argument('domain');
        $this->usecaseName = $this->argument('usecaseName');
        $this->fullName    = $this->domain.$this->usecaseName;
        $this->usecaseBasePath = self::USE_CASE_PATH . $this->domain . '/' . $this->usecaseName;

        // $this->dirName  = $this->fileName;

        if (is_null($this->domain) || is_null($this->usecaseName)) {
            $this->error('Name invalid');
        }
        // $this->dirName = $this->ask('new directory name. or use directory name');

        // if (is_null($this->dirName)) {
        //     $this->error('Directory required!');
        // }

        if (!$this->isExistUsecaseDirectory()) {
            $this->createUsecaseDirectory();
        }

        if (!$this->isExistInteractorDirectory()) {
            $this->createInteractorDirectory();
        }

        $this->usecaseInterfaceFileName = $this->usecaseBasePath . '/' . $this->fullName. 'UseCaseInterface.php';
        $this->usecaseResponseFileName  = $this->usecaseBasePath . '/' . $this->fullName. 'Response.php';
        $this->usecaseInputFileName     = $this->usecaseBasePath . '/' . $this->fullName. 'Input.php';

        $this->interactorFileName = self::DOMAIN_PATH . $this->domain . '/' . $this->fullName . 'Interactor.php';

        if ($this->isExistFiles()) {
            $this->error('already exist');
            return;
        }

        $this->createUsecaseInput();
        $this->createUsecaseResponse();
        $this->createUsecaseInterface();

        $this->createInteractorFile();

        $this->info('create successfully');
        $this->line('');
        $this->comment('Add the following route to app/Providers/UseCaseServiceProvider.php:');
        $this->line('');
        $this->info("    \$this->app->bind(
            \\packages\\UseCase\\$this->domain\\$this->usecaseName\\$this->fullName". "UseCaseInterface::class,
            \\packages\\Domain\\Application\\$this->domain\\$this->fullName". "Interactor::class
        );");
        $this->line('');
    }

    /**
     * Repositoryのfileを作成する
     * @return void
     */
    private function createInteractorFile(): void
    {
        $input       = '$input';
        $usecasePath = "packages\\UseCase\\$this->domain\\$this->usecaseName\\$this->fullName". 'UseCaseInterface.php';
        $responsePath = "packages\\UseCase\\$this->domain\\$this->usecaseName\\$this->fullName". 'Response.php';
        $inputPath    = "packages\\UseCase\\$this->domain\\$this->usecaseName\\$this->fullName". 'Input.php';

        $content = "<?php\n\nnamespace packages\\Application\\$this->domain;\n\nUse $usecasePath;\nuse $responsePath;\nuse $inputPath;\n\nclass $this->fullName" . "Interactor implements $this->fullName" . "UseCaseInterface\n{\n\t\tpublic function handle($this->fullName"."Input $input): ".$this->fullName."Response\n\t\t{\n\t\t\treturn new $this->fullName"."Reaponse;\n\t\t}\n}\n";
        file_put_contents($this->interactorFileName, $content);
    }

    /**
     * @return void
     */
    private function createUsecaseInput(): void
    {
        $content = "<?php\n\nnamespace packages\\UseCase\\$this->domain\\$this->usecaseName;\n\nclass $this->fullName" . "Input\n{\n\t\tpublic function __construct(){}\n}\n";
        file_put_contents($this->usecaseInputFileName, $content);
    }

    /**
     * @return void
     */
    private function createUsecaseResponse(): void
    {
        $content = "<?php\n\nnamespace packages\\UseCase\\$this->domain\\$this->usecaseName;\n\nclass $this->fullName" . "Response\n{\n\t\tpublic function __construct(){}\n}\n";
        file_put_contents($this->usecaseResponseFileName, $content);
    }

    /**
     * @return void
     */
    private function createUsecaseInterface(): void
    {
        $input   = '$input';
        $content = "<?php\n\nnamespace packages\\UseCase\\$this->domain\\$this->usecaseName;\n\ninterface $this->fullName" . "UseCaseInterface\n{\n\t\tpublic function handle($this->fullName"."Input $input): ".$this->fullName."Response;\n}\n";
        file_put_contents($this->usecaseInterfaceFileName, $content);
    }

    /**
     * 同名fileの確認
     * @return bool
     */
    private function isExistFiles(): bool
    {
        return file_exists($this->usecaseInterfaceFileName)
            || file_exists($this->usecaseResponseFileName)
            || file_exists($this->usecaseInputFileName)
            || file_exists($this->interactorFileName);
    }

    /**
     * directoryの存在確認
     * @return bool
     */
    private function isExistUsecaseDirectory(): bool
    {
        return file_exists(self::USE_CASE_PATH . $this->domain . '/'. $this->usecaseName);
    }

    /**
     * 指定名でdirectoryの作成
     * @return void
     */
    private function createUsecaseDirectory(): void
    {
        mkdir(self::USE_CASE_PATH . $this->domain . '/'. $this->usecaseName, 0755, true);
    }

    /**
     * directoryの存在確認
     * @return bool
     */
    private function isExistInteractorDirectory(): bool
    {
        return file_exists(self::DOMAIN_PATH . $this->domain);
    }

    /**
     * 指定名でdirectoryの作成
     * @return void
     */
    private function createInteractorDirectory(): void
    {
        mkdir(self::DOMAIN_PATH . $this->domain, 0755, true);
    }
}