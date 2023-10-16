import { Component, OnInit, OnChanges, Input, ChangeDetectorRef, ViewChild, AfterViewChecked, AfterViewInit   } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { MatPaginator,PageEvent } from '@angular/material/paginator';
import { ConfirmationService, MessageService, ConfirmEventType } from 'primeng/api';

@Component({
  selector: 'app-pharmecy-list',
  templateUrl: './pharmecy-list.component.html',
  styleUrls: ['./pharmecy-list.component.scss'],
  providers: [ConfirmationService, MessageService]
})
export class PharmecyListComponent {
  @ViewChild(MatPaginator) paginator: MatPaginator;
  @Input() tableData: any[];
  pageSize : number ;
  search_result: any[];
  search_index: string = "";
  scr : string = environment.url + "uploads/pharmacies/";
  default: string = environment.url+ "assets/frontend/images/general/doctorak_default_logo_img.png";
  loading_flag : boolean;

  constructor(private http: HttpClient, private cdr: ChangeDetectorRef, private confirmationService: ConfirmationService, private messageService: MessageService) {}
  ngOnInit(): void {
    this.loading_flag = true;
    this.cdr.detectChanges();
    this.http.get<any>(environment.apiUrl + "pharmacy/list").
      subscribe((response) => {        
        this.tableData = response.pharmacies["data"];
        this.paginator.pageSize = response.pharmacies["per_page"];
        this.paginator.length = response.pharmacies["total"];
        this.loading_flag = false;
        this.cdr.detectChanges();
      });
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
      this.loading_flag = true;
      this.cdr.detectChanges();
      this.http.post<any>(environment.apiUrl + "pharmacy/table", {"search_index": this.search_index.toString()})   
          .subscribe((response)=>{
            this.tableData = response.search_result;
            this.paginator.pageSize = response.search_result.length;
            this.paginator.length = response.search_result.length;
            this.loading_flag= false;
            this.cdr.detectChanges(); // Manually trigger change detection
            
          })   
    }
  }
  pageChange(){
    if(this.paginator.pageIndex == 0 && this.paginator.pageSize == 10){
      this.pageSize = 10;
      this.ngOnInit();
    }else{
      this.loading_flag = true;
      this.cdr.detectChanges();
      this.http.post<any>(environment.apiUrl + "pharmacy/table", {
        params: new HttpParams()
          .set('pageSize', this.paginator.pageSize.toString())
          .set('pageIndex', this.paginator.pageIndex.toString())
      }).subscribe((response)=>{
        this.tableData = response.search_result["data"];
        this.paginator.pageSize = response.search_result["per_page"];
        this.paginator.length = response.search_result["total"];
        this.paginator.pageIndex = response.search_result["current_page"]-1;
        this.loading_flag = false;
        this.cdr.detectChanges(); // Manually trigger change detection
      })
    }
  }

  //delete the data

  delete(id: number){
    this.confirmationService.confirm({
        message: 'Are you sure to delete?"',
        header: 'Delete Confirmation',
        icon: 'pi pi-info-circle',
        accept: () => {
          this.http.get<any>(environment.apiUrl+ "pharmacy/delete/" + id)
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