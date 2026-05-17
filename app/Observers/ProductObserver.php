<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function created(Product $product)
    {
        $this->logActivity('created', $product, null, $product->toArray());
    }

    /**
     * Handle the Product "updated" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function updated(Product $product)
    {
        $changes = [];
        
        // Log specific changes, especially price changes
        foreach ($product->getDirty() as $key => $value) {
            $original = $product->getOriginal($key);
            if ($original != $value) {
                $changes[$key] = [
                    'old' => $original,
                    'new' => $value
                ];
            }
        }

        if (!empty($changes)) {
            $this->logActivity('updated', $product, $product->getOriginal(), $changes);
        }
    }

    /**
     * Handle the Product "deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function deleted(Product $product)
    {
        $this->logActivity('deleted', $product, $product->toArray(), null);
    }

    /**
     * Handle the Product "restored" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function restored(Product $product)
    {
        $this->logActivity('restored', $product, null, $product->toArray());
    }

    /**
     * Handle the Product "force deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function forceDeleted(Product $product)
    {
        $this->logActivity('force_deleted', $product, $product->toArray(), null);
    }

    /**
     * Log activity to the activity logs table.
     *
     * @param string $action
     * @param Product $product
     * @param array|null $oldValues
     * @param array|null $newValues
     * @return void
     */
    protected function logActivity($action, $product, $oldValues = null, $newValues = null)
    {
        if (Auth::check()) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'model_type' => Product::class,
                'model_id' => $product->id,
                'old_values' => $oldValues,
                'new_values' => $newValues,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        }
    }
}
