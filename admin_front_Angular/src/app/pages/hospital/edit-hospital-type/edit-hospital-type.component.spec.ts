import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EditHospitalTypeComponent } from './edit-hospital-type.component';

describe('EditHospitalTypeComponent', () => {
  let component: EditHospitalTypeComponent;
  let fixture: ComponentFixture<EditHospitalTypeComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [EditHospitalTypeComponent]
    });
    fixture = TestBed.createComponent(EditHospitalTypeComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
