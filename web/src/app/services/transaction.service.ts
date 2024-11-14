import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {Transaction, TransactionBody} from "@models/transaction.model";
import {Observable} from "rxjs";
import {environment} from "@environments/environment";
import {Balance} from "@models/balance.model";

@Injectable({
  providedIn: 'root'
})
export class TransactionService {
  constructor(private readonly httpClient: HttpClient) { }

  register(transaction: TransactionBody): Observable<{ data: Balance }> {
    return this.httpClient.post<{ data: Balance }>(`${environment.apiBaseUrl}/transactions/register`, transaction)
  }
}
