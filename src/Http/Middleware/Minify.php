<?php


namespace Gioppy\StatamicSimpleMinifyHtml\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Minify {

  /**
   * Handle an incoming request.
   *
   * @param Request $request
   * @param Closure $next
   * @return mixed
   */
  public function handle(Request $request, Closure $next) {
    /**
     * @var Response $response
     */
    $response = $next($request);

    if ($this->isResponse($response) && $this->isHtml($response) && env('MINIFY', false)) {
      $content = $response->getContent();
      $content = preg_replace(['/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s', '/<!--(.|\s)*?-->/'], ['>', '<', '\\1'], $content);

      $response->setContent($content);
    }

    return $response;
  }

  /**
   * Check if the response is a valid Response object
   *
   * @param mixed $response
   * @return bool
   */
  private function isResponse($response) {
    return is_object($response) && $response instanceof Response;
  }

  /**
   * Check if the response is HTML
   *
   * @param Response $response
   * @return bool
   */
  private function isHtml(Response $response) {
    $contentType = $response->headers->get('Content-Type');
    return strtolower(strtok($contentType, ';')) == 'text/html';
  }
}
