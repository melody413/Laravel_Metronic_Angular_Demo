import { Injectable } from "@angular/core";
import { Observable, BehaviorSubject } from "rxjs";
import { filter } from "rxjs/operators";
import { ToastType } from "./toast.type";
import { Toast } from "./toast.interface";

@Injectable({
  providedIn: "root"
})
export class ToastService {
  subject: BehaviorSubject<Toast>;
  toast$: Observable<Toast>;

//   constructor() {
//     this.subject = new BehaviorSubject<Toast>(null);
//     this.toast$ = this.subject
//       .asObservable()
//       .pipe(filter((toast) => toast !== null));
//   }

//   show(type: ToastType, title?: string, body?: string, delay?: number) {
//     this.subject.next({ type, title, body, delay });
//   }
}
