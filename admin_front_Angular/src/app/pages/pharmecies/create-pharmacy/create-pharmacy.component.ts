import { Component } from '@angular/core';

@Component({
  selector: 'app-create-pharmacy',
  templateUrl: './create-pharmacy.component.html',
  styleUrls: ['./create-pharmacy.component.scss'],
})
export class CreatePharmacyComponent {
  desItems = [{ title: 'Description' }];
  fileName = '';
  // constructor(private http: HttpClient) {}
  onFileSelected(event: any) {
    const file: File = event.target.files[0];

    if (file) {
      this.fileName = file.name;
      console.log(this.fileName);
      const formData = new FormData();
      formData.append('thumbnail', file);
      // const upload$ = this.http.post('/api/thumbnail-upload', formData);
      // upload$.subscribe();
    }
  }
}