import { CanActivateFn } from '@angular/router';
import { inject } from "@angular/core";
import { UserService } from "@services/user.service";

export const ensureAuthenticatedGuard: CanActivateFn = (route, state) => {
  const userService = inject(UserService)

  userService.user().subscribe({})

  return true;
};
