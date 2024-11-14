export type TransactionBody = {
  amount: number;
  description: string;
  transaction_type: 'income' | 'expense';
}

export interface Transaction {
  id?: string;
  amount: number;
  description: string;
  transactionType: string,
  createdAt?: string;
  userId: string;
}
