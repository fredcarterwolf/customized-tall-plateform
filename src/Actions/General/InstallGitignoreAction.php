<?php

namespace fredcarterwolf\TallInstall\Actions\General;

use fredcarterwolf\TallInstall\Actions\Filesystem\FileGetContentsAction;
use Illuminate\Support\Str;

class InstallGitignoreAction
{
    public function __construct(
        private FileGetContentsAction $fileGetContentsAction,
    ) {
    }

    public function execute(string $basePath): void
    {
        $gitignore = Str::of(
            $this->fileGetContentsAction->execute($basePath . '/.gitignore')
        );

        $gitignore = $gitignore->replace(
            "/vendor\n",
            "/vendor\n/vendor.nosync\n"
        );

        $gitignore = $gitignore->replace(
            "/node_modules\n",
            "/node_modules\n/node_modules.nosync\n"
        );

        $gitignore = $gitignore->replace(
            "/public/storage\n",
            "/public/storage\n/public/css/*.css\n/public/js/*.js\n/public/mix-manifest.json\n"
        );

        file_put_contents($basePath . "/.gitignore", (string) $gitignore);
    }
}
