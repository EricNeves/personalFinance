import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { User } from "@models/user.model";
import { Observable } from "rxjs";
import { environment } from "@environments/environment";

@Injectable({
  providedIn: 'root'
})
export class UserService {
  constructor(private readonly httpClient: HttpClient) { }

  register(user: User): Observable<{ data: User }> {
    return this.httpClient.post<{ data: User }>(`${environment.apiBaseUrl}/users/register`, user)
  }

  authenticate(user: Partial<User>): Observable<{ data: string }> {
    return this.httpClient.post<{ data: string }>(`${environment.apiBaseUrl}/users/authenticate`, user)
  }

  user(): Observable<{ data: User }> {
    return this.httpClient.get<{ data: User }>(`${environment.apiBaseUrl}/users/fetch`)
  }

  editUsername(name: string): Observable<{ data: User }> {
    return this.httpClient.put<{ data: User }>(`${environment.apiBaseUrl}/users/info/edit`, { name })
  }

  editPassword(old_password: string, new_password: string): Observable<{ data: string }> {
    return this.httpClient.put<{ data: string }>(`${environment.apiBaseUrl}/users/change-password`, { old_password, new_password })
  }
}
