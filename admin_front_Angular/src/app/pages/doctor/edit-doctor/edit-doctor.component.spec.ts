import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EditDoctorComponent } from './edit-doctor.component';

describe('EditDoctorComponent', () => {
  let component: EditDoctorComponent;
  let fixture: ComponentFixture<EditDoctorComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [EditDoctorComponent]
    });
    fixture = TestBed.createComponent(EditDoctorComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
