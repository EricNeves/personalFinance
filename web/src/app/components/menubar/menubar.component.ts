import {Component, OnInit} from '@angular/core';

import {Router, RouterLink} from "@angular/router";

import { AvatarModule } from 'primeng/avatar';
import { MenuItem } from "primeng/api";
import { MenuModule } from 'primeng/menu';
import { ButtonModule } from "primeng/button";
import { StorageService } from "@services/storage.service";

@Component({
  selector: 'app-menubar',
  standalone: true,
  imports: [
    RouterLink,
    AvatarModule,
    MenuModule,
    ButtonModule
  ],
  templateUrl: './menubar.component.html',
  styleUrl: './menubar.component.css'
})
export class MenubarComponent implements OnInit {
  menuItems: MenuItem[] | undefined;

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
  }

  constructor(
    private readonly storageService: StorageService,
    private readonly router: Router
  ) {
  }

  logout(): void {
    this.storageService.removeData('jwt')
    this.router.navigate(['/'])
  }
}
