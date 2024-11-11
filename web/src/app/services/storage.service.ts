import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class StorageService {
  setData(key: string, data: any): void {
    localStorage.setItem(key, JSON.stringify(data))
  }

  getData(key: string): any {
    const data = localStorage.getItem(key);

    if (data) {
      return JSON.parse(data)
    }

    return null;
  }

  removeData(key: string): void {
    localStorage.removeItem(key)
  }
}
