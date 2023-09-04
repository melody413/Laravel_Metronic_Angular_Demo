import { Component,  OnInit, ChangeDetectorRef } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-edit-role',
  templateUrl: './edit-role.component.html',
  styleUrls: ['./edit-role.component.scss']
})
export class EditRoleComponent {
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

  role: any;
  role_id: number;
  permissions: string[] = [];
  constructor(private http: HttpClient, private cdr: ChangeDetectorRef,private router: Router, private route: ActivatedRoute,) {}

  ngOnInit(): void {
    this.route.params.subscribe(params => {
      this.role_id = params['id'];
    });
    this.http.get<any>(environment.apiUrl+"permission-config")
    .subscribe((response)=>{
      this.permission_data = response.admin;
      this.cdr.detectChanges(); // Manually trigger change detection
    })
    this.http.get<any>(environment.apiUrl + "role/edit/" + this.role_id)
      .subscribe((response)=>{
        this.role = response.item;
        this.name = this.role.name;
        this.label = this.role.label;
        this.permissions = Object.values(response.permissions);
        this.role_permissions = (this.permissions);
        this.cdr.detectChanges();
      });
  }

  checkpermission(page: string, permission: string){
    if(page == "settings"){ console.log(page + permission)}
    return this.permissions.some(item => item.includes(page) && item.includes(permission));
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
    if(this.name === "" || this.label === ""){
      if(this.name === "")
        this.errorMessage1 = "*please enter the name";
      if(this.label === ""){
        this.errorMessage2 = "*please enther the label";
      }
      return;
    }
    const formData =new FormData();
    formData.append("item_id", this.role_id.toString());
    formData.append("name", this.name);
    formData.append("label", this.label);

    for(let i = 0 ; i < this.checkedPermissions.length ; i++){
      let matches = this.checkedPermissions[i].match(/\d+/g); // Extracts all numbers from the string
      let [m, n] = matches.map(Number); // Converts the extracted numbers to actual numbers and assigns them to 
      let string;
      string = "admin." + this.permission_data[m]['key'] + "." + this.permission_data[m]['permissions'][n]['key'];
      this.role_permissions.push(string);
      
    }

    for(let i = 0 ; i < this.role_permissions.length ; i++){
      if(this.role_permissions[i])
        formData.append("roles_premissions[]", this.role_permissions[i]);
    }
    
    this.http.post<any>(environment.apiUrl + "role/store", formData)
        .subscribe((response)=>{
          if(response.id){
            this.router.navigate(['role/list']);
          }else{
            alert("error");
          }
        });
  }

}
