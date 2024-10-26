<?php

namespace App\Services;

use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;

class OrderErrorHandler
{
    /**
     * Gérer les erreurs de validation et retourner un JSON approprié.
     *
     * @param ValidationException $e
     * @return JsonResponse
     */
    public function handleValidationError(ValidationException $e): JsonResponse
    {
        return response()->json([
            'message' => 'Erreur de validation',
            'errors' => $e->validator->errors()
        ], 422);
    }

    /**
     * Gérer les erreurs générales et retourner un JSON approprié.
     *
     * @param \Exception $e
     * @return JsonResponse
     */
    public function handleGeneralError(\Exception $e): JsonResponse
    {
        return response()->json([
            'message' => 'Une erreur est survenue',
            'error' => $e->getMessage()
        ], 500);
    }

    /**
     * Retourne un message de succès pour les commandes.
     *
     * @param string $message
     * @return JsonResponse
     */
    public function successResponse(string $message = 'Commande créée avec succès'): JsonResponse
    {
        return response()->json([
            'message' => $message
        ], 201);
    }
}
