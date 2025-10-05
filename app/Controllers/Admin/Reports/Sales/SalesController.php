<?php

namespace App\Controllers\Admin\Reports\Sales;

use App\Controllers\BaseController;
use App\Models\Admin\Sales\OrdersModel;
use App\Models\Admin\Sales\OrdersReturnsModel;
use App\Models\Admin\Sales\OrdersReturnItemsModel;
use App\Models\Admin\Marketing\CouponsUsagesModel;

class SalesController extends BaseController
{
    protected $OrdersModel;
    protected $OrdersReturnsModel;
    protected $OrdersReturnItemsModel;
    protected $CouponsModel;
    protected $CouponsUsagesModel;

    public function __construct()
    {
        $this->OrdersModel = new OrdersModel();
        $this->OrdersReturnsModel = new OrdersReturnsModel();
        $this->OrdersReturnItemsModel = new OrdersReturnItemsModel();
        $this->CouponsUsagesModel = new CouponsUsagesModel();
    }

    public function index()
    {
        $data['report'] = $this->getFinancialReport();
        $data['recentSales'] = $this->getRecentSales(30); // últimos 30 dias
        return view('admin/reports/sales/index', $data);
    }

    /**
     * Calcula o relatório financeiro (vendas, devoluções, cupões)
     */
    public function getFinancialReport()
    {
        $startDate = date('Y-m-d', strtotime('-90 days'));
        $endDate   = date('Y-m-d');
        $sales = $this->OrdersModel
            ->select('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(grand_total) as total_sales')
            ->whereIn('status', ['completed', 'paid'])
            ->where('DATE(created_at) >=', $startDate)
            ->where('DATE(created_at) <=', $endDate)
            ->groupBy('month')
            ->findAll();
        $returns = $this->OrdersReturnsModel
            ->select('DATE_FORMAT(o.created_at, "%Y-%m") as month, SUM(r.refund_amount) as total_returns')
            ->join('orders as o', 'o.id = r.order_id', 'left')
            ->from('orders_returns as r')
            ->whereIn('r.status', ['completed', 'refunded'])
            ->where('DATE(o.created_at) >=', $startDate)
            ->where('DATE(o.created_at) <=', $endDate)
            ->groupBy('month')
            ->findAll();
        $coupons = $this->CouponsUsagesModel
            ->select('DATE_FORMAT(coupon_usages.used_at, "%Y-%m") as month, SUM(coupon_usages.discount_value) as total_coupons')
            ->whereIn('coupon_usages.status', ['applied'])
            ->where('DATE(coupon_usages.used_at) >=', $startDate)
            ->where('DATE(coupon_usages.used_at) <=', $endDate)
            ->groupBy('month')
            ->findAll();
        $report = [];
        foreach ($sales as $s) {
            $report[$s['month']] = [
                'month' => $s['month'],
                'total_sales' => (float) $s['total_sales'],
                'total_returns' => 0,
                'total_coupons' => 0,
            ];
        }
        foreach ($returns as $r) {
            $month = $r['month'];
            if (!isset($report[$month])) {
                $report[$month] = [
                    'month' => $month,
                    'total_sales' => 0,
                    'total_returns' => (float) $r['total_returns'],
                    'total_coupons' => 0,
                ];
            } else {
                $report[$month]['total_returns'] = (float) $r['total_returns'];
            }
        }
        foreach ($coupons as $c) {
            $month = $c['month'];
            if (!isset($report[$month])) {
                $report[$month] = [
                    'month' => $month,
                    'total_sales' => 0,
                    'total_returns' => 0,
                    'total_coupons' => (float) $c['total_coupons'],
                ];
            } else {
                $report[$month]['total_coupons'] = (float) $c['total_coupons'];
            }
        }
        ksort($report);
        return array_values($report);
    }
    public function getRecentSales($days = 40)
    {
        $startDate = date('Y-m-d', strtotime("-{$days} days"));
        $endDate   = date('Y-m-d');

        // Busca as vendas reais
        $sales = $this->OrdersModel
            ->select('DATE(created_at) as date, SUM(grand_total) as total_sales')
            ->whereIn('status', ['completed', 'paid'])
            ->where('DATE(created_at) >=', $startDate)
            ->where('DATE(created_at) <=', $endDate)
            ->groupBy('DATE(created_at)')
            ->orderBy('DATE(created_at)', 'ASC')
            ->findAll();

        // Converte para formato [data => valor]
        $salesMap = [];
        foreach ($sales as $row) {
            $salesMap[$row['date']] = (float) $row['total_sales'];
        }

        // Gera todos os dias, mesmo sem vendas
        $report = [];
        $period = new \DatePeriod(
            new \DateTime($startDate),
            new \DateInterval('P1D'),
            (new \DateTime($endDate))->modify('+1 day')
        );

        foreach ($period as $date) {
            $d = $date->format('Y-m-d');
            $report[] = [
                'date' => $d,
                'total_sales' => $salesMap[$d] ?? 0.00,
            ];
        }

        return $report;
    }


}
