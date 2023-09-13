import { Component, OnInit, OnChanges, Input, ChangeDetectorRef, ViewChild, AfterViewChecked, AfterViewInit   } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { MatPaginator,PageEvent } from '@angular/material/paginator';
import { ActivatedRoute, Router } from '@angular/router';
@Component({
  selector: 'app-doctor-branch',
  templateUrl: './doctor-branch.component.html',
  styleUrls: ['./doctor-branch.component.scss']
})
export class DoctorBranchComponent {

  @ViewChild(MatPaginator) paginator: MatPaginator;
  @Input() tableData: any[];
  pageSize : number ;
  search_result: any[];
  search_index: string = "";
  doctor_id: number;
  weekend: string[] = ['San','Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
  work_days: boolean[] = [];
  constructor(private http: HttpClient, private crd: ChangeDetectorRef,private router: Router, private route: ActivatedRoute,) {}

  ngOnInit(): void {
    this.route.params.subscribe(params => {
      this.doctor_id = params['id'];
    });
    this.http.get<any>(environment.apiUrl + "doctor/branch/" + this.doctor_id).
      subscribe((response) => {       
        if(response.result){
          this.tableData = response.result.data;
          this.paginator.pageSize = response.result["recordsTotal"];
          this.paginator.length = response.result["recordsTotal"];
          this.paginator.pageIndex = 0;
          this.crd.detectChanges(); // Manually trigger change detection
        } 
        console.log(this.tableData);
        
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
      this.http.post<any>(environment.apiUrl + "doctor/table", {"search_index": this.search_index.toString()})   
          .subscribe((response)=>{
            this.tableData = response.search_result;
            this.paginator.pageSize = response.search_result.length;
            this.paginator.length = response.search_result.length;
            this.paginator.pageIndex = response.search_result["current_page"]-1;
            this.crd.detectChanges(); // Manually trigger change detection
            
          })   
    }
  }
  pageChange(){
    if(this.paginator.pageIndex == 0 && this.paginator.pageSize == 10){
      this.pageSize = 10;
      this.ngOnInit();
    }else{
      this.http.post<any>(environment.apiUrl + "doctor/table", {
        params: new HttpParams()
          .set('pageSize', this.paginator.pageSize.toString())
          .set('pageIndex', this.paginator.pageIndex.toString())
      }).subscribe((response)=>{
        this.tableData = response.search_result["data"];
        this.paginator.pageSize = response.search_result["per_page"];
        this.paginator.length = response.search_result["total"];
        this.paginator.pageIndex = response.search_result["current_page"]-1;
        this.crd.detectChanges(); // Manually trigger change detection
      })
    }
  }

  convertString(tmp: string){
    let result = "" ; 
    this.work_days = tmp.split("").map(char => char === "1");
    for(let i = 0 ; i < 7 ; i++){
      if(this.work_days[i]){
        result += this.weekend[i] + ",";
      }
    }
    if(result == ""){
      result = "No available";
    }
    return result;
  }
  //delete the data
  delete(id: number){
    if(confirm("Are your really delete this data?")){
      this.http.get<any>(environment.apiUrl+ "doctor/branch/delete/" + id)
      .subscribe((response)=>{
        this.ngOnInit();
      })
    }
    
  }
}
