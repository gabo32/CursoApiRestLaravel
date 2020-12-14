<?php

namespace App\Exceptions;

use Throwable;
use App\Traits\ApiResponse;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponse;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Sobreescribimos cuando se haga un validator exception
     *
     * @param  \Illuminate\Validation\ValidationException  $e
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        if ($e->response) {
            return $e->response;
        }

        //return $this->errorResponse($this->invalidJson($request, $e), 422);
        return  $this->invalidJson($request, $e);
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof ModelNotFoundException) {
            $model = strtolower( class_basename( $e->getModel() ) );
            return $this->errorResponse("No existe ninguna instancia de {$model} con el id solicitado",404);
        }

        //TODO: validar si no es autorization exception
        if( $e instanceof AccessDeniedHttpException){
            return $this->errorResponse("No posee los permisos para ejecutar esta acción ", 403);
        }

        if( $e instanceof NotFoundHttpException){
            return $this->errorResponse("No se encontro la URL especificada ", 404);
        }

        if( $e instanceof MethodNotAllowedHttpException){
            return $this->errorResponse("El metodo especificado no es valido ", 405);
        }

        if( $e instanceof HttpException){
            return $this->errorResponse($e->getMessage(),$e->getStatusCode());
        }        

        if( $e instanceof QueryException){
            $codigo = $e->errorInfo[1];
            if( $codigo == 1451){
                return $this->errorResponse("No se puede eliminar de forma permanente el recurso porque esta relacionado con algún otro.", 409);
            }
            return $this->errorResponse($e->getMessage(), 500);
        } 

        if (method_exists($e, 'render') && $response = $e->render($request)) {
            return Router::toResponse($request, $response);
        } elseif ($e instanceof Responsable) {
            return $e->toResponse($request);
        }

        $e = $this->prepareException($this->mapException($e));

        foreach ($this->renderCallbacks as $renderCallback) {
            if (is_a($e, $this->firstClosureParameterType($renderCallback))) {
                $response = $renderCallback($e, $request);

                if (! is_null($response)) {
                    return $response;
                }
            }
        }

        if ($e instanceof HttpResponseException) {
            return $e->getResponse();
        } elseif ($e instanceof AuthenticationException) {
            return $this->unauthenticated($request, $e);
        } elseif ($e instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($e, $request);
        }


        //obtenemos el archivo config
        if( config('app.debug')){
            return parent::render($request, $e);
        }

        return $this->errorResponse("Falla inesperada. Intente despues", 500);
        //return parent::render($request, $e);
    }

    /**
     * Convert an authentication exception into a response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        //return $request->expectsJson()
        //            ? response()->json(['message' => $exception->getMessage()], 401)
        //            : redirect()->guest($exception->redirectTo() ?? route('login'));
        return $this->errorResponse('No autenticado', 401);
    }
}
