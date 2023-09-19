import { Component,  OnInit, ChangeDetectorRef } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { Router } from '@angular/router';
import { MessageService } from 'primeng/api';
import { PrimeNGConfig } from 'primeng/api';

@Component({
  selector: 'app-create-role',
  templateUrl: './create-role.component.html',
  styleUrls: ['./create-role.component.scss'],
  providers: [MessageService]

})
export class CreateRoleComponent implements OnInit {
  //binding valuable
  name : string = "";
  label : string = "";
  errorMessage1 : string = "";
  errorMessage2 : string = "";
  role_permissions : string[] = [];
  checkedPermissions: any[] = [];

  //response data 
  permission_data: any[];

  group : string [] =[];
  constructor(
    private http: HttpClient, 
    private cdr: ChangeDetectorRef,
    private router: Router,
    private messageService: MessageService, private primengConfig: PrimeNGConfig
  ) {}
  ngOnInit(): void {
    this.http.get<any>(environment.apiUrl+"permission-config")
    .subscribe((response)=>{
      this.permission_data = response.admin;
      console.log(this.permission_data);
      this.cdr.detectChanges(); // Manually trigger change detection
    })
  }

  handleCheckboxChange(permission: any, i: number, j: number) {
    const permissionId = 'permission-' + i + '-' + j;
    const index = this.checkedPermissions.indexOf(permissionId);

    if (index !== -1) {
      // If permissionId exists, remove it from checkedPermissions
      this.checkedPermissions.splice(index, 1);
    } else {
      // If permissionId doesn't exist, add it to checkedPermissions
      this.checkedPermissions.push(permissionId);
    }
  }

  create(){
    if(this.name == "" || this.label == ""){
      if(this.name == "")
        this.errorMessage1 = "*please enter the name";
      if(this.label == ""){
        this.errorMessage2 = "*please enther the label";
      }
      this.showWarn();
      return;
    }
    const formData =new FormData();
    formData.append("name", this.name);
    formData.append("label", this.label);

    for(let i = 0 ; i < this.checkedPermissions.length ; i++){
      let matches = this.checkedPermissions[i].match(/\d+/g); // Extracts all numbers from the string
      let [m, n] = matches.map(Number); // Converts the extracted numbers to actual numbers and assigns them to 
      let string;
      string = "admin." + this.permission_data[m]['key'] + "." + this.permission_data[m]['permissions'][n]['key'];
      this.role_permissions.push(string);
      formData.append("roles_premissions[]", string);
    }
    
    this.http.post<any>(environment.apiUrl + "role/store", formData)
        .subscribe((response)=>{
          if(response.id){
            this.router.navigate(['role/list']);
          }
        }, (error)=>{
          this.showError();
        });
  }
  showWarn() {
    this.messageService.clear();
    this.messageService.add({ severity: 'warn', summary: 'Warn', detail: 'Please input the parameter correctly!' });
  }
  showError() {
    this.messageService.add({ severity: 'error', summary: 'Error', detail: 'Inserting Data, Error!' });
  }
  showSuccess() {
    this.messageService.add({ severity: 'success', summary: 'Success', detail: 'Success' });
  }
}
