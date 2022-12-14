<?php

namespace fredcarterwolf\TallInstall\Actions\General;

use fredcarterwolf\TallInstall\Actions\Filesystem\FileGetContentsAction;
use fredcarterwolf\TallInstall\Actions\Filesystem\FilePutContentsAction;
use Illuminate\Support\Str;

class SetupBrowsersyncAction
{
    public function __construct(
        private FileGetContentsAction $fileGetContentsAction,
        private FilePutContentsAction $filePutContentsAction,
    ) {
    }

    public function execute(string $basePath, string $domain = null): void
    {
        $webpackMixJsContents = Str::of($this->fileGetContentsAction->execute($basePath . '/webpack.mix.js'));

        $domain = $domain ? Str::of($domain)->remove('.test') : Str::of($basePath)->rtrim('/')->afterLast('/');

        $webpackMixJsContents = $webpackMixJsContents->append(
            Str::replace('valetDomain', $domain, $this->fileGetContentsAction->execute(stub('webpack.mix.js.browsersync')))
        );

        $this->filePutContentsAction->execute($basePath . '/webpack.mix.js', $webpackMixJsContents);
    }
}
