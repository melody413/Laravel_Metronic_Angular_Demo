import { Component } from '@angular/core';

@Component({
  selector: 'app-create-speciality',
  templateUrl: './create-speciality.component.html',
  styleUrls: ['./create-speciality.component.scss']
})
export class CreateSpecialityComponent {

  //directive valuable
  question_ar: string = " ";
  question_en: string = " ";
  errorMessage1: string= " ";
  errorMessage2: string= " ";
}
