import {Component, OnInit} from '@angular/core';

import {Router, RouterLink} from "@angular/router";

import { AvatarModule } from 'primeng/avatar';
import { MenuItem } from "primeng/api";
import { MenuModule } from 'primeng/menu';
import { ButtonModule } from "primeng/button";
import { StorageService } from "@services/storage.service";
import { UserService } from "@services/user.service";

import { MessageService } from "primeng/api";
import {ToastModule} from "primeng/toast";
import {User} from "@models/user.model";

@Component({
  selector: 'app-menubar',
  standalone: true,
  imports: [
    RouterLink,
    AvatarModule,
    MenuModule,
    ButtonModule,
    ToastModule,
  ],
  templateUrl: './menubar.component.html',
  styleUrl: './menubar.component.css',
  providers: [MessageService]
})
export class MenubarComponent implements OnInit {
  menuItems: MenuItem[] | undefined;

  user!: User;

  ngOnInit() {
    this.menuItems = [
      {
        label: 'Profile',
        items: [
          {
            label: 'Change username',
            icon: 'pi pi-user-edit'
          },
          {
            label: 'Change Password',
            icon: 'pi pi-shield'
          }
        ]
      },
      {
        label: 'Data',
        items: [
          {
            label: 'Export to PDF',
            icon: 'pi pi-file-pdf'
          }
        ]
      },
      {
        label: 'Sign Out',
        items: [
          {
            label: 'Logout',
            icon: 'pi pi-sign-out',
            command: () => this.logout()
          }
        ]
      }
    ];

    this.userService.user().subscribe({
      next: (response) => {
        this.user = response.data
      },
      error: (error: any) => {
        this.messageService.add({
          severity: 'warn',
          summary: 'Warning',
          detail: error.error.message,
        })

        this.logout()
      }
    })
  }

  constructor(
    private readonly storageService: StorageService,
    private readonly router: Router,
    private readonly userService: UserService,
    private readonly messageService: MessageService
  ) {
  }

  logout(): void {
    this.storageService.removeData('jwt')
    this.router.navigate(['/'])
  }
}
