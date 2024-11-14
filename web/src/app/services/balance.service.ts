import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {Observable} from "rxjs";
import {Balance} from "@models/balance.model";
import {environment} from "@environments/environment";

@Injectable({
  providedIn: 'root'
})
export class BalanceService {
  constructor(private readonly httpClient: HttpClient) { }

  balance(): Observable<{ data: Balance }> {
    return this.httpClient.get<{ data: Balance }>(`${environment.apiBaseUrl}/users/balance/fetch`)
  }
}
