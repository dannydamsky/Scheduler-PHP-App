<?php

namespace App\Console\Commands;

use App\Models\Operation;
use Base\Console\Commands\Command;
use Base\Facades\DB;
use Base\Models\Model;
use Throwable;
use function __;
use function array_merge;

/**
 * Class OperationExecute
 *
 * Executes pending operations.
 *
 * @package App\Console\Commands
 * @since 2020-05-08
 * @author Danny Damsky <dannydamsky99@gmail.com>
 */
final class OperationExecute extends Command
{
    /**
     * Handle the execution of the operations.
     */
    public function handle(): void
    {
        DB::runInTransaction(function (): void {
            $this->handleCreateOperations();
            $this->handleDeleteOperations();
            $this->handleUpdateOperations();
        });
    }

    /**
     * Handle the create operations.
     */
    private function handleCreateOperations(): void
    {
        /** @var Operation[] $createOps */
        $createOps = Operation::getAll(['type' => ['eq' => Operation::OPERATION_TYPE_CREATE]]);
        foreach ($createOps as $operation) {
            $this->createModel($operation);
            $this->deleteOperation($operation);
        }
    }

    /**
     * Create the model from this operation.
     *
     * @param Operation $operation
     */
    private function createModel(Operation $operation): void
    {
        try {
            $modelClassName = $operation->getModel();
            /** @var Model $model */
            $model = new $modelClassName($operation->getData());
            $model->save();
        } catch (Throwable $e) {
            echo __('Failed to save new model. Reason: %1', $e->getMessage());
        }
    }

    /**
     * Handle the delete operations.
     */
    private function handleDeleteOperations(): void
    {
        /** @var Operation[] $deleteOps */
        $deleteOps = Operation::getAll(['type' => ['eq' => Operation::OPERATION_TYPE_DELETE]]);
        foreach ($deleteOps as $operation) {
            $this->deleteModel($operation);
            $this->deleteOperation($operation);
        }
    }

    /**
     * Delete the model from this operation.
     *
     * @param Operation $operation
     */
    private function deleteModel(Operation $operation): void
    {
        try {
            /** @var Model $modelClassName */
            $modelClassName = $operation->getModel();
            $modelPrimaryKeyValue = $operation->getData()[$modelClassName::PRIMARY_KEY];
            $modelClassName::deleteWhere([$modelClassName::PRIMARY_KEY => ['eq' => $modelPrimaryKeyValue]]);
        } catch (Throwable $e) {
            echo __('Failed to delete model. Reason: %1', $e->getMessage());
        }
    }

    /**
     * Delete the given operation from the database.
     *
     * @param Operation $operation
     */
    private function deleteOperation(Operation $operation): void
    {
        try {
            $operation->delete();
        } catch (Throwable $e) {
            echo __('Failed to delete operation with ID %1', $operation->getEntityId());
        }
    }

    /**
     * Handle the update operations.
     */
    private function handleUpdateOperations(): void
    {
        /** @var Operation[] $updateOps */
        $updateOps = Operation::getAll();
        $updateOps = $this->mergeUpdateOperations($updateOps);
        foreach ($updateOps as $modelClassName => $modelOperations) {
            foreach ($modelOperations as $operation) {
                $this->updateModel($operation);
            }
        }
        Operation::deleteWhere(); // Delete all operations.
    }

    /**
     * Merge the update operations by detecting multiple update
     * requests to the same row and merging them into one request.
     *
     * @param Operation[] $updateOps
     * @return Operation[]
     */
    private function mergeUpdateOperations(array $updateOps): array
    {
        /** @var Operation[] $merged */
        $merged = [];
        foreach ($updateOps as $operation) {
            /** @var Model|string $modelClassName */
            $modelClassName = $operation->getModel();
            $modelPrimaryKeyValue = $operation->getData()[$modelClassName::PRIMARY_KEY];
            if (isset($merged[$modelClassName][$modelPrimaryKeyValue])) {
                $mergedOp = $merged[$modelClassName][$modelPrimaryKeyValue];
                $mergedOp->setData(array_merge($mergedOp->getData(), $operation->getData()));
            } else {
                $merged[$modelClassName][$modelPrimaryKeyValue] = $operation;
            }
        }
        return $merged;
    }

    /**
     * Update the model from this operation.
     *
     * @param Operation $operation
     */
    private function updateModel(Operation $operation): void
    {
        try {
            $modelClassName = $operation->getModel();
            /** @var Model $model */
            $model = new $modelClassName($operation->getData());
            $model->save();
        } catch (Throwable $e) {
            echo __('Failed to update new model. Reason: %1', $e->getMessage());
        }
    }
}