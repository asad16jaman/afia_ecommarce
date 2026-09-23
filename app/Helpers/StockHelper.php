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

    public static function getSizeWiseStock($productId, $branchId = 1)
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
                    AND tm.transfer_from = '$branchId'
                    AND td.status != 'd'
                ), 0) AS transfer_from_quantity,

                COALESCE((
                    SELECT SUM(td.quantity)
                    FROM tbl_transferdetails td
                    LEFT JOIN tbl_transfermaster tm
                        ON tm.transfer_id = td.transfer_id
                    WHERE td.product_id = ?
                    AND td.size_id = s.Size_SlNo
                    AND tm.transfer_to = '$branchId'
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
        $stocks = $stocks->filter(function ($item) {

            $current = (
                $item->purchase_quantity +
                $item->sale_return_quantity +
                $item->transfer_to_quantity
            ) - (
                $item->sale_quantity +
                $item->purchase_return_quantity +
                $item->damage_quantity +
                $item->transfer_from_quantity
            );

            // $item->stock_value =
            //     $item->current_stock * $item->PurchaseDetails_Rate;
            
            $item->current_stock = $current;
            return $current > 0;
        });

        return $stocks->values()->all();
    }

    public static function getOnlyColoreWiseStock($productId, $branchId = 1)
    {
        $stocks = DB::table('tbl_color as c')
            ->selectRaw("
                c.Color_SlNo,
                c.Color_Name,
                '$productId' AS Product_IDNo,
                IFNULL((
                    SELECT PurchaseDetails_Rate
                    FROM tbl_purchasedetails
                    WHERE Product_IDNo = '$productId'
                    AND Color_SlNo = c.Color_SlNo
                    AND status = 'a'
                    ORDER BY PurchaseDetails_SlNo DESC
                    LIMIT 1
                ), 0) AS PurchaseDetails_Rate,

                IFNULL((
                    SELECT SUM(PurchaseDetails_TotalQuantity)
                    FROM tbl_purchasedetails
                    WHERE Product_IDNo = '$productId'
                    AND Color_SlNo = c.Color_SlNo
                    AND status = 'a'
                ), 0) AS purchase_quantity,

                IFNULL((
                    SELECT SUM(SaleDetails_TotalQuantity)
                    FROM tbl_saledetails
                    WHERE Product_IDNo = '$productId'
                    AND Color_SlNo = c.Color_SlNo
                    AND status = 'a'
                ), 0) AS sale_quantity,

                IFNULL((
                    SELECT SUM(SaleReturnDetails_ReturnQuantity)
                    FROM tbl_salereturndetails srd
                    LEFT JOIN tbl_saledetails sd
                        ON sd.SaleDetails_SlNo = srd.sale_details_id
                    WHERE srd.SaleReturnDetailsProduct_SlNo = '$productId'
                    AND sd.Color_SlNo = c.Color_SlNo
                    AND srd.status = 'a'
                ), 0) AS sale_return_quantity,

                IFNULL((
                    SELECT SUM(PurchaseReturnDetails_ReturnQuantity)
                    FROM tbl_purchasereturndetails prd
                    LEFT JOIN tbl_purchasedetails pd
                        ON pd.PurchaseDetails_SlNo = prd.purchase_details_id
                    WHERE prd.PurchaseReturnDetailsProduct_SlNo = '$productId'
                    AND pd.Color_SlNo = c.Color_SlNo
                    AND prd.status = 'a'
                ), 0) AS purchase_return_quantity,

                IFNULL((
                    SELECT SUM(DamageDetails_DamageQuantity)
                    FROM tbl_damagedetails
                    WHERE Product_SlNo = '$productId'
                    AND Color_SlNo = c.Color_SlNo
                    AND status = 'a'
                ), 0) AS damage_quantity,

                IFNULL((
                    SELECT SUM(td.quantity)
                    FROM tbl_transferdetails td
                    LEFT JOIN tbl_transfermaster tm
                        ON tm.transfer_id = td.transfer_id
                    WHERE td.product_id = '$productId'
                    AND td.Color_SlNo = c.Color_SlNo
                    AND tm.transfer_from = '$branchId'
                    AND td.status != 'd'
                ), 0) AS transfer_from_quantity,

                IFNULL((
                    SELECT SUM(td.quantity)
                    FROM tbl_transferdetails td
                    LEFT JOIN tbl_transfermaster tm
                        ON tm.transfer_id = td.transfer_id
                    WHERE td.product_id = '$productId'
                    AND td.Color_SlNo = c.Color_SlNo
                    AND tm.transfer_to = '$branchId'
                    AND td.status = 'a'
                ), 0) AS transfer_to_quantity
            ")
            ->where('c.status', 'a')
            ->orderBy('c.Color_SlNo', 'asc')
            ->get();

        // Stock calculation
        $stocks = $stocks->filter(function ($item) use ($productId, $branchId) {

            $currentStock = (
                $item->purchase_quantity +
                $item->sale_return_quantity +
                $item->transfer_to_quantity
            ) - (
                $item->sale_quantity +
                $item->purchase_return_quantity +
                $item->damage_quantity +
                $item->transfer_from_quantity
            );
            // $item->stock_value = $item->current_stock * $item->PurchaseDetails_Rate;
            if ($currentStock > 0) {
                $item->current_stock = $currentStock;
            }
            return $currentStock> 0 ;
        });
        return $stocks->values()->all();
    }


    public static function getColoreSizeWiseStock($productId, $colorId, $branchId = 1)
    {
         $stocks2 = DB::table('tbl_size as s')
            ->selectRaw("
                        s.Size_SlNo,
                        s.Size_Name,
                        '$productId' as Product_SlNo,
                        '$colorId' as Color_SlNo,

                        IFNULL((
                            SELECT PurchaseDetails_Rate
                            FROM tbl_purchasedetails
                            WHERE Product_IDNo = '$productId'
                            AND Color_SlNo = '$colorId'
                            AND size_id = s.Size_SlNo
                            AND status = 'a'
                            ORDER BY PurchaseDetails_SlNo DESC
                            LIMIT 1
                        ),0) AS PurchaseDetails_Rate,

                        IFNULL((
                            SELECT SUM(PurchaseDetails_TotalQuantity)
                            FROM tbl_purchasedetails
                            WHERE Product_IDNo = '$productId'
                            AND Color_SlNo = '$colorId'
                            AND size_id = s.Size_SlNo
                            AND status = 'a'
                        ), 0) AS purchase_quantity,

                IFNULL((
                    SELECT SUM(SaleDetails_TotalQuantity)
                    FROM tbl_saledetails
                    WHERE Product_IDNo = '$productId'
                    AND Color_SlNo = '$colorId'
                     AND size_id = s.Size_SlNo
                    AND status = 'a'
                ), 0) AS sale_quantity,

                IFNULL((
                    SELECT SUM(SaleReturnDetails_ReturnQuantity)
                    FROM tbl_salereturndetails srd
                    LEFT JOIN tbl_saledetails sd
                        ON sd.SaleDetails_SlNo = srd.sale_details_id
                    WHERE srd.SaleReturnDetailsProduct_SlNo = '$productId'
                    AND sd.Color_SlNo = '$colorId'
                    AND sd.size_id = s.Size_SlNo
                    AND srd.status = 'a'
                ), 0) AS sale_return_quantity,

                IFNULL((
                    SELECT SUM(PurchaseReturnDetails_ReturnQuantity)
                    FROM tbl_purchasereturndetails prd
                    LEFT JOIN tbl_purchasedetails pd
                        ON pd.PurchaseDetails_SlNo = prd.purchase_details_id
                    WHERE prd.PurchaseReturnDetailsProduct_SlNo = '$productId'
                    AND pd.Color_SlNo = '$colorId'
                    AND pd.size_id = s.Size_SlNo
                    AND prd.status = 'a'
                ), 0) AS purchase_return_quantity,

                IFNULL((
                    SELECT SUM(DamageDetails_DamageQuantity)
                    FROM tbl_damagedetails
                    WHERE Product_SlNo = '$productId'
                    AND Color_SlNo = '$colorId'
                    AND size_id = s.Size_SlNo
                    AND status = 'a'
                ), 0) AS damage_quantity,

                IFNULL((
                    SELECT SUM(td.quantity)
                    FROM tbl_transferdetails td
                    LEFT JOIN tbl_transfermaster tm
                        ON tm.transfer_id = td.transfer_id
                    WHERE td.product_id = '$productId'
                    AND td.Color_SlNo = '$colorId'
                    AND td.size_id = s.Size_SlNo
                    AND tm.transfer_from = '$branchId'
                    AND td.status != 'd'
                ), 0) AS transfer_from_quantity,

                IFNULL((
                    SELECT SUM(td.quantity)
                    FROM tbl_transferdetails td
                    LEFT JOIN tbl_transfermaster tm
                        ON tm.transfer_id = td.transfer_id
                    WHERE td.product_id = '$productId'
                    AND td.Color_SlNo = '$colorId'
                    AND td.size_id = s.Size_SlNo
                    AND tm.transfer_to = '$branchId'
                    AND td.status = 'a'
                ), 0) AS transfer_to_quantity
                   ")->where('s.status', 'a')
            ->orderBy('s.Size_SlNo', 'asc')
            ->get();

        $stocks2 = $stocks2->filter(function ($item) {

            $currentStock2 = (
                $item->purchase_quantity +
                $item->sale_return_quantity +
                $item->transfer_to_quantity
            ) - (
                $item->sale_quantity +
                $item->purchase_return_quantity +
                $item->damage_quantity +
                $item->transfer_from_quantity
            );
            // $item->stock_value = $item->current_stock * $item->PurchaseDetails_Rate;

            $item->current_stock = $currentStock2;
            return $currentStock2 > 0;
        });
        return $stocks2->values()->all();

    }

    public static function getColoreWiseStock($productId, $branchId = 1)
    {
        $stocks = DB::table('tbl_color as c')
            ->selectRaw("
                c.Color_SlNo,
                c.Color_Name,
                '$productId' AS Product_IDNo,
                IFNULL((
                    SELECT PurchaseDetails_Rate
                    FROM tbl_purchasedetails
                    WHERE Product_IDNo = '$productId'
                    AND Color_SlNo = c.Color_SlNo
                    AND status = 'a'
                    ORDER BY PurchaseDetails_SlNo DESC
                    LIMIT 1
                ), 0) AS PurchaseDetails_Rate,

                IFNULL((
                    SELECT SUM(PurchaseDetails_TotalQuantity)
                    FROM tbl_purchasedetails
                    WHERE Product_IDNo = '$productId'
                    AND Color_SlNo = c.Color_SlNo
                    AND status = 'a'
                ), 0) AS purchase_quantity,

                IFNULL((
                    SELECT SUM(SaleDetails_TotalQuantity)
                    FROM tbl_saledetails
                    WHERE Product_IDNo = '$productId'
                    AND Color_SlNo = c.Color_SlNo
                    AND status = 'a'
                ), 0) AS sale_quantity,

                IFNULL((
                    SELECT SUM(SaleReturnDetails_ReturnQuantity)
                    FROM tbl_salereturndetails srd
                    LEFT JOIN tbl_saledetails sd
                        ON sd.SaleDetails_SlNo = srd.sale_details_id
                    WHERE srd.SaleReturnDetailsProduct_SlNo = '$productId'
                    AND sd.Color_SlNo = c.Color_SlNo
                    AND srd.status = 'a'
                ), 0) AS sale_return_quantity,

                IFNULL((
                    SELECT SUM(PurchaseReturnDetails_ReturnQuantity)
                    FROM tbl_purchasereturndetails prd
                    LEFT JOIN tbl_purchasedetails pd
                        ON pd.PurchaseDetails_SlNo = prd.purchase_details_id
                    WHERE prd.PurchaseReturnDetailsProduct_SlNo = '$productId'
                    AND pd.Color_SlNo = c.Color_SlNo
                    AND prd.status = 'a'
                ), 0) AS purchase_return_quantity,

                IFNULL((
                    SELECT SUM(DamageDetails_DamageQuantity)
                    FROM tbl_damagedetails
                    WHERE Product_SlNo = '$productId'
                    AND Color_SlNo = c.Color_SlNo
                    AND status = 'a'
                ), 0) AS damage_quantity,

                IFNULL((
                    SELECT SUM(td.quantity)
                    FROM tbl_transferdetails td
                    LEFT JOIN tbl_transfermaster tm
                        ON tm.transfer_id = td.transfer_id
                    WHERE td.product_id = '$productId'
                    AND td.Color_SlNo = c.Color_SlNo
                    AND tm.transfer_from = '$branchId'
                    AND td.status != 'd'
                ), 0) AS transfer_from_quantity,

                IFNULL((
                    SELECT SUM(td.quantity)
                    FROM tbl_transferdetails td
                    LEFT JOIN tbl_transfermaster tm
                        ON tm.transfer_id = td.transfer_id
                    WHERE td.product_id = '$productId'
                    AND td.Color_SlNo = c.Color_SlNo
                    AND tm.transfer_to = '$branchId'
                    AND td.status = 'a'
                ), 0) AS transfer_to_quantity
            ")
            ->where('c.status', 'a')
            ->orderBy('c.Color_SlNo', 'asc')
            ->get();

        // Stock calculation
        $stocks = $stocks->filter(function ($item) use ($productId, $branchId) {

            $currentStock = (
                $item->purchase_quantity +
                $item->sale_return_quantity +
                $item->transfer_to_quantity
            ) - (
                $item->sale_quantity +
                $item->purchase_return_quantity +
                $item->damage_quantity +
                $item->transfer_from_quantity
            );
            // $item->stock_value = $item->current_stock * $item->PurchaseDetails_Rate;
            if ($currentStock > 0) {
                $item->current_stock = $currentStock;
                $item->sizes = self::getColoreSizeWiseStock($productId, $item->Color_SlNo,$branchId);
            }
            return $currentStock > 0 ;
        });
        return $stocks->values()->all();
    }


}