<?php

namespace Gioppy\StatamicSimpleMinifyHtml;

use Gioppy\StatamicSimpleMinifyHtml\Http\Middleware\Minify;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider {

  protected $middlewareGroups = [
    'statamic.web' => [
      Minify::class,
    ]
  ];
}
