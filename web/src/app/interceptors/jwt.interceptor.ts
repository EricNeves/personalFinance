import { HttpInterceptorFn } from '@angular/common/http';
import { inject } from "@angular/core";
import { StorageService } from "@services/storage.service";
import {catchError, throwError} from "rxjs";
import {Router} from "@angular/router";

export const jwtInterceptor: HttpInterceptorFn = (req, next) => {
  const storageService = inject(StorageService)
  const router = inject(Router)

  const jwt = storageService.getData('jwt')

  if (!jwt && !req.url.includes('users/register')) {
    storageService.removeData('jwt')

    router.navigate(['/'])
  }

  const reqCloned = req.clone({
    setHeaders: {
      Authorization: `Bearer ${jwt}`
    }
  })

  return next(reqCloned).pipe(
    catchError(function (error: any) {
      if (error.status === 401 && !reqCloned.url.includes('users/register')) {
        storageService.removeData('jwt')

        router.navigate(['/'])
      }

      return throwError(() => error);
    }),
  );
};
