import { Component, OnInit, OnChanges, Input, ChangeDetectorRef, ViewChild, AfterViewChecked, AfterViewInit   } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { MatPaginator,PageEvent } from '@angular/material/paginator';
import { ConfirmationService, MessageService, ConfirmEventType } from 'primeng/api';

@Component({
  selector: 'app-user-list',
  templateUrl: './user-list.component.html',
  styleUrls: ['./user-list.component.scss'],
  providers: [ConfirmationService, MessageService]

})
export class UserListComponent implements OnInit{
  @ViewChild(MatPaginator) paginator: MatPaginator;
  @Input() tableData: any[];
  pageSize : number ;
  search_result: any[];
  search_index: string = "";  
  category_type: number = 0;

  constructor(private http: HttpClient, private cdr: ChangeDetectorRef, private confirmationService: ConfirmationService, private messageService: MessageService) {}
  ngOnInit(): void {
    this.http.get<any>(environment.apiUrl + "user/list").
      subscribe((response) => {        
        this.tableData = response.users["data"];
        this.paginator.pageSize = response.users["per_page"];
        this.pageSize = response.users["per_page"];
        this.paginator.length = response.users["total"];
      });
  }

  getTypeString(type: number): string {
    switch (type) {
      case 1:
        return "user";
      case 2:
        return "doctor";
      case 3:
        return "admin";
      case 4:
        return "moderator";
      default:
        return "";
    }
  }
  

  onPageChange(event: any) {
    this.pageChange();
  }

  onSelectChange(event : any) {
    this.pageSize = event.target.value;
    this.paginator.pageSize = event.target.value;
    this.paginator.pageIndex = 0;
    this.pageChange();
  }

  //search with the index
  search(){
    if(this.search_index == ""){
      this.ngOnInit();
    }else{
      this.http.post<any>(environment.apiUrl + "user/table", {"search_index": this.search_index.toString()})   
          .subscribe((response)=>{
            this.tableData = response.search_result;
            this.paginator.pageSize = response.search_result.length;
            this.paginator.length = response.search_result.length;
            this.paginator.pageIndex = response.search_result["current_page"]-1;
            this.cdr.detectChanges(); // Manually trigger change detection
          })   
    }
  }
  pageChange(){
    if(this.category_type == 0){
      if(this.paginator.pageIndex == 0 && this.paginator.pageSize == 10){
        this.pageSize = 10;
        this.ngOnInit();
      }else{
        this.http.post<any>(environment.apiUrl + "user/table", {
          params: new HttpParams()
            .set('pageSize', this.paginator.pageSize.toString())
            .set('pageIndex', this.paginator.pageIndex.toString())
        }).subscribe((response)=>{
          this.tableData = response.search_result["data"];
          this.paginator.pageSize = response.search_result["per_page"];
          this.paginator.length = response.search_result["total"];
          this.paginator.pageIndex = response.search_result["current_page"]-1;
          this.cdr.detectChanges(); // Manually trigger change detection
        })
      }
    }else{
      this.categoryChange();
    }
    
  }
  categoryChange(){
    if(this.category_type == 1){
      this.http.get<any>(environment.apiUrl + "user/index_users?page=" + (this.paginator.pageIndex+1) + "#users")
      .subscribe((response)=>{
        this.tableData = response.dr_users["data"];
        this.paginator.pageSize = response.dr_users["per_page"];
        this.paginator.length = response.dr_users["total"];
        this.paginator.pageIndex = response.dr_users["current_page"]-1;
        this.cdr.detectChanges(); // Manually trigger change detection
      });
    }
    else if(this.category_type == 2){
      this.http.get<any>(environment.apiUrl + "user/index_doctors?page=" + (this.paginator.pageIndex+1) + "#users")
      .subscribe((response)=>{
        this.tableData = response.dr_users["data"];
        this.paginator.pageSize = response.dr_users["per_page"];
        this.paginator.length = response.dr_users["total"];
        this.paginator.pageIndex = response.dr_users["current_page"]-1;
        this.cdr.detectChanges(); // Manually trigger change detection
      });
    }
    else if(this.category_type == 3){
      this.http.get<any>(environment.apiUrl + "user/index_admin?page=" + (this.paginator.pageIndex+1) + "#users")
      .subscribe((response)=>{
        this.tableData = response.dr_users["data"];
        this.paginator.pageSize = response.dr_users["per_page"];
        this.paginator.length = response.dr_users["total"];
        this.paginator.pageIndex = response.dr_users["current_page"]-1;
        this.cdr.detectChanges(); // Manually trigger change detection
      });
    }
    else if(this.category_type == 4){
      this.http.get<any>(environment.apiUrl + "user/index_moderator?page=" + (this.paginator.pageIndex+1) + "#users")
      .subscribe((response)=>{
        this.tableData = response.dr_users["data"];
        this.paginator.pageSize = response.dr_users["per_page"];
        this.paginator.length = response.dr_users["total"];
        this.paginator.pageIndex = response.dr_users["current_page"]-1;
        this.cdr.detectChanges(); // Manually trigger change detection
      });
    }
    else if(this.category_type == 0) {
      this.ngOnInit();
    }
  }
  //delete the data
  delete(id: number){
    this.confirmationService.confirm({
        message: 'Are you sure to delete?"',
        header: 'Delete Confirmation',
        icon: 'pi pi-info-circle',
        accept: () => {
          this.http.get<any>(environment.apiUrl+ "user/delete/" + id)
          .subscribe((response)=>{
            if(response.flash_type == "success"){
              this.messageService.add({ severity: 'info', summary: 'Confirmed', detail: 'Record deleted' });
              this.ngOnInit();
            }else{
              this.messageService.add({ severity: 'error', summary: 'Error', detail: 'server Error' });
            }
          })
        },
        reject: (type:any) => {
            switch (type) {
                case ConfirmEventType.REJECT:
                  this.messageService.add({ severity: 'error', summary: 'Rejected', detail: 'You have rejected' });
                  break;
                case ConfirmEventType.CANCEL:
                    this.messageService.add({ severity: 'warn', summary: 'Cancelled', detail: 'You have cancelled' });
                    break;
            }
        }
    });
  }
}


