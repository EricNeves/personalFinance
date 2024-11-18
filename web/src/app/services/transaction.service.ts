import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import {Transaction, TransactionBody, Transactions} from "@models/transaction.model";
import { Observable } from "rxjs";
import { environment } from "@environments/environment";
import { Balance } from "@models/balance.model";

@Injectable({
  providedIn: 'root'
})
export class TransactionService {
  constructor(private readonly httpClient: HttpClient) { }

  register(transaction: TransactionBody): Observable<{ data: { transaction: Transaction, balance: Balance } }> {
    return this.httpClient.post<{ data: { transaction: Transaction, balance: Balance } }>(
      `${environment.apiBaseUrl}/transactions/register`, transaction
    )
  }

  all(page: number = 1): Observable<{ data: Transactions }> {
    return this.httpClient.get<{ data: Transactions }>(`${environment.apiBaseUrl}/transactions/fetch?page=${page}`)
  }

  remove(transactionId: string): Observable<{ data: { transaction: Transaction, balance: Balance } }> {
    return this.httpClient.delete<{ data: { transaction: Transaction, balance: Balance } }>(
      `${environment.apiBaseUrl}/transactions/${transactionId}/remove`
    )
  }
}
