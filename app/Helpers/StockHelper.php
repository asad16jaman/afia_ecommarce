<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class StockHelper
{
    public static function getProductStock($productId)
    {
        $stockRow = DB::table('tbl_currentinventory')
            ->where('product_id', $productId)
            ->first();

        if (!$stockRow) {
            return 0;
        }

        return (
            $stockRow->purchase_quantity
            + $stockRow->transfer_to_quantity
            + $stockRow->sales_return_quantity
        ) - (
            $stockRow->sales_quantity
            + $stockRow->purchase_return_quantity
            + $stockRow->damage_quantity
            + $stockRow->transfer_from_quantity
        );
    }

    public static function getSizeWiseStock($productId)
    {
        $stocks = DB::table('tbl_size as s')
            ->selectRaw("
                s.Size_SlNo,
                s.Size_Name,
                ? AS Product_IDNo,

                COALESCE((
                    SELECT PurchaseDetails_Rate
                    FROM tbl_purchasedetails
                    WHERE Product_IDNo = ?
                    AND size_id = s.Size_SlNo
                    AND status = 'a'
                    ORDER BY PurchaseDetails_SlNo DESC
                    LIMIT 1
                ), 0) AS PurchaseDetails_Rate,

                COALESCE((
                    SELECT SUM(PurchaseDetails_TotalQuantity)
                    FROM tbl_purchasedetails
                    WHERE Product_IDNo = ?
                    AND size_id = s.Size_SlNo
                    AND status = 'a'
                ), 0) AS purchase_quantity,

                COALESCE((
                    SELECT SUM(SaleDetails_TotalQuantity)
                    FROM tbl_saledetails
                    WHERE Product_IDNo = ?
                    AND size_id = s.Size_SlNo
                    AND status = 'a'
                ), 0) AS sale_quantity,

                COALESCE((
                    SELECT SUM(SaleReturnDetails_ReturnQuantity)
                    FROM tbl_salereturndetails srd
                    LEFT JOIN tbl_saledetails sd
                        ON sd.SaleDetails_SlNo = srd.sale_details_id
                    WHERE srd.SaleReturnDetailsProduct_SlNo = ?
                    AND sd.size_id = s.Size_SlNo
                    AND srd.status = 'a'
                ), 0) AS sale_return_quantity,

                COALESCE((
                    SELECT SUM(PurchaseReturnDetails_ReturnQuantity)
                    FROM tbl_purchasereturndetails prd
                    LEFT JOIN tbl_purchasedetails pd
                        ON pd.PurchaseDetails_SlNo = prd.purchase_details_id
                    WHERE prd.PurchaseReturnDetailsProduct_SlNo = ?
                    AND pd.size_id = s.Size_SlNo
                    AND prd.status = 'a'
                ), 0) AS purchase_return_quantity,

                COALESCE((
                    SELECT SUM(DamageDetails_DamageQuantity)
                    FROM tbl_damagedetails
                    WHERE Product_SlNo = ?
                    AND size_id = s.Size_SlNo
                    AND status = 'a'
                ), 0) AS damage_quantity,

                COALESCE((
                    SELECT SUM(td.quantity)
                    FROM tbl_transferdetails td
                    LEFT JOIN tbl_transfermaster tm
                        ON tm.transfer_id = td.transfer_id
                    WHERE td.product_id = ?
                    AND td.size_id = s.Size_SlNo
                    AND td.status != 'd'
                ), 0) AS transfer_from_quantity,

                COALESCE((
                    SELECT SUM(td.quantity)
                    FROM tbl_transferdetails td
                    LEFT JOIN tbl_transfermaster tm
                        ON tm.transfer_id = td.transfer_id
                    WHERE td.product_id = ?
                    AND td.size_id = s.Size_SlNo
                    AND td.status = 'a'
                ), 0) AS transfer_to_quantity
            ", [
                $productId,
                $productId,
                $productId,
                $productId,
                $productId,
                $productId,
                $productId,
                $productId,
                $productId,
            ])
            ->where('s.status', 'a')
            ->orderBy('s.Size_SlNo', 'asc')
            ->get();

        // Stock calculation
        $stocks = $stocks->map(function ($item) {

            $item->current_stock = (
                $item->purchase_quantity +
                $item->sale_return_quantity +
                $item->transfer_to_quantity
            ) - (
                $item->sale_quantity +
                $item->purchase_return_quantity +
                $item->damage_quantity +
                $item->transfer_from_quantity
            );

            $item->stock_value =
                $item->current_stock * $item->PurchaseDetails_Rate;

            return $item;
        });

        return $stocks->values()->all();
    }
}