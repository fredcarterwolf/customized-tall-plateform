<?php

namespace fredcarterwolf\TallInstall\Actions\TALL;

use fredcarterwolf\TallInstall\Actions\Composer\ComposerInstallAction;

class InstallToastAction
{
    public function __construct(
        private ComposerInstallAction $composerInstallAction,
    ) {
    }

    public function execute(string $basePath): void
    {
        $this->composerInstallAction->execute(['usernotnull/tall-toasts'], $basePath);
    }
}
