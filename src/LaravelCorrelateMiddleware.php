<?php

namespace ProEmergotech\Correlate\Laravel;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Psr\Log\LoggerInterface;
use ProEmergotech\Correlate\Monolog\CorrelateProcessor;
use ProEmergotech\Correlate\Correlate;

class LaravelCorrelateMiddleware
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $log;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $log = null)
    {
        $this->log = $log;

        $this->installMacros();
    }

    /**
     * Install macros for request and response classes
     * @return void
     */
    protected function installMacros()
    {
        if (!Request::hasMacro('hasCorrelationId')) {
            Request::macro('hasCorrelationId', function() {
                if ($this->headers->has(Correlate::getHeaderName())) {
                    return true;
                }
                return false;
            });
        }

        if (!Request::hasMacro('getCorrelationId')) {
            Request::macro('getCorrelationId', function($default = null) {
                if ($this->headers->has(Correlate::getHeaderName())) {
                    return $this->headers->get(Correlate::getHeaderName());
                }
                return $default;
            });
        }

        if (!Request::hasMacro('setCorrelationId')) {
            Request::macro('setCorrelationId', function($cid)  {
                $this->headers->set(Correlate::getHeaderName(), (string) $cid);
                return $this;
            });
        }
    }

    /**
     * @param Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, \Closure $next)
    {
        if (!$request->headers->has(Correlate::getHeaderName())) {
            $request->headers->set(
                Correlate::getHeaderName(), (string) Correlate::id()
            );
        }

        $cid = $request->headers->get(Correlate::getHeaderName());

        $this->log->pushProcessor(new CorrelateProcessor(Correlate::getParamName(), $cid));

        $response = $next($request);

        $response->headers->set(Correlate::getHeaderName(), $cid);

        return $response;
    }
}