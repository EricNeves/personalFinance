<?php

namespace App\Adapters\Out\Jobs;

use App\Adapters\Out\Persistence\Repositories\BalancePostgresRepository;
use App\Adapters\Out\Persistence\Repositories\ReportPostgresRepository;
use App\Adapters\Out\Persistence\Repositories\TransactionPostgresRepository;
use App\Adapters\Out\Services\UuidGeneratorImplementation;
use App\Domain\Entities\Balance;
use App\Domain\Entities\Report;
use App\Domain\Services\ExportFinancialReportToPDFQueue;
use App\Infrasctructure\Database\Postgres;
use Exception;
use Mpdf\Mpdf;

class ExportFinancialToPDFJob
{
    public function __construct(private readonly ExportFinancialReportToPDFQueue $queue)
    {
    }
    
    public function run(string $key): void
    {
        echo '[+] Job started...'.PHP_EOL;
        
        while (true) {
            try {
                $userId = $this->queue->dequeue($key);
                
                if ($userId) {
                    $transactions = $this->fetchTransactions($userId);
                    $balance      = $this->fetchBalance($userId);
                    
                    $reportPostgresRepository = new ReportPostgresRepository(Postgres::connect());
                    $uuidGeneratorImplementation = new UuidGeneratorImplementation();
                    
                    $html = $this->generateHtml($balance, $transactions);
                    
                    $mpdf = new Mpdf();
                    $mpdf->WriteHTML($html);
                    
                    $binaryFile = base64_encode($mpdf->Output('', 'S'));
                    
                    $report = new Report($uuidGeneratorImplementation->generateV4(), $binaryFile, $userId);
                    
                    $reportPostgresRepository->save($report);
                    
                    echo '[!] Worker DONE.'.PHP_EOL;
                }
            } catch (Exception $e) {
                echo $e->getMessage().PHP_EOL;
            }
        }
    }
    
    private function fetchTransactions(string $userId): array
    {
        $transactionRepository = new TransactionPostgresRepository(Postgres::connect());
        
        return $transactionRepository->all($userId);
    }
    
    private function fetchBalance(string $userId): ?Balance
    {
        $balanceRepository = new BalancePostgresRepository(Postgres::connect());
        
        return $balanceRepository->findByUserId($userId);
    }
    
    private function generateHtml(Balance $balance, array $transactions): string
    {
        $tableTransactionRows = '';
        
        foreach ($transactions as $transaction) {
            $tableTransactionRows .= '
                <tr>
                    <td>' . $transaction['id'] . '</td>
                    <td>' . $transaction['amount'] . '</td>
                    <td>' . $transaction['description'] . '</td>
                    <td>' . $transaction['transaction_type'] . '</td>
                    <td>' . $transaction['user_id'] . '</td>
                    <td>' . $transaction['created_at'] . '</td>
                </tr>
            ';
        }
        
        return '
            <h1>Balance and Transactions Report</h1>
    
            <h2>Balance</h2>
            <table border="1" cellpadding="5" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Balance</th>
                        <th>Income</th>
                        <th>Expense</th>
                        <th>User ID</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>'.$balance->getId().'</td>
                        <td>'.$balance->getBalance().'</td>
                        <td>'.$balance->getIncome().'</td>
                        <td>'.$balance->getExpense().'</td>
                        <td>'.$balance->getId().'</td>
                    </tr>
                </tbody>
            </table>
        
            <h2>Transactions</h2>
            <table border="1" cellpadding="5" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Amount</th>
                        <th>Description</th>
                        <th>Transaction Type</th>
                        <th>User ID</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    ' . $tableTransactionRows . '
                </tbody>
            </table>
        ';
    }
}