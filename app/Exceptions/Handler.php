<?php

namespace App\Exceptions;

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Laravel\Passport\Exceptions\OAuthServerException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
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
        //
    }

    public function render($request, Throwable $e)
    {

       // return parent::render($request, $e);
        if ($e instanceof OAuthServerException) {
            // grant type is not supported
            if ($e->getCode() === 2) {
                return response()->json([
                    'data' => $e->getMessage(),
                    'msg' => [
                        'summary' => 'Tipo de autenticación no soportado',
                        'detail' => 'Comuníquese con el administrador',
                        'code' => $e->getCode()
                    ]], 400);
            }
            // client authentication failed
            if ($e->getCode() === 4) {
                return response()->json([
                    'data' => $e->getMessage(),
                    'msg' => [
                        'summary' => 'Cliente no valido',
                        'detail' => 'Comuníquese con el administrador',
                        'code' => $e->getCode()
                    ]], 400);
            }
            // user authentication failed
            if ($e->getCode() === 10) {
                return response()->json([
                    'data' => $e->getMessage(),
                    'msg' => [
                        'summary' => 'Credenciales no validas',
                        'detail' => 'Su usuario o contraseña no son correctos',
                        'code' => $e->getCode()
                    ]], 401);
            }
        }

        if ($e instanceof AuthenticationException) {
            return response()->json([
                'data' => $e->getMessage(),
                'msg' => [
                    'summary' => 'Usuario no autenticado',
                    'detail' => 'Por favor inicie sesión',
                    'code' => $e->getCode()
                ]], 401);
        }

        if ($e instanceof HttpException) {
            if ($e->getStatusCode() === 403) {
                return response()->json([
                    'data' => $e->getMessage(),
                    'msg' => [
                        'summary' => 'Su dirección de correo electrónico no está verificada.',
                        'detail' => 'Por favor revise su correo',
                        'code' => $e->getCode()
                    ]], 403);
            }
            if ($e->getStatusCode() === 404) {
                return response()->json([
                    'data' => $e->getMessage(),
                    'msg' => [
                        'summary' => 'Recurso no encontrado',
                        'detail' => 'La ruta o recurso al que intenta acceder no existe o fue removido',
                        'code' => $e->getCode()
                    ]], 404);
            }
            if ($e->getStatusCode() === 405) {
                $supportMethods = implode(', ',$e->getHeaders());
                return response()->json([
                    'data' => $e->getMessage(),
                    'msg' => [
                        'summary' => "El método [{$request->getMethod()}] no está soportado por esta ruta",
                        'detail' => "Métodos soportados: [{$supportMethods}]",
                        'code' => $e->getCode()
                    ]], 405);
            }
            if ($e->getStatusCode() === 503) {
                return response()->json([
                    'data' => $e->getMessage(),
                    'msg' => [
                        'summary' => 'El sistema se encuentra fuera de servicio',
                        'detail' => 'Lamentamos las molestias causadas',
                        'code' => $e->getCode()
                    ]], 503);
            }
        }

        if ($e instanceof QueryException) {
            return response()->json([
                'data' => $e->errorInfo,
                'msg' => [
                    'summary' => 'Error en la consulta',
                    'detail' => 'Comuníquese con el administrador',
                    'code' => $e->getCode()
                ]], 400);
        }

        if ($e instanceof ModelNotFoundException) {
            return response()->json([
                'data' => $e->getMessage(),
                'msg' => [
                    'summary' => 'No se encontró el registro',
                    'detail' => 'Es muy probable que el registro haya sido eliminado',
                    'code' => $e->getCode()
                ]], 404);
        }

        if ($e instanceof ValidationException) {
            return response()->json([
                'data' => $e->errors(),
                'msg' => [
                    'summary' => 'Error en la validación de campos',
                    'detail' => $e->errors(),
                    'code' => $e->getCode()
                ]], 422);
        }

        if ($e instanceof \Error) {
            return response()->json([
                'data' => $e->getMessage(),
                'msg' => [
                    'summary' => 'Oops! Tuvimos un problema con el servidor',
                    'detail' => 'Comnicate con el administrador',
                    'code' => $e->getCode(),
                ]], 500);
        }

        return response()->json([
            'data' => $e->getMessage(),
            'msg' => [
                'summary' => $e->getMessage(),
                'detail' => 'Comnicate con el administrador',
                'code' => $e->getCode()
            ]], 500);
//        return parent::render($request, $e);
    }
}
