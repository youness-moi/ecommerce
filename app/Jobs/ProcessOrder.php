<?php
namespace App\Jobs;

use App\Factories\OrderFactory;
use App\Models\OrderItem;
use App\Models\Orders;
use App\Services\OrderErrorHandler;
use App\Services\StockService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ProcessOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $formFields;


    /**
     * Créer une nouvelle instance de Job.
     *
     * @param array $formFields

     */
    public function __construct(array $formFields)
    {

        $this->formFields = $formFields;

    }

    /**
     * Exécute la tâche du Job.
     */
    public function handle(Orders $order, StockService $stockService, OrderErrorHandler $errorHandler)
    {
        DB::beginTransaction();

        try {
            // Validation des données du formulaire
            $validatedFields = $this->formFields;
            // Vérification du stock pour tous les produits
            $errors = $stockService->checkStock($validatedFields['products']);

            if (count($errors) > 0) {
                DB::rollBack();
                return response()->json([
                    'message' => 'Stock insuffisant'
                       ], 300);
            }

            $order = OrderFactory::create($validatedFields);


            // Mise à jour du stock
            $stockService->updateStock($validatedFields['products']);

            DB::commit();

            return $errorHandler->successResponse();

        } catch (ValidationException $e) {
            DB::rollBack();
            return $this->$errorHandler->handleValidationError($e);

        } catch (\Exception $e) {
            DB::rollBack();
            return $errorHandler->handleGeneralError($e);
        }
    }
}
